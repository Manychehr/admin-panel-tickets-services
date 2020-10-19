<?php

namespace App\Http\Controllers;

use App\DataTables\ApiTicketDataTable;
use App\Http\Requests\StoreApiTicketRequest;
use App\Jobs\ImportKayakoTicketsJob;
use App\Jobs\ImportZendeskTicketsJob;
use App\Jobs\UpdateKayakoTicketsJob;
use App\Jobs\UpdateZendeskTicketsJob;
use App\Models\ApiTicket;
use Illuminate\Http\Request;

class ApiTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ApiTicketDataTable $dataTable)
    {
        $block_title = 'Api Details List';
        $jsroute = 'api_tickets.index';
        $ShowButtonCreate = true;
        $columnsShowMenu = []; // $this->getColumnsShowMenu();
        return $dataTable->render('DataTable', compact('block_title', 'jsroute', 'columnsShowMenu', 'ShowButtonCreate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('components.api_details.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApiTicketRequest $request)
    {
        ApiTicket::create(
            $request->only(['name', 'service', 'subdomain', 'api_key', 'secret_key', 'url', 'limit_time', 'limit_import', 'current_page'])
        );

        return response()->json(['success' => 'New Api Details saved successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApiTicket  $apiTicket
     * @return \Illuminate\Http\Response
     */
    public function show(ApiTicket $apiTicket)
    {
        return view('components.api_details.show', compact('apiTicket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApiTicket  $apiTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(ApiTicket $apiTicket)
    {
        return view('components.api_details.edit', compact('apiTicket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApiTicket  $apiTicket
     * @return \Illuminate\Http\Response
     */
    public function update(StoreApiTicketRequest $request, ApiTicket $apiTicket)
    {
        $apiTicket->fill(
            $request->only(['name', 'service', 'subdomain', 'api_key', 'secret_key', 'url', 'limit_time', 'limit_import', 'current_page', 'cron'])
        );
        $apiTicket->save();

        return response()->json(['success' => 'Api Details saved successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApiTicket  $apiTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApiTicket $apiTicket)
    {
        $apiTicket->delete();
        return response()->json(['success' => 'Api Details destroy successfully']);
    }

    public function send_import(ApiTicket $apiTicket)
    {
        if ($apiTicket->service === 'zendesk') {
            dispatch(new ImportZendeskTicketsJob($apiTicket->id, 1, 100));
        } else {
            dispatch(new ImportKayakoTicketsJob($apiTicket->id, 1, 100));
        }
        
        return response()->json(['success' => 'Api Details send-import successfully']);
    }

    public function send_update(ApiTicket $apiTicket)
    {
        if ($apiTicket->service === 'zendesk') {
            dispatch(new UpdateZendeskTicketsJob($apiTicket->id, $apiTicket->limit_time));
        } else {
            dispatch(new UpdateKayakoTicketsJob($apiTicket->id, $apiTicket->limit_time));
        }
        
        return response()->json(['success' => 'Api Details send-import successfully']);
    }
    
}
