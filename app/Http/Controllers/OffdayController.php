<?php

namespace App\Http\Controllers;

use App\Models\Offday;
use App\Http\Requests\{StoreOffdayRequest, UpdateOffdayRequest};
use Yajra\DataTables\Facades\DataTables;

class OffdayController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:offday view')->only('index', 'show');
        $this->middleware('permission:offday create')->only('create', 'store');
        $this->middleware('permission:offday edit')->only('edit', 'update');
        $this->middleware('permission:offday delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $offdays = Offday::query();

            return DataTables::of($offdays)
                ->addColumn('description', function($row){
                    return str($row->description)->limit(100);
                })
				->addColumn('action', 'offdays.include.action')
                ->toJson();
        }

        return view('offdays.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offdays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOffdayRequest $request)
    {
        
        Offday::create($request->validated());

        return redirect()
            ->route('offdays.index')
            ->with('success', __('The offday was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offday  $offday
     * @return \Illuminate\Http\Response
     */
    public function show(Offday $offday)
    {
        return view('offdays.show', compact('offday'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offday  $offday
     * @return \Illuminate\Http\Response
     */
    public function edit(Offday $offday)
    {
        return view('offdays.edit', compact('offday'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offday  $offday
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOffdayRequest $request, Offday $offday)
    {
        
        $offday->update($request->validated());

        return redirect()
            ->route('offdays.index')
            ->with('success', __('The offday was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offday  $offday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offday $offday)
    {
        try {
            $offday->delete();

            return redirect()
                ->route('offdays.index')
                ->with('success', __('The offday was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('offdays.index')
                ->with('error', __("The offday can't be deleted because it's related to another table."));
        }
    }
}
