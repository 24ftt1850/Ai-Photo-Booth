<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/access', function () {
    return view('access');
})->name('access');


/*
|--------------------------------------------------------------------------
| Photobooth Pages
|--------------------------------------------------------------------------
*/

Route::get('/photobooth', function () {
    return view('photobooth.create');
})->name('photobooth.create');


Route::get('/photobooth/scene', function () {
    return view('photobooth.scene');
})->name('photobooth.scene');


Route::get('/photobooth/generate', function () {
    return view('photobooth.generate');
})->name('photobooth.generate');


Route::get('/photobooth/result', function () {
    return view('photobooth.result');
})->name('photobooth.result');

Route::get('/photobooth/feedback', function () {
    return view('photobooth.feedback');
})->name('photobooth.feedback');


Route::post('/photobooth/feedback', function (Request $request) {

    $request->validate([
        'rating' => [
            'required',
            'integer',
            'min:1',
            'max:5',
        ],

        'comment' => [
            'nullable',
            'string',
            'max:1000',
        ],

        'theme' => [
            'nullable',
            'string',
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | For now, just confirm feedback was received.
    |--------------------------------------------------------------------------
    |
    | We are NOT saving it to the database yet.
    | We'll do that when we build the admin dashboard.
    |
    */

    return response()->json([
        'success' => true,
        'message' => 'Feedback received.',
    ]);

})->name('photobooth.feedback.store');


/*
|--------------------------------------------------------------------------
| Gemini AI Generation
|--------------------------------------------------------------------------
*/

Route::post(
    '/gemini-generate',
    [GeminiController::class, 'generateImage']
)->name('gemini.generate');