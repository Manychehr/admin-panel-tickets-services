<?php

namespace App\Http\Controllers;

use App\DataTables\ApiTicketDataTable;
use App\Http\Requests\StoreApiTicketRequest;
use App\Jobs\ImportZendeskTicketsJob;
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
        $columnsShowMenu = []; // $this->getColumnsShowMenu();
        return $dataTable->render('DataTable', compact('block_title', 'jsroute', 'columnsShowMenu'));
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
            $request->only(['name', 'service', 'subdomain', 'api_key', 'secret_key', 'url'])
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
            $request->only(['name', 'service', 'subdomain', 'api_key', 'secret_key', 'url'])
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
        dispatch(new ImportZendeskTicketsJob($apiTicket->id, 1, 1));
        return response()->json(['success' => 'Api Details send-import successfully']);
    }
}
