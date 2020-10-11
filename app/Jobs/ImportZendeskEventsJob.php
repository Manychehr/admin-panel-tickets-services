<?php

namespace App\Jobs;

use App\Services\ImportZendeskService;
use App\Services\TicketsServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportZendeskEventsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $service_id;
    protected $page;
    protected $per_page;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($service_id, $page=1, $per_page=100)
    {
        $this->service_id = $service_id;
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
        $importZendeskService = ImportZendeskService::getApi();
        if (empty($importZendeskService)) {
            return;
        }

        $there_is_tickets = $importZendeskService->allTickets($this->page, $this->per_page);
        if (!$there_is_tickets) {
            return;
        }

        if (!empty($page_params = $importZendeskService->nextPage())) {
            dispatch(new ImportZendeskEventsJob($this->service_id, $page_params['page'], $this->per_page));
        }

        foreach ($importZendeskService->tickets() as $import_ticket) {
            // $ticket = TicketsServices::updateOrCreate($import_ticket, $this->service_id);
            // dispatch(new ImportZendeskTicketCommentsJob($ticket));
        }
    }
}
