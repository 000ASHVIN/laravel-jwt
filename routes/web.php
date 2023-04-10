<?php

use Illuminate\Support\Facades\Route;

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
    $client_secret = null;
    if(request()->has('client_secret')) {
        $client_secret = request()->get('client_secret');
    }

    return view('welcome', ['client_secret' => $client_secret]);
});
// 7779050731

// https://example.com/order/123/complete?payment_intent=pi_3MuBbESIzbOZZsD90VoENfRj&payment_intent_client_secret=pi_3MuBbESIzbOZZsD90VoENfRj_secret_RGYGMdOsB0NJcJ93zMKGaBUGi&redirect_status=succeeded