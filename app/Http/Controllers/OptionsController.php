<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\DataTables\OptionsDataTable;
use App\Http\Requests\StoreOptionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OptionsController extends AuthBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OptionsDataTable $dataTable)
    {
        $block_title = 'Options List';
        $jsroute = 'options.index';
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
        return view('components.options.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOptionsRequest $request)
    {
        Option::set($request->input('key'), $request->input('value'));

        return response()->json(['success' => 'New Option saved successfully']);
    }

    /* public function storeValue($request)
    {
        Validator::make($request->all(), [
            'type' => 'required|in:value',
            'key' => 'required|string|min:3|max:190',
            'value' => 'required|string|min:3|max:190',
        ])->validate();

        return [
            'type' => $request->input('type'),
            'key' => $request->input('key'),
            'value' => $request->input('value')
        ];
    }

    public function storeApi($request)
    {
        Validator::make($request->all(), [
            'type' => 'required|in:zendesk_api,kayako_api',
            'subdomain' => 'required|string|min:3|max:190',
            'username' => 'required|string|min:3|max:190',
            'token' => 'required|string|min:3|max:190'
        ])->validate();

        return [
            'type' => 'api',
            'key' => $request->input('type'),
            'value' =>[ 
                'subdomain' => $request->input('subdomain'),
                'username' => $request->input('username'),
                'token' => $request->input('token')
            ]
        ];
    } */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Option $option)
    {
        return view('components.options.show', compact('option'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Option $option)
    {
        return view('components.options.edit', compact('option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOptionsRequest $request, Option $option)
    {
        $option->value = $request->input('value');
        $option->save();

        return response()->json(['success' => 'Option saved successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Option $option)
    {
        $option->delete();
        return response()->json(['success' => 'Option destroy successfully']);
    }
}
