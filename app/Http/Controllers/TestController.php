<?php

namespace App\Http\Controllers;

use App\Services\DomainsService;
use App\Services\ImportKayakoService;
use App\Services\KayakoService;
use App\Services\ParsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends AuthBaseController
{
    public function index()
    {
        return view('test');
    }

    public function test(Request $request)
    {
        $test_text = $request->test_text?? '';
        $result = [
            ['name' => 'domain', 'pars' => ParsService::domain($test_text)],
            ['name' => 'ip', 'pars' => ParsService::ip($test_text)],
            ['name' => 'prohibited schemes', 'pars' => [ParsService::prohibitedSchemes($test_text)? 'true': 'false']],
        ];
        return view('test', compact('result', 'test_text'));
    }

    public function zendesk($api_id)
    {
        $api = \App\Services\ImportZendeskService::getApi((int)$api_id);
        ddd($api);
        $api->allTickets(1, 100);
    }

    public function zendesk_tickets(Request $request, $api_id)
    {
        $api = \App\Services\ImportZendeskService::getApi((int)$api_id);
        
        /* if ($api->allTickets($request->get('page', 1), $request->get('per_page', 100))) {
            ddd($api->tickets());
        } */
        
        // ddd($api->errors_api);
        ddd($api->getLastActivity('-16 day'));
    }

    public function zendesk_tickets_comments(Request $request, $api_id, $tickets_id)
    {
        $api = \App\Services\ImportZendeskService::getApi((int)$api_id);
        
        if ($api->allTicketComments($tickets_id, $request->get('page', 1), $request->get('per_page', 100))) {
            ddd([
                'comments' => (array)$api->comments(),
                'users' => (array)$api->users(),
                'nextPage' => $api->nextPage(),
                'raw' => $api->api_result
            ]);
        }
        
        ddd($api->errors_api);
    }

    public function zendesk_update_tickets(Request $request)
    {
        $api = \App\Services\UpdateZendeskService::getApiUpdateToDay($request->get('day', '-1'));
        if (empty($api)) {
            ddd('empty api');
        }
        if ($api->allTickets($request->get('page', 1), $request->get('per_page', 100))) {
            ddd([
                'tickets' => $api->tickets(),
                'nextPage' => $api->nextPage(),
                'raw' => $api->api_result
            ]);
        }
        
        ddd($api->errors_api);
    }
    
    public function domains_update_ranks(Request $request)
    {
        ddd(
            DomainsService::update_day($request->get('days', -1), $request->get('limit', 5))
        );
    }

    public function kayako(Request $request)
    {
        /* $this->service_id = 2;
        $ImportKayakoService = ImportKayakoService::getApi($this->service_id);
        if (empty($ImportKayakoService)) {
            dd('empty($ImportKayakoService)');
            return;
        }
        $ImportKayakoService->getDepartment(); */
        /* $there_is_tickets = $ImportKayakoService->allTickets(1, 20);
        if (!$there_is_tickets) {
            dd(['!$there_is_tickets' => 'false', ]);
            return;
        } */

        /* if (!empty($page_params = $ImportKayakoService->nextPage())) {
            // dispatch(new ImportZendeskTicketsJob($this->service_id, $page_params['page'], $this->per_page));
        } */
        

        //dd($ImportKayakoService->tickets());
        /**
         * @var \App\Services\ImportKayakoService
         */
        $kayako = ImportKayakoService::getApi(2);
        $kayako->getDepartment();
        /* $default_status_id = kyTicketStatus::getAll()->filterByTitle("Open")->first()->getId();
        $default_priority_id = kyTicketPriority::getAll()->filterByTitle("Normal")->first()->getId();
        $default_type_id = kyTicketType::getAll()->filterByTitle("Issue")->first()->getId(); */
        // kyTicket::setDefaults($default_status_id, $default_priority_id, $default_type_id);
        // $import_at = (Carbon::today()->modify('-1 day'))->getTimestamp();
        $kayako->getLastActivity('-1 day');
        //$general_department = \App\KayakoApi\kyDepartment::getAll();
            // ->filterByTitle("General")
       // $general_department = $general_department->filterByModule(\App\KayakoApi\kyDepartment::MODULE_TICKETS)->collectId();
            /* ->first() ;*/
        // $kayako->getDepartment();
       // $ticket = $kayako->getPage(5, 10); 
       //$tickets = \App\KayakoApi\kyTicket::getListAll($general_department, [], [], [], 1000, 1, 'lastactivity', 'desc');
                    // ->filterByLastActivity(['>', $import_at]);


            
        ddd([
            // $import_at,
            $kayako->tickets(),
            // \App\KayakoApi\kyTicket::getStatistics(),
            //$kayako->errors_api
            // 
            //\App\KayakoApi\kyTicket::getAll($general_department, [], [], [], 20, 300),
            //$general_department 
            // $ticket->getPage(3, 20),
            //$ticket->offsetGet(100),
            /* $ticket->getPageCount(100) */
            //$ticket->_data,
           // $general_department, 
           // $kayako->getTicketComments(337368),
           /* $kayako->getTicket(318155),
           $kayako->getTicketPost(318155, 1640562),
           $kayako->getUser(75732) */
           // $kayako->getTicketPost(318155, 1640562)->getUser(true),
           // $kayako->allAttachments(318155)
           // $kayako->getAttachment(318155, 943341)
            // \App\KayakoApi\kyTicketPost::getAll(344711)->getPage(2, 20)
        //kyTicketStatus::getAll()

        //$ticket,
        //
        /* $ticket->getCustomField('notes'),
        $ticket->getDepartment(true),
        $ticket->getStatus(true),
        $ticket->getSubject(),
        $ticket->getTags(),
        $ticket->getTimeTracks(true),
        $ticket->getType(true),
        $ticket->getUser()->buildData(false),

        $ticket->getNotes(true) */
        // kyDepartment::getAll()
        // $general_department
        ]);
    }
}
