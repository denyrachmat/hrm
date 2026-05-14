<?php

namespace App\Http\Controllers;

use App\Models\Categorynews;
use App\Http\Requests\{StoreCategorynewsRequest, UpdateCategorynewsRequest};
use Yajra\DataTables\Facades\DataTables;

class CategorynewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:categorynews view')->only('index', 'show');
        $this->middleware('permission:categorynews create')->only('create', 'store');
        $this->middleware('permission:categorynews edit')->only('edit', 'update');
        $this->middleware('permission:categorynews delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $categorynews = Categorynews::query();

            return DataTables::of($categorynews)
                ->addColumn('action', 'categorynews.include.action')
                ->toJson();
        }

        return view('categorynews.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorynews.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategorynewsRequest $request)
    {
        
        Categorynews::create($request->validated());

        return redirect()
            ->route('categorynews.index')
            ->with('success', __('The categorynews was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorynews  $categorynews
     * @return \Illuminate\Http\Response
     */
    public function show(Categorynews $categorynews)
    {
        return view('categorynews.show', compact('categorynews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorynews  $categorynews
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorynews $categorynews)
    {
        return view('categorynews.edit', compact('categorynews'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorynews  $categorynews
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategorynewsRequest $request, Categorynews $categorynews)
    {
        
        $categorynews->update($request->validated());

        return redirect()
            ->route('categorynews.index')
            ->with('success', __('The categorynews was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorynews  $categorynews
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorynews $categorynews)
    {
        try {
            $categorynews->delete();

            return redirect()
                ->route('categorynews.index')
                ->with('success', __('The categorynews was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('categorynews.index')
                ->with('error', __("The categorynews can't be deleted because it's related to another table."));
        }
    }
}
