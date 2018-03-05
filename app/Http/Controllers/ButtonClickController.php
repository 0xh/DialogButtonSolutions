<?php

namespace App\Http\Controllers;

use App\Button;
use App\ButtonClick;
use App\Company;
use Illuminate\Http\Request;

class ButtonClickController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::pluck('name', 'id');
        return view('reports.clicks')->with([
            'companies'=>$companies
        ]);
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
    public function store($token, $serial)
    {
        $button = Button::whereSerial($serial)->first();
        $buttonClick = new ButtonClick();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ButtonClick  $buttonClick
     * @return \Illuminate\Http\Response
     */
    public function show(ButtonClick $buttonClick)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ButtonClick  $buttonClick
     * @return \Illuminate\Http\Response
     */
    public function edit(ButtonClick $buttonClick)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ButtonClick  $buttonClick
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ButtonClick $buttonClick)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ButtonClick  $buttonClick
     * @return \Illuminate\Http\Response
     */
    public function destroy(ButtonClick $buttonClick)
    {
        //
    }
}
