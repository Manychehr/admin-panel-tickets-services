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
use App\Services\ImportKayakoService;
use App\Services\IpAddressService;
use App\Services\ParsService;

class ImportKayakoTicketCommentsJob implements ShouldQueue
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ImportKayakoService = ImportKayakoService::getApi($this->ticket->service_id);
        if (empty($ImportKayakoService)) {
            return;
        }

        $there_is_tickets = $ImportKayakoService->allTicketComments($this->ticket->api_id);
        if (!$there_is_tickets) {
            return;
        }

        $attachments = $ImportKayakoService->allAttachments($this->ticket->api_id)?? [];
        $prohibited_schemes = false;
        /**
         * @var \App\KayakoApi\kyTicketPost $kyTicketPost
         */
        foreach ($ImportKayakoService->comments() as $kyTicketPost) {

            $user = $ImportKayakoService->commentUser($kyTicketPost, $this->ticket->service_id);

            $data = $ImportKayakoService->adapter_comments($kyTicketPost, $attachments);
            CommentsService::updateOrCreateNew(
                $kyTicketPost->getId(), 
                $this->ticket->api_id, 
                $user->api_id, // $kyTicketPost->getUserId(),
                $this->ticket->service_id,
                $data
            );

            DomainsService::parsDomains($data['html_body'], $this->ticket->api_id);
            IpAddressService::parsIpAddress($data['html_body'], $this->ticket->api_id);

            if (ParsService::prohibitedSchemes($data['html_body'])) {
                $prohibited_schemes = true;
            }
            
            /* if (!empty($kyTicketPost->getUserId())) {
                $ImportKayakoService->user($kyTicketPost->getUserId(), $this->ticket->service_id);
            } */
        }

        $this->ticket->in_scheme = $prohibited_schemes;
        $this->ticket->save();

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
