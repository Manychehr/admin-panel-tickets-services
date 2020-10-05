<?php 

namespace App\Services;

use App\Models\IpAddress;

class IpAddressService
{
    public static function updateOrCreate($ip, $ticket_id)
    {
        return IpAddress::firstOrCreate(
            ['ip' => $ip, 'ticket_id' => $ticket_id]
        );
    }

    public static function findIP($ip, $ticket_id)
    {
        return IpAddress::where('ip', $ip)->where('ticket_id', $ticket_id)->first();
    }

    public static function parsIpAddress($str, $ticket_id)
    {
        $ips = ParsService::ip($str);
        if (empty($ips)) {
            return false;
        }

        foreach ($ips as $ip) {
            self::updateOrCreate($ip, $ticket_id);
        }
        
        return true;
    }
}
