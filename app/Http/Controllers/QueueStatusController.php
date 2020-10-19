<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Website;
use App\Models\Subdomain;
use App\Models\Url;
use App\Services\DomainsService;
use App\Services\DomainUpdateService;
use Illuminate\Support\Facades\DB;

class QueueStatusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* dd(Website::where('blacklist', false)
        ->where('updated_at','<', \Carbon\Carbon::now()->addDays(-1))
        ->orderBy('updated_at','desc')
        ->limit(5)
        ->get()); */
        /* DomainUpdateService::updateDay(5); */
        $block_title = 'Queue List';
        $jsroute = 'queue.index';

        $jobs = DB::table('jobs')->count();
        $failed_jobs = DB::table('failed_jobs')->count();

        $cron_domains = DomainsService::get_domains_count(-30);

        $domains_count = DomainsService::get_count();
        // Website::orderBy('created_at','desc')->limit(3)->get();
        /* $subdomains = Subdomain::orderBy('created_at','desc')->limit(3)->get();
        $urls = Url::orderBy('created_at','desc')->limit(3)->get();
        $cronWebsite = Website::where('blacklist', false)->where('updated_at','<', \Carbon\Carbon::now()->addDays(-1))->count();
         */
        
        /* $updateWebsite = Website::orderBy('updated_at','desc')->limit(3)->get();
        $updateSubdomain = Subdomain::orderBy('updated_at','desc')->limit(3)->get(); */

        return view('queue', compact('jobs', 'failed_jobs', 'cron_domains', 'domains_count'));
    }
}