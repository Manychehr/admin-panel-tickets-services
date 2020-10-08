<?php

namespace App\Http\Controllers;

use App\Services\ParsService;
use Illuminate\Http\Request;

class TestController extends Controller
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
        
        if ($api->allTickets($request->get('page', 1), $request->get('per_page', 100))) {
            ddd($api->tickets());
        }
        
        ddd($api->errors_api);
    }

    public function zendesk_tickets_comments(Request $request, $api_id, $tickets_id)
    {
        $api = \App\Services\ImportZendeskService::getApi((int)$api_id);
        
        if ($api->allTicketComments($tickets_id, $request->get('page', 1), $request->get('per_page', 100))) {
            ddd([
                'comments' => $api->comments(),
                'users' => $api->users(),
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
    
}
