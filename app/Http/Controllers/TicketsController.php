<?php

namespace App\Http\Controllers;

use App\DataTables\CommentsDataTable;
use App\DataTables\TicketsDataTable;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketsController extends AuthBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TicketsDataTable $dataTable)
    {
        $block_title = 'Tickets List';
        $jsroute = 'tickets.index';
        $columnsShowMenu = []; // $this->getColumnsShowMenu();
        $showHideListLink = true;
        $showFiltersForm = true;
        return $dataTable->render('DataTable', compact('block_title', 'jsroute', 'columnsShowMenu', 'showFiltersForm', 'showHideListLink'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Ticket $ticket)
    {
        return view('components.tickets.show', compact('ticket'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function full_show(Request $request, Ticket $ticket)
    {
        $dataTable = new CommentsDataTable($ticket);
        return $dataTable->render('components.tickets.full-show', compact('ticket'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function hide_ticket(Ticket $ticket)
    {
        $ticket->show = false;
        $ticket->save();
        return response()->json(['success' => 'Hide ticket successfully']);
    }

    public function hide_user_tickets(Ticket $ticket)
    {
        if (!empty($author = $ticket->author)) {
            $author->show_tickets = false;
            $author->save();
        }

        return response()->json(['success' => 'Hide user tickets successfully']);
    }
}
