<?php

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

Route::get('/', function () {
    return view('welcome');
});

use App\User;
use App\Profile;

Route::get('/create_user', function (){
    $user = User::create([
        'name'      => 'Lufi',
        'email'     => 'lufi.mahmud@gmail.com',
        'password'  => bcrypt('password')
    ]);

    return $user;
});

Route::get('/create_profile', function (){
    $profile = Profile::create([
        'user_id'   => 1,
        'phone' => '32141323',
        'address'   => 'Jl. Anggrek Selatan Raya 3'
    ]);

    return $profile;
});

Route::get('/create_user_profile', function () {
    $user = User::find(2);

    $profile = new Profile([
        'phone' => '024243234',
        'address'   => 'Jalan Raya Sawo Matang 3'
    ]);

    $user->profile()->save($profile);
    return $user;
});