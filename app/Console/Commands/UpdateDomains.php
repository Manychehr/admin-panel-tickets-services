<?php

namespace App\Console\Commands;

use App\Services\DomainsService;
use Illuminate\Console\Command;

class UpdateDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:domains';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Update Domains';

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
        DomainsService::update_day(-30, 5);
        return 0;
    }
}
