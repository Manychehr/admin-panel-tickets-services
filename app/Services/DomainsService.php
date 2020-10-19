<?php 

namespace App\Services;

use App\Models\Domain;
use Carbon\Carbon;

class DomainsService
{
    public static function updateOrCreate($host, $ticket_id, $rank)
    {
        return Domain::updateOrCreate(
            ['host' => $host, 'ticket_id' => $ticket_id],
            ['rank' => $rank, 'created_at' => new Carbon()]
        );
    }

    public static function findApiHost($host, $ticket_id)
    {
        return Domain::where('host', $host)->where('ticket_id', $ticket_id)->first();
    }

    public static function parsDomains($str, $ticket_id)
    {
        $domains = ParsService::domain($str);
        if (empty($domains)) {
            return false;
        }

        $alexaRanking = new AlexaRanking;
        foreach ($domains as $domain) {
            self::updateOrCreate($domain, $ticket_id, $alexaRanking->getRank($domain));
        }
        
        return true;
    }

    public static function update_day($days, $limit)
    {
        $domains = self::get_domains($days, $limit);
        
        if (empty($domains)) {
            return false;
        }

        $alexaRanking = new AlexaRanking;
        foreach ($domains as $domain) {
            Domain::where('host', $domain->host)
                    ->update([
                        'rank' => $alexaRanking->getRank($domain->host),
                        'updated_at' => new Carbon()
                    ]);
        }

        return $domains;
    }

    public static function get_domains($days, $limit)
    {
        return Domain::where('updated_at','<', \Carbon\Carbon::now()->addDays($days))
                    ->orderBy('updated_at','desc')
                    ->groupBy(['host'])
                    ->limit($limit)
                    ->get();
    }

    public static function get_domains_count($days)
    {
        return Domain::where('updated_at','<', \Carbon\Carbon::now()->addDays($days))->count();
    }

    public static function get_count()
    {
        return Domain::count();
    }
}
