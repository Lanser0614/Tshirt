<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::any('/', function (Request $request) {
    Log::info('classMacker', $request->all());
    return new JsonResponse(
        [
            "status" => "success",
        ],
        200
    );
});


Route::post('/upload', function (Request $request) {
    $file = $request->file('fileToUpload'); // Retrieve the uploaded file from the request
    $filename = $file->getClientOriginalName(); // Retrieve the original filename

    if (Storage::disk('local')->exists($request->session()->getId()) === false) {
        Storage::disk('local')->makeDirectory($request->session()->getId());
    }

    Storage::disk('local')->put($request->session()->getId().'/'.$filename, file_get_contents($file));

    return redirect()->back();
});
