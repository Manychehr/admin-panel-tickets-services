<?php 

namespace App\Services;

use App\Models\ApiTicket;
use App\Models\Ticket;
use Carbon\Carbon;

class TicketsServices
{

    /**
     * service_id = ApiTicket $apiTicket->id
     */
    public static function updateOrCreate(\stdClass $ticket, $service_id)
    {
        return Ticket::updateOrCreate(
            ['api_id' => $ticket->id, 'service_id' => $service_id],
            [
                'author_id' => $ticket->submitter_id, 
                'data' => (array)$ticket, 
                'created_at' => new Carbon($ticket->created_at)
            ]
        );
    }

    public static function inScheme(Ticket $ticket, bool $in_scheme)
    {
        $ticket->in_scheme = $in_scheme;
        return $ticket->save();
    }

    public static function findApiId($api_id, $service_id)
    {
        return Ticket::where('api_id', $api_id)->where('service_id', $service_id)->first();
    }
}
