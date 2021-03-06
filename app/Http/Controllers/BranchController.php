<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Company;
use App\Http\Requests\BranchRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Auth::user()->hasRole('super_admin')) {
            $branches = Branch::with('company')->get();
        } else {
            $branches = Branch::whereHas('company', function ($q) {
                $q->whereHas('users', function ($q2) {
                    $q2->where('id', Auth::id());
                });
            })->get();
        }

        return view('branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($user = Auth::user()->hasRole('super_admin')) {
            $companies = Company::pluck('name', 'id');
        } else {

            $companies = Company::whereHas('users',function ($q){
                $q->where('id', Auth::id());
            })->pluck('name', 'id');
        }
        return view('branches.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BranchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        $branch = new Branch();
        $branch->company_id = $request->company_id;
        $branch->branch = $request->branch;
        $branch->phone = $request->phone;
        $branch->address = $request->address;

        if ($branch->save()) {
            session()->flash('message.level', 'success');
            session()->flash('message.content', 'Successfully Created');
        }

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        if ($user = Auth::user()->hasRole('super_admin')) {
            $companies = Company::pluck('name', 'id');
        } else {

            $companies = Company::whereHas('users',function ($q){
                $q->where('id', Auth::id());
            })->pluck('name', 'id');
        }
        return view('branches.edit', compact('branch', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $branch->company_id = $request->company_id;
        $branch->branch = $request->branch;
        $branch->phone = $request->phone;
        $branch->address = $request->address;

        if ($branch->save()) {
            session()->flash('message.level', 'success');
            session()->flash('message.content', 'Successfully Created');
        }

        return redirect()->route('branches.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Branch $branch
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Branch $branch)
    {
        if ($branch->delete()) {
            session()->flash('message.level', 'success');
            session()->flash('message.content', 'Successfully Deleted');
        }

        return redirect()->route('branches.index');

    }
}
