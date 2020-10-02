<?php 

namespace App\Services;

use App\Models\ApiTicket;
use Carbon\Carbon;
use Config, InvalidArgumentException, BadMethodCallException;
use Zendesk\API\HttpClient;

class ImportZendeskService {

    /**
     * @var App\Models\ApiTicket
     */
    public $apiTicket;

    /**
     * @var Zendesk\API\HttpClient
     */
    public $apiClient;

    public function __construct(ApiTicket $apiTicket) {
        $this->apiTicket = $apiTicket;
        $this->apiClient = $this->apiClient($apiTicket)->client;
    }

    public static function getApi($import_at=null)
    {
        if (! empty($apiTicket = ApiTicket::where('import_at', $import_at)->first())) {
            return new ImportZendeskService($apiTicket);
        }
        return false;
    }

    public function apiClient(ApiTicket $apiTicket)
    {
        return new ZendeskService($apiTicket->subdomain, $apiTicket->secret_key, $apiTicket->api_key);
    }

    public function getPage($page, $per_page=1)
    {
        try {
            $tickets = $this->apiClient->tickets()->findAll(['per_page' => $per_page, 'page' => $page]);
        } catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
            $tickets = null; // echo $e->getMessage();
        }
        return $tickets;
    }

    public function getTicketComments($ticket_id)
    {
        try {
            $tickets = $this->apiClient->tickets($ticket_id)->comments()->findAll([
                // 'since' => Carbon::today()->modify('-1 day'),
                'include' => ['users'],
            ]);
        } catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
            $tickets = null;
        }
        return $tickets;
    }

    public function updateToDay()
    {
        return $this->apiClient->incremental()->tickets([
            'start_time' => Carbon::today()->modify('-1 day')->timestamp, 
            'per_page' => 1, 
            'page' => 2, 
            // 'include' => ['comments', 'users'],
            // 'sideload' => 'comments,users',
            'sort_order' => 'asc'
        ]);
    }

    public function getToDayEvents()
    {
        return $this->apiClient->incremental()->ticketEvents([
            'start_time' => (Carbon::today()->modify('-1 day')->timestamp), 
            'include' => ['comment_events', 'ticket_events']
        ]);
    }

    public function getApiUpdateToDay($today=null)
    {
        $apiTicket = ApiTicket::where('import_at', $today)->first();
        if (!empty($apiTicket)) {
            return $this->updateToDay($apiTicket);
        }
        return [];
    }

    public function getUrlQueryParams($url)
    {
        $query_str = parse_url($url, PHP_URL_QUERY);
        parse_str($query_str, $query_params);
        return $query_params;
    }

    public function getNextPageParams(\stdClass $api_result)
    {
        if (empty($api_result->next_page)) {
            return false;
        }
        
        return $this->getUrlQueryParams($api_result->next_page);
    }

    public function isNextPage(\stdClass $api_result)
    {
        $query_params = $this->getNextPageParams($api_result);
        if (empty($query_params['page'])) {
            return false;
        }

        return true;
    }

    public function isIncrementalEndTime(\stdClass $api_result)
    {
        if ($api_result->end_of_stream === true) {
            return false;
        }

        return true;
    }

    public function getIncrementalEndTime(\stdClass $api_result)
    {
        if (empty($api_result->end_time) && $api_result->end_of_stream === true) {
            return false;
        }

        return $api_result->end_time;
    }
}