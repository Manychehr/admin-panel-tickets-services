<?php 

namespace App\Services;

use App\KayakoApi\kyResultSet;
use App\KayakoApi\kyTicket;
use App\KayakoApi\kyTicketAttachment;
use App\KayakoApi\kyTicketPost;
use Carbon\Carbon;

class ImportKayakoService extends KayakoService
{

    /**
     * @var \App\KayakoApi\kyResultSet
     */
    public $api_result;

    public function allTickets($page=1, $per_page=100)
    {
        $this->api_result = $this->getPage($page, $per_page);
        return !empty($this->api_result) && !empty($this->api_result->count());
    }

    public function nextPage()
    {
        return $this->getNextPageParams($this->api_result);
    }

    public function tickets()
    {
        if (empty($this->api_result) || empty($this->api_result->count())) {
            return [];
        }
        return $this->api_result;
    }

    public function allTicketComments($ticket_id, $page=1, $per_page=100)
    {
        $this->api_result = $this->getTicketComments($ticket_id, $page, $per_page);
        
        return !empty($this->api_result) && !empty($this->api_result->count());
    }

    public function comments()
    {
        if (empty($this->api_result) || empty($this->api_result->count())) {
            return [];
        }
        return $this->api_result;
    }

    public function user($api_id, $service_id)
    {
        if (empty($user = AuthorsService::findApiId($api_id, $service_id))) {
            /**
             * @var \App\KayakoApi\kyUser
             */
            $kyUser = $this->getUser($api_id);
            if (!empty($kyUser)) {
                $user = AuthorsService::updateOrCreateNew(
                    $kyUser->getId(), 
                    $service_id, 
                    $kyUser->getFullName(), 
                    $kyUser->getEmail(), 
                    $kyUser->_data,
                    $kyUser->getUserRole()
                );
            }
        }
        return $user;
    }

    public function ticketUser(kyTicket $kyTicket, $service_id)
    {
        if (!empty($kyTicket->getUserId())) {
            return $this->user($kyTicket->getUserId(), $service_id);
        }

        if (!empty($user = AuthorsService::findEmail($kyTicket->getEmail(), $service_id))) {
            return $user;
        }

        $data = $this->newUserData($kyTicket->getFullName(), $kyTicket->getEmail(), $kyTicket->getCreationTime());

        $user = AuthorsService::updateOrCreateNew(
            $data['id'], 
            $service_id, 
            $data['fullname'], 
            $data['email'], 
            $data,
            $data['userrole']
        );
        return $user;
    }

    public function commentUser(kyTicketPost $kyTicketPost, $service_id)
    {
        if (!empty($kyTicketPost->getUserId())) {
            return $this->user($kyTicketPost->getUserId(), $service_id);
        }

        if (!empty($user = AuthorsService::findEmail($kyTicketPost->getEmail(), $service_id))) {
            return $user;
        }

        $data = $this->newUserData($kyTicketPost->getFullName(), $kyTicketPost->getEmail(), $kyTicketPost->getDateline());

        $user = AuthorsService::updateOrCreateNew(
            $data['id'], 
            $service_id, 
            $data['fullname'], 
            $data['email'], 
            $data,
            $data['userrole']
        );
        return $user;
    }

    public function newUserData($fullname, $email, $date)
    {
        return [
            "id" => (int)time(),
            "usergroupid" => "0",
            "userrole" => "new",
            "userorganizationid" => "",
            "salutation" => "",
            "userexpiry" => "0",
            "fullname" => $fullname,
            "email" => $email,
            "designation" => "",
            "phone" => "",
            "dateline" => $date,
            "lastvisit" => $date,
            "isenabled" => "1",
            "timezone" => "",
            "enabledst" => "0",
            "slaplanid" => "0",
            "slaplanexpiry" => "0"
        ];
    }

    public function adapter_ticket(kyTicket $kyTicket)
    {
        $tiket = $kyTicket->_data;
        $tiket['id'] = $kyTicket->getId();
        $tiket['created_at'] = $kyTicket->getCreationTime();
        $tiket['updated_at'] = $kyTicket->getLastActivity();
        $tiket['submitter_id'] = $kyTicket->getUserId();
        // $tiket['note'] = $kyTicket->getNotes(true);

        return $tiket;
    }

    public function adapter_comments(kyTicketPost $kyTicketPost, $attachments = [])
    {
        $data = $kyTicketPost->_data;
        $data['id'] = $kyTicketPost->getId();
        $data['created_at'] = (int)$kyTicketPost->getDateline();
        $data['html_body'] = $kyTicketPost->getContents();
        $data['plain_body'] = strip_tags($kyTicketPost->getContents());
        unset($data['contents']);
        $data['attachments'] = [];
        if ($kyTicketPost->getHasAttachments()) {
            $data['attachments'] = $this->getCommentAttachments($kyTicketPost->getId(), $attachments);
        }

        return $data;
    }

    public function getCommentAttachments($post_id, $attachments, $data = [])
    {
		foreach ($attachments as $attachment) {
			/**
             *  @var \App\KayakoApi\kyTicketAttachment $attachment 
             */
			if ($attachment->getTicketPostId() === $post_id) {
				$data[] = [
                    'url' => null, //$attachment->getContents()
                    "id" => $attachment->getId(),
                    "file_name" => $attachment->getFileName(),
                    "content_type" => $attachment->getFileType(),
                    "size" => $attachment->getFileSize()
                ];
			}
        }
        return $data;
    }

    public function getLastActivity($limitTime, $limit = 1000, $start = 1, $result = [])
    {
        /**
         * @var \App\KayakoApi\kyResultSet $tickets
         */
        $tickets = $this->getTicketList($limit, $start, 'lastactivity', 'desc');
        $import_at = $this->updateImportAt($limitTime);

        /**
         * @var \App\KayakoApi\kyTicket $ticket
         */
        foreach ($tickets as $ticket) {
            if ($ticket->get_last_activity() >= $import_at) {
                $result[] = $ticket;
            }
        }

        $this->api_result =new kyResultSet($result, $tickets->getObjectsClassName());

        return !empty($this->api_result) && !empty($this->api_result->count());
    }

    
}