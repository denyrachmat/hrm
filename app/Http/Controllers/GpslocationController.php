<?php

namespace App\Http\Controllers;

use App\Models\Gpslocation;
use App\Http\Requests\{StoreGpslocationRequest, UpdateGpslocationRequest};
use Yajra\DataTables\Facades\DataTables;

class GpslocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:gpslocation view')->only('index', 'show');
        $this->middleware('permission:gpslocation create')->only('create', 'store');
        $this->middleware('permission:gpslocation edit')->only('edit', 'update');
        $this->middleware('permission:gpslocation delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $gpslocations = Gpslocation::query();

            return DataTables::of($gpslocations)
                ->addColumn('action', 'gpslocations.include.action')
                ->toJson();
        }

        return view('gpslocations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gpslocations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGpslocationRequest $request)
    {
        
        Gpslocation::create($request->validated());

        return redirect()
            ->route('gpslocations.index')
            ->with('success', __('The gpslocation was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gpslocation  $gpslocation
     * @return \Illuminate\Http\Response
     */
    public function show(Gpslocation $gpslocation)
    {
        return view('gpslocations.show', compact('gpslocation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gpslocation  $gpslocation
     * @return \Illuminate\Http\Response
     */
    public function edit(Gpslocation $gpslocation)
    {
        return view('gpslocations.edit', compact('gpslocation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gpslocation  $gpslocation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGpslocationRequest $request, Gpslocation $gpslocation)
    {
        
        $gpslocation->update($request->validated());

        return redirect()
            ->route('gpslocations.index')
            ->with('success', __('The gpslocation was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gpslocation  $gpslocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gpslocation $gpslocation)
    {
        try {
            $gpslocation->delete();

            return redirect()
                ->route('gpslocations.index')
                ->with('success', __('The gpslocation was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('gpslocations.index')
                ->with('error', __("The gpslocation can't be deleted because it's related to another table."));
        }
    }
}
