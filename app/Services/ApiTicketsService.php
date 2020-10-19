<?php 

namespace App\Services;

use App\Jobs\ImportKayakoTicketsJob;
use App\Jobs\ImportZendeskTicketsJob;
use App\Jobs\UpdateKayakoTicketsJob;
use App\Jobs\UpdateZendeskTicketsJob;
use App\Models\ApiTicket;
use App\Models\Comment;
use Carbon\Carbon;

class ApiTicketsService
{

    public static function updateAll($type = 1)
    {
        $apiTickets = ApiTicket::where('cron', $type)->get();

        if (empty($apiTickets)) {
            return false;
        }

        foreach ($apiTickets as $apiTicket) {
            if ($apiTicket->service === 'zendesk') {
                dispatch(new UpdateZendeskTicketsJob($apiTicket->id, $apiTicket->limit_time));
            } else {
                dispatch(new UpdateKayakoTicketsJob($apiTicket->id, $apiTicket->limit_time));
            }
        }

        return true;
    }

    public static function importAll($type = 3)
    {
        $apiTickets = ApiTicket::where('cron', $type)->get();

        if (empty($apiTickets)) {
            return false;
        }

        foreach ($apiTickets as $apiTicket) {
            $apiTicket->current_page++;

            if ($apiTicket->service === 'zendesk') {
                dispatch(new ImportZendeskTicketsJob($apiTicket->id, $apiTicket->current_page, $apiTicket->limit_import));
            } else {
                dispatch(new ImportKayakoTicketsJob($apiTicket->id, $apiTicket->current_page, $apiTicket->limit_import));
            }

            $apiTicket->save();
        }

        return true;
    }
}