<?php

namespace App\Http\Controllers;

use App\Button;
use App\ButtonClick;
use App\Company;
use App\Events\ButtonTriggerEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ButtonClickController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyEmpty = [null => 'All'];
        $companiesQuery = Company::pluck('name', 'id')->toArray();
        $companies = $companyEmpty + $companiesQuery;

        $groups = [
            ''=>'Select Field',
            'company_id'=>'Company',
            'branch_id'=>'Branch',
            'button_id'=> 'Button',
        ];


        $buttonClicks = ButtonClick::with(['company', 'button', 'buttonType', 'branch']);

        if (!empty($request->get('company_id'))) {
            $buttonClicks->where('company_id', $request->company_id);


            if (!empty($request->get('branch_id'))) {
                $buttonClicks->where('branch_id', $request->branch_id);
            }
        }

        if (!empty($request->get('from'))) {
            $buttonClicks->where('created_at', '>', $request->from);
        }
        if (!empty($request->get('to'))) {
            $buttonClicks->where('created_at', '<', $request->to);
        }
        if (!empty($request->get('serial_number'))) {
            $buttonClicks->whereHas('button', function ($q) use ($request) {
                $q->where('serial_number', '=', $request->serial_number);
            });
        }
        if (!empty($request->get('count'))) {
            $buttonClicks->groupBy($request->count)
            ->count();
        }


        return view('reports.clicks')->with([
            'companies' => $companies,
            'buttonClicks' => $buttonClicks->get(),
            'request' => $request,
            'groups'=> $groups
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($serial)
    {
        $button = Button::where('serial_number', $serial)->first();
        $buttonClick = new ButtonClick();
        $buttonClick->button_id = $button->id;
        $buttonClick->button_type_id = $button->button_type_id;
        $buttonClick->company_id = $button->company_id;
        $buttonClick->branch_id = $button->branch_id;

//        event(new ButtonTriggerEvent(collect($buttonClick)));

        if ($buttonClick->save()) {

            $x = ButtonClick::with(['buttonType', 'company', 'branch', 'button'])->find($buttonClick->id);
            event(new ButtonTriggerEvent($x));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ButtonClick $buttonClick
     * @return \Illuminate\Http\Response
     */
    public function show(ButtonClick $buttonClick)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ButtonClick $buttonClick
     * @return \Illuminate\Http\Response
     */
    public function edit(ButtonClick $buttonClick)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ButtonClick $buttonClick
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ButtonClick $buttonClick)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ButtonClick $buttonClick
     * @return \Illuminate\Http\Response
     */
    public function destroy(ButtonClick $buttonClick)
    {
        //
    }
}
