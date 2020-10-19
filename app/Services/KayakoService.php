<?php 

namespace App\Services;

use App\KayakoApi\kyConfig;
use App\KayakoApi\kyDepartment;
use App\KayakoApi\kyResultSet;
use App\KayakoApi\kyTicket;
use App\KayakoApi\kyTicketAttachment;
use App\KayakoApi\kyTicketPost;
use App\KayakoApi\kyUser;
use App\Models\ApiTicket;
use Carbon\Carbon;
use InvalidArgumentException;

class KayakoService {

    /**
     * @var \App\Models\ApiTicket
     */
    public $apiTicket;

    /**
     * @var \App\KayakoApi\kyConfig
     */
    public $kyConfig;

    /**
     * \App\KayakoApi\kyDepartment
     * @var \App\KayakoApi\kyResultSet
     */
    public $departments;

    /**
     * @var array
     */
    public $errors_api = [];

    public $query_params;

    /**
     * Get auth parameters from config, fail if any are missing.
     * Instantiate API client and set auth token.
     *
     * @throws Exception
     */
    public function __construct($api_key, $secret_key, $url, $apiTicket=null) {
        $this->api_key = $api_key;
        $this->secret_key = $secret_key;
        $this->url = $url;
        $this->apiTicket = $apiTicket;

        if(!$this->api_key || !$this->secret_key || !$this->url) {
            throw new InvalidArgumentException('Please set KAYAKO_APIKEY, KAYAKO_SECRETKEY and KAYAKO_URI environment variables.');
        }

        kyConfig::set(new kyConfig($this->url, $this->api_key, $this->secret_key));
    }

    public static function getApi($service_id=null, $import_at=null, $term='>')
    {
        $apiTicket = ApiTicket::where('service', 'kayako')
                            ->when(empty($service_id), function ($query) use ($import_at, $term) {
                                return $query->where('import_at', $term, $import_at);
                            }, function ($query) use ($service_id) {
                                return $query->where('id', $service_id);
                            })
                            ->first();

        if (! empty($apiTicket)) {
            return new static($apiTicket->api_key, $apiTicket->secret_key, $apiTicket->url, $apiTicket);
        }

        return false;
    }

    public function getDepartment($first = false, $title = false, $module = kyDepartment::MODULE_TICKETS)
    {
        $this->departments = kyDepartment::getAll();
        if ($title) {
            $this->departments = $this->departments->filterByTitle($title);
        }
        if ($module) {
            $this->departments = $this->departments->filterByModule($module);
        }
        if ($first) {
            $this->departments = $this->departments->first();
        }

        return $this->departments;
    }

    public function getPage($page, $per_page=100)
    {
        $this->query_params = ['per_page' => $per_page, 'page' => $page];
        try {
            $tickets = kyTicket::getAll($this->departments, [], [], [], $per_page, $page);
        } catch (\Exception $e) {
            $tickets = null; 
            $this->errors_api[] = $e->getMessage();
        }
        return $tickets;
    }

    public function getTicket($ticket_id)
    {
        try {
            $ticket = kyTicket::get($ticket_id);
        } catch (\Exception $e) {
            $ticket = null; 
            $this->errors_api[] = $e->getMessage();
        }
        return $ticket;
    }

    public function getTicketComments($ticket_id)
    {
        try {
            $comments = kyTicketPost::getAll($ticket_id);
        } catch (\Exception $e) {
            $this->errors_api[] = $e->getMessage();
            $comments = null;
        }
        return $comments;
    }

    public function getTicketPost($ticket_id, $id)
    {
        try {
            $post = kyTicketPost::get($ticket_id, $id);
        } catch (\Exception $e) {
            $this->errors_api[] = $e->getMessage();
            $post = null;
        }
        return $post;
    }

    public function getNextPageParams(kyResultSet $api_result)
    {
        if (empty($api_result->count())) {
            return false;
        }

        $query_params = $this->query_params;
        if (empty($query_params['page'])) {
            return false;
        }
        $query_params['page'] = (int)$query_params['page']+1;
        
        return $query_params;
    }

    public function getUser($user_id)
    {
        try {
            $user = kyUser::get($user_id);
        } catch (\Exception $e) {
            $this->errors_api[] = $e->getMessage();
            $user = null;
        }
        return $user;
    }

    public function getUsers($page)
    {
        try {
            $user = kyUser::getAll($page);
        } catch (\Exception $e) {
            $this->errors_api[] = $e->getMessage();
            $user = null;
        }
        return $user;
    }

    public function allAttachments($ticket_id)
    {
        try {
            $attachment = kyTicketAttachment::getAll($ticket_id);
        } catch (\Exception $e) {
            $this->errors_api[] = $e->getMessage();
            $attachment = null;
        }
        return  $attachment;
    }

    public function getAttachment($ticket_id, $id)
    {
        try {
            $attachment = kyTicketAttachment::get($ticket_id, $id);
        } catch (\Exception $e) {
            $this->errors_api[] = $e->getMessage();
            $attachment = null;
        }
        return  $attachment;
    }

    public function getTicketList($max_items, $start, $sortField = null, $sortOrder = null)
    {
        try {
            $tickets = kyTicket::getListAll($this->departments->collectId(), [], [], [], $max_items, $start, $sortField, $sortOrder);;
        } catch (\Exception $e) {
            $tickets = null; 
            $this->errors_api[] = $e->getMessage();
        }
        return $tickets;
    }

    public function updateImportAt($modifyTime)
    {
        $import_at = Carbon::now()->modify($modifyTime); // today()
        $this->apiTicket->import_at =  $import_at;
        $this->apiTicket->save();

        return $import_at->getTimestamp();
    }
}