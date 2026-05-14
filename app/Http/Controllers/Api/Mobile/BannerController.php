<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function getAllBanners(Request $request)
    {
        return response()->json([
            'code' => 200,
            'msg' => 'OK',
            'data' => Banner::orderBy('position', 'ASC')->get()->map(function ($banner) {
                $banner->image = url('/storage/uploads/images/' . $banner->image);

                return $banner;
            })
        ]);
    }
}
