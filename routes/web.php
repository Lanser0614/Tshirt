<?php

use App\Services\ClassMarker\ClassMarkerClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::post('/upload', function (Request $request) {
    $file = $request->file('fileToUpload'); // Retrieve the uploaded file from the request
    $filename = $file->getClientOriginalName(); // Retrieve the original filename

    if (Storage::disk('local')->exists($request->session()->getId()) === false) {
        Storage::disk('local')->makeDirectory($request->session()->getId());
    }
    $path = $request->session()->getId().'/';

    Storage::disk('public')->put($path.$filename, file_get_contents($file));

    return view('welcome', ['files' => Storage::allFiles($path)]);
//    return redirect()->back()->with(['files' => Storage::allFiles($path)]);
});
