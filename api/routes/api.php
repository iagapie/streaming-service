<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get(
//    '/user',
//    function (Request $request) {
//        return $request->user();
//    }
//);

Route::get(
    '/playlist',
    function () {
        $data = array_map(
            function ($file) {
                if (!str_ends_with($file, '.mp3')) {
                    return false;
                }

                $id3 = new getID3();
                $id3->setOption(['encoding' => 'UTF-8']);

                $info = $id3->analyze(storage_path('app/media/'.$file));

                $id3->CopyTagsToComments($info);

                $tags = $info['tags']['id3v2'] ?? [];
                $picture = $info['comments']['picture'][0] ?? [];

                $img = isset($picture['image_mime'], $picture['data'])
                    ? 'data:'.$picture['image_mime'].';base64,'.base64_encode($picture['data'])
                    : null;

                if (isset($tags['title'][0])) {
                    $title = $tags['title'][0];
                } else {
                    $tmp = explode('/', $file);
                    $title = array_pop($tmp);
                    $title = str_replace(['.mp3', '_'], ['', ' '], $title);
                }

                return [
                    'title' => $title,
                    'genres' => explode(';', $tags['genre'][0] ?? ''),
                    'artist' => $tags['artist'][0] ?? null,
                    'file' => $file,
                    'duration' => (int)round($info['playtime_seconds'] ?? 0),
                    'img' => $img,
                ];
            },
            Storage::disk('media')->allFiles()
        );

        $data = array_filter($data);
        $data = array_values($data);

        return response()->json($data);
    }
);

Route::get(
    '/song/{name}',
    function (string $name) {
        if (Storage::disk('media')->exists($name)) {
            $filePath = storage_path('app/media/'.$name);

            return response()->file($filePath);
        }

        return response('Not Found', 404);
    }
)->where('name', '(.*)');
