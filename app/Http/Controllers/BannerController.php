<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Http\Requests\{StoreBannerRequest, UpdateBannerRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:banner view')->only('index', 'show');
        $this->middleware('permission:banner create')->only('create', 'store');
        $this->middleware('permission:banner edit')->only('edit', 'update');
        $this->middleware('permission:banner delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $banners = Banner::query();

            return Datatables::of($banners)
                
                ->addColumn('image', function ($row) {
                    if ($row->image == null) {
                    return 'https://via.placeholder.com/350?text=No+Image+Avaiable';
                }
                    return asset('storage/uploads/images/' . $row->image);
                })

                ->addColumn('action', 'banners.include.action')
                ->toJson();
        }

        return view('banners.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBannerRequest $request)
    {
        $attr = $request->validated();
        
        if ($request->file('image') && $request->file('image')->isValid()) {

            $path = storage_path('app/public/uploads/images/');
            $filename = $request->file('image')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('image')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
				$constraint->aspectRatio();
            })->save($path . $filename);

            $attr['image'] = $filename;
        }

        Banner::create($attr);

        return redirect()
            ->route('banners.index')
            ->with('success', __('The banner was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        return view('banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner $banner
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $attr = $request->validated();
        
        if ($request->file('image') && $request->file('image')->isValid()) {

            $path = storage_path('app/public/uploads/images/');
            $filename = $request->file('image')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('image')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
				$constraint->aspectRatio();
            })->save($path . $filename);

            // delete old image from storage
            if ($banner->image != null && file_exists($path . $banner->image)) {
                unlink($path . $banner->image);
            }

            $attr['image'] = $filename;
        }

        $banner->update($attr);

        return redirect()
            ->route('banners.index')
            ->with('success', __('The banner was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        try {
            $path = storage_path('app/public/uploads/images/');

            if ($banner->image != null && file_exists($path . $banner->image)) {
                unlink($path . $banner->image);
            }

            $banner->delete();

            return redirect()
                ->route('banners.index')
                ->with('success', __('The banner was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('banners.index')
                ->with('error', __("The banner can't be deleted because it's related to another table."));
        }
    }
}
