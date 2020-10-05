<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Ticket;
use App\Services\AuthorsService;
use App\Services\CommentsService;
use App\Services\DomainsService;
use App\Services\ImportZendeskService;
use App\Services\IpAddressService;
use App\Services\ParsService;

class ImportZendeskTicketCommentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Количество раз, которое можно попробовать выполнить задачу.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Количество секунд, во время которых может выполняться задача до таймаута.
     *
     * @var int
     */
    public $timeout = 120000;

    /**
     * @var \App\Models\Ticket
     */
    protected $ticket;

    protected $page;
    protected $per_page;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, $page=1, $per_page=100)
    {
        $this->ticket = $ticket;
        $this->page = $page;
        $this->per_page = $per_page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $importZendeskService = ImportZendeskService::getApi($this->ticket->service_id);
        if (empty($importZendeskService)) {
            return;
        }

        $there_is_tickets = $importZendeskService->allTicketComments($this->ticket->api_id, $this->page, $this->per_page);
        if (!$there_is_tickets) {
            return;
        }

        if (!empty($page_params = $importZendeskService->nextPage())) {
            dispatch(new ImportZendeskEventsJob($this->service_id, $page_params['page'], $this->per_page));
        }

        $prohibited_schemes = false;
        foreach ($importZendeskService->comments() as $import_comment) {

            CommentsService::updateOrCreate($import_comment, $this->ticket->api_id, $this->ticket->service_id);
            DomainsService::parsDomains($import_comment->body, $this->ticket->api_id);
            IpAddressService::parsIpAddress($import_comment->body, $this->ticket->api_id);

            if (ParsService::prohibitedSchemes($import_comment->body)) {
                $prohibited_schemes = true;
            }
        }

        $this->ticket->in_scheme = $prohibited_schemes;
        $this->ticket->save();

        foreach ($importZendeskService->users() as $author) {
            AuthorsService::updateOrCreate($author, $this->ticket->service_id);
        }
    }

    /**
     * Неудачная обработка задачи.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        // DomainImportService::errorImport('DomainImportJob', $exception->getMessage());
    }
}
