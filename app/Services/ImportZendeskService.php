<?php 

namespace App\Services;

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

    public function searchResults()
    {
        if (empty($this->api_result) || empty($this->api_result->results)) {
            return [];
        }
        return $this->api_result->results;
    }

    public function searchNextPage()
    {
        return $this->getNextPageParams($this->api_result);
    }

    public function getLastActivity($limitTime, $page = 1)
    {
        $import_at = $this->updateImportAt($limitTime);

        $tickets = $this->search(
            'type:ticket created>' . $import_at,
            [
                'sort_by' => 'updated_at',
                'sort_order' => 'desc',
                'page' => $page
            ]
        );

        $this->api_result = $tickets;
        return $this->api_result;

        return !empty($this->api_result) && !empty($this->api_result->results);
    }

}