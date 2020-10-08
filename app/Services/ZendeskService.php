<?php 

namespace App\Services;

use App\Models\ApiTicket;
use Config, InvalidArgumentException, BadMethodCallException;
use Zendesk\API\HttpClient;

class ZendeskService {

    /**
     * @var \App\Models\ApiTicket
     */
    public $apiTicket;

    /**
     * @var \Zendesk\API\HttpClient
     */
    public $apiClient;

    /**
     * @var array
     */
    public $errors_api = [];

    /**
     * Get auth parameters from config, fail if any are missing.
     * Instantiate API client and set auth token.
     *
     * @throws Exception
     */
    public function __construct($subdomain, $username, $token, $apiTicket=null) {
        $this->subdomain = $subdomain; // config('zendesk-laravel.subdomain');
        $this->username = $username; // config('zendesk-laravel.username');
        $this->token = $token; // config('zendesk-laravel.token');
        $this->apiTicket = $apiTicket; // config('zendesk-laravel.token');

        if(!$this->subdomain || !$this->username || !$this->token) {
            throw new InvalidArgumentException('Please set ZENDESK_SUBDOMAIN, ZENDESK_USERNAME and ZENDESK_TOKEN environment variables.');
        }
        $this->apiClient = new HttpClient($this->subdomain, $this->username);
        $this->apiClient->setAuth('basic', ['username' => $this->username, 'token' => $this->token]);
    }

    public static function getApi($service_id=null, $import_at=null, $term='>')
    {
        $apiTicket = ApiTicket::where('service', 'zendesk')
                            ->when(empty($service_id), function ($query) use ($import_at, $term) {
                                return $query->where('import_at', $term, $import_at);
                            }, function ($query) use ($service_id) {
                                return $query->where('id', $service_id);
                            })
                            ->first();

        if (! empty($apiTicket)) {
            return new static($apiTicket->subdomain, $apiTicket->secret_key, $apiTicket->api_key, $apiTicket);
        }

        return false;
    }

    public function getPage($page, $per_page=100)
    {
        try {
            $tickets = $this->apiClient->tickets()->findAll(['per_page' => $per_page, 'page' => $page]);
        } catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
            $tickets = null; 
            $this->errors_api[] = $e->getMessage();
        }
        return $tickets;
    }

    public function getTicketComments($ticket_id, $page, $per_page=100)
    {
        try {
            $tickets = $this->apiClient->tickets($ticket_id)->comments()->findAll([
                'include' => ['users'],
                'per_page' => $per_page, 
                'page' => $page
            ]);
        } catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
            $this->errors_api[] = $e->getMessage();
            $tickets = null;
        }
        return $tickets;
    }

    public function importIncrementalTickets($start_time, $page, $per_page=100)
    {
        return $this->apiClient->incremental()->tickets([
            'start_time' => $start_time, // , 
            'per_page' => $per_page, 
            'page' => $page, 
            'sort_order' => 'asc'
        ]);
    }

    public function importIncrementalEvents($start_time, $page, $per_page=1)
    {
        return $this->apiClient->incremental()->ticketEvents([
            'start_time' =>  $start_time, // (Carbon::today()->modify('-1 day')->timestamp), 
            'include' => ['comment_events', 'ticket_events', 'users']
        ]);
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

        $query_params = $this->getUrlQueryParams($api_result->next_page);
        if (empty($query_params['page'])) {
            return false;
        }
        
        return $query_params;
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