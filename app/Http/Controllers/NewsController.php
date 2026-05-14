<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Requests\{StoreNewsRequest, UpdateNewsRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:news view')->only('index', 'show');
        $this->middleware('permission:news create')->only('create', 'store');
        $this->middleware('permission:news edit')->only('edit', 'update');
        $this->middleware('permission:news delete')->only('destroy');
    }

    public function index()
    {
        if (request()->ajax()) {
            $news =  DB::table('news')
                ->leftJoin('categorynews', 'news.categorynews_id', '=', 'categorynews.id')
                ->leftJoin('users', 'news.user_id', '=', 'users.id')
                ->select(
                    'news.*',
                    'categorynews.category_name',
                    'users.name as nama_user'
                );
            $news = $news->orderBy('news.id', 'DESC')->get();

            return Datatables::of($news)
                ->addColumn('description', function ($row) {
                    return str($row->description)->limit(100);
                })
                ->addColumn('categorynews', function ($row) {
                    return $row->category_name;
                })->addColumn('user', function ($row) {
                    return $row->nama_user;
                })
                ->addColumn('action', 'news.include.action')
                ->toJson();
        }

        return view('news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('thumbnail') && $request->file('thumbnail')->isValid()) {

            $path = storage_path('app/public/uploads/thumbnails/');
            $filename = $request->file('thumbnail')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('thumbnail')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            $attr['thumbnail'] = $filename;
        }

        if ($request->file('file_attachment') && $request->file('file_attachment')->isValid()) {

            $path = storage_path('app/public/uploads/file_attachments/');
            $filename = $request->file('file_attachment')->hashName();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $request->file('file_attachment')->move($path, $filename);

            $attr['file_attachment'] = $filename;
        }

        News::create($attr);

        return redirect()
            ->route('news.index')
            ->with('success', __('The news was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        $news->load('categorynews:id,created_at', 'user:id,created_at');

        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $news->load('categorynews:id,created_at', 'user:id,created_at');

        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News $news
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        $attr = $request->validated();

        if ($request->file('thumbnail') && $request->file('thumbnail')->isValid()) {

            $path = storage_path('app/public/uploads/thumbnails/');
            $filename = $request->file('thumbnail')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('thumbnail')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            // delete old thumbnail from storage
            if ($news->thumbnail != null && file_exists($path . $news->thumbnail)) {
                unlink($path . $news->thumbnail);
            }

            $attr['thumbnail'] = $filename;
        }
        if ($request->file('file_attachment') && $request->file('file_attachment')->isValid()) {

            $path = storage_path('app/public/uploads/file_attachments/');
            $filename = $request->file('file_attachment')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Simpan file yang diunggah
            $request->file('file_attachment')->move($path, $filename);

            // Hapus file_attachment lama dari penyimpanan
            if ($news->file_attachment != null && file_exists($path . $news->file_attachment)) {
                unlink($path . $news->file_attachment);
            }

            $attr['file_attachment'] = $filename;
        }

        $news->update($attr);

        return redirect()
            ->route('news.index')
            ->with('success', __('The news was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        try {
            $path = storage_path('app/public/uploads/thumbnails/');

            if ($news->thumbnail != null && file_exists($path . $news->thumbnail)) {
                unlink($path . $news->thumbnail);
            }
            $path = storage_path('app/public/uploads/file_attachments/');

            if ($news->file_attachment != null && file_exists($path . $news->file_attachment)) {
                unlink($path . $news->file_attachment);
            }

            $news->delete();

            return redirect()
                ->route('news.index')
                ->with('success', __('The news was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('news.index')
                ->with('error', __("The news can't be deleted because it's related to another table."));
        }
    }
}
