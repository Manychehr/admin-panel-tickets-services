<?php

namespace App\Jobs;

use App\Services\ImportZendeskService;
use App\Services\TicketsServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\ImportZendeskTicketCommentsJob;

class UpdateZendeskTicketsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $service_id;
    protected $page;
    protected $limitTime;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($service_id, $limitTime='-1 day', $page=1)
    {
        $this->service_id = $service_id;
        $this->page = $page;
        $this->limitTime = $limitTime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $importZendeskService = ImportZendeskService::getApi($this->service_id);
        if (empty($importZendeskService)) {
            return;
        }

        $there_is_tickets = $importZendeskService->getLastActivity($this->limitTime, $this->page);
        if (!$there_is_tickets) {
            return;
        }

        if (!empty($page_params = $importZendeskService->searchNextPage())) {
            dispatch(new UpdateZendeskTicketsJob($this->service_id, $this->limitTime, $page_params['page']));
        }

        foreach ($importZendeskService->searchResults() as $import_ticket) {
            $ticket = TicketsServices::updateOrCreate($import_ticket, $this->service_id);
            dispatch(new ImportZendeskTicketCommentsJob($ticket, 1, 500));
        }
    }
}
