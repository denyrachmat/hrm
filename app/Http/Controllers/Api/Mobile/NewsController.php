<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function getAllNews(Request $request)
    {
        $newsPagination = News::orderBy('date', 'DESC')->simplePaginate($request->size ? $request->size : 10);
        $newsPagination->getCollection()->transform(function ($news) {
            $news->thumbnail = url('/storage/uploads/thumbnails/' . $news->thumbnail);
            $news->categorynews;
            $news->user;

            return $news;
        });

        return response()->json([
            'code' => 200,
            'msg' => 'OK',
            'data' => $newsPagination
        ]);
    }

    public function showNewsDetail($id)
    {
        $news = News::find($id);

        $news->thumbnail = url('/storage/uploads/thumbnails/' . $news->thumbnail);
        if ($news->file_attachment !== null) {
            $news->file_attachment = url('/storage/uploads/file_attachments/' . $news->file_attachment);
        } else {
            $news->file_attachment = null;
        }


        $news->categorynews;
        $news->user;

        return response()->json([
            'code' => 200,
            'msg' => 'OK',
            'data' => $news
        ]);
    }
}
