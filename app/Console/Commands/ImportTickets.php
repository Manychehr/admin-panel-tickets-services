<?php

namespace App\Console\Commands;

use App\Models\ApiTicket;
use App\Services\ApiTicketsService;
use App\Services\DomainsService;
use Illuminate\Console\Command;

class ImportTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Import Tickets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ApiTicketsService::importAll();
        return 0;
    }
}
