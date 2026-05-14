<?php

namespace App\Http\Controllers;

use App\Models\BranchOffice;
use App\Http\Requests\{StoreBranchOfficeRequest, UpdateBranchOfficeRequest};
use Yajra\DataTables\Facades\DataTables;

class BranchOfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:branch office view')->only('index', 'show');
        $this->middleware('permission:branch office create')->only('create', 'store');
        $this->middleware('permission:branch office edit')->only('edit', 'update');
        $this->middleware('permission:branch office delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $branchOffices = BranchOffice::query();

            return DataTables::of($branchOffices)
                ->addColumn('location', function($row){
                    return str($row->location)->limit(100);
                })
				->addColumn('action', 'branch-offices.include.action')
                ->toJson();
        }

        return view('branch-offices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('branch-offices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchOfficeRequest $request)
    {
        
        BranchOffice::create($request->validated());

        return redirect()
            ->route('branch-offices.index')
            ->with('success', __('The branchOffice was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BranchOffice  $branchOffice
     * @return \Illuminate\Http\Response
     */
    public function show(BranchOffice $branchOffice)
    {
        return view('branch-offices.show', compact('branchOffice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BranchOffice  $branchOffice
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchOffice $branchOffice)
    {
        return view('branch-offices.edit', compact('branchOffice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BranchOffice  $branchOffice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBranchOfficeRequest $request, BranchOffice $branchOffice)
    {
        
        $branchOffice->update($request->validated());

        return redirect()
            ->route('branch-offices.index')
            ->with('success', __('The branchOffice was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchOffice  $branchOffice
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchOffice $branchOffice)
    {
        try {
            $branchOffice->delete();

            return redirect()
                ->route('branch-offices.index')
                ->with('success', __('The branchOffice was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('branch-offices.index')
                ->with('error', __("The branchOffice can't be deleted because it's related to another table."));
        }
    }
}
