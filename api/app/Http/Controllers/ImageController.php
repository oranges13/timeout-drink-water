<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\ImageRepositoryInterface as ImageRepository;
use Illuminate\Support\Facades\Cache;

class ImageController extends Controller
{
    protected $imageRepository;

    /**
     * Create a new controller instance.
     *
     * @param ImageRepository $imageRepository
     */
    public function __construct(ImageRepository $imageRepository)
    {
        $this->middleware('throttle:20');
        $this->imageRepository = $imageRepository;
    }

    public function show($width, $height)
    {
        // Cache result with large image url
        $photo = Cache::remember('photo', 300, function () {
            return $this->imageRepository->getRandom();
        });

        // Image providers accept dynamic width / height and pixel resolution data (see https://docs.imgix.com/apis/rendering for all options)
        $photo['url'] = $photo['url']."w={$width}&h={$height}&dpr=2&auto=compress&cs=tinysrgb";

        return response()->json($photo, 200, ['Access-Control-Allow-Origin' => '*'], JSON_UNESCAPED_SLASHES);
    }
}
