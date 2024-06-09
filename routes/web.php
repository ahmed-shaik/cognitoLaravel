<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    $grantCode = $request->get('code');
    $response = Http::asForm()->withHeaders([
        'Content-Type'=>'application/x-www-form-urlencoded',
        'Authorization'=>'Basic NGhtYTF1Yzg0YmhsNXMzMGd1ZmJ1dXR2cnQ6M2xoNHJlMWlhZjFtOHA0cmZ2dmdsamVuN3Q1dnNlY3JxY2NsdGp0cTNlc2ttM2dvaW1q' 
    ])->post('https://lampserver11.auth.us-west-2.amazoncognito.com/oauth2/token', [
        'grant_type'=>'authorization_code',
        'code'=>$grantCode,
        'redirect_uri'=>'http://localhost:8000/'
    ]);
    
    $decodedResponse = json_decode($response);
    $accessToken = $decodedResponse->access_token;
    $userInfoResponse = Http::asForm()->withHeaders([
        'Content-Type'=>'application/x-www-form-urlencoded',
        'Authorization'=>'Bearer ' .$accessToken 
    ])->get('https://lampserver11.auth.us-west-2.amazoncognito.com/oauth2/userInfo');
    $data = json_decode($userInfoResponse);

    return view('index',['data'=>$data]);
});

