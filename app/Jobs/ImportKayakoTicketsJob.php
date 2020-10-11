<?php

namespace App\Jobs;

use App\Services\ImportKayakoService;
use App\Services\TicketsServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportKayakoTicketsJob implements ShouldQueue
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
        $ImportKayakoService = ImportKayakoService::getApi($this->service_id);
        if (empty($ImportKayakoService)) {
            return;
        }

        $ImportKayakoService->getDepartment();
        $there_is_tickets = $ImportKayakoService->allTickets($this->page, $this->per_page);
        if (!$there_is_tickets) {
            return;
        }

        if (!empty($page_params = $ImportKayakoService->nextPage())) {
            dispatch(new ImportZendeskTicketsJob($this->service_id, $this->page++, $this->per_page));
        }

        foreach ($ImportKayakoService->tickets() as $kyTicket) {

            $user = $ImportKayakoService->ticketUser($kyTicket, $this->service_id);

            $ticket = TicketsServices::updateOrCreateNew(
                $kyTicket->getId(), 
                $this->service_id, 
                $user->api_id,
                $ImportKayakoService->adapter_ticket($kyTicket),
                $kyTicket->getCreationTime()
            );

            /* if (!empty($kyTicket->getUserId())) {
                $ImportKayakoService->user($kyTicket->getUserId(), $this->service_id);
            } */
            

            dispatch(new ImportKayakoTicketCommentsJob($ticket));
        }
    }
}
