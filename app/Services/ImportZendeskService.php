<?php 

namespace App\Services;

use Carbon\Carbon;

class ImportZendeskService extends ZendeskService
{

    /**
     * @var \stdClass
     */
    public $api_result;

    public function allTickets($page=1, $per_page=100)
    {
        $this->api_result = $this->getPage($page, $per_page);
        return !empty($this->api_result) && !empty($this->api_result->tickets);
    }

    public function nextPage()
    {
        return $this->getNextPageParams($this->api_result);
    }

    public function tickets()
    {
        if (empty($this->api_result) || empty($this->api_result->tickets)) {
            return [];
        }
        return $this->api_result->tickets;
    }

    public function allTicketComments($ticket_id, $page=1, $per_page=100)
    {
        $this->api_result = $this->getTicketComments($ticket_id, $page, $per_page);
        
        return !empty($this->api_result) && !empty($this->api_result->comments);
    }

    public function comments()
    {
        if (empty($this->api_result) || empty($this->api_result->comments)) {
            return [];
        }
        return $this->api_result->comments;
    }

    public function users()
    {
        if (empty($this->api_result) || empty($this->api_result->users)) {
            return [];
        }
        return $this->api_result->users;
    }

    /* public function getApiUpdateToDay($today=null)
    {
        $apiTicket = ApiTicket::where('import_at', $today)->first();
        if (!empty($apiTicket)) {
            return $this->updateToDay($apiTicket);
        }
        return [];
    } */

}