<?php

namespace App\Http\Controllers;

use App\DataTables\AuthorsDataTable;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends AuthBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AuthorsDataTable $dataTable)
    {
        $block_title = 'Authors List';
        $jsroute = 'authors.index';
        $columnsShowMenu = []; // $this->getColumnsShowMenu();
        $showHideListLink = false;
        $showFiltersForm = false;
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
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        //
    }

    public function show_ticket(Author $author)
    {
        $author->show_tickets = true;
        $author->save();

        return response()->json(['success' => 'Show user tickets successfully']);
    }

    public function hide_ticket(Author $author)
    {
        $author->show_tickets = false;
        $author->save();

        return response()->json(['success' => 'Hide user tickets successfully']);
    }
}
