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
use App\Post;
use App\Category;

Route::get('/create_user', function (){
    $user = User::create([
        'name'      => 'Lufi',
        'email'     => 'lufi.mahmud@gmail.com',
        'password'  => bcrypt('password')
    ]);

    return $user;
});

Route::get('/create_profile', function (){
    // $profile = Profile::create([
    //     'user_id'   => 1,
    //     'phone' => '32141323',
    //     'address'   => 'Jl. Anggrek Selatan Raya 3'
    // ]);

    // return $profile;
    $user = User::find(1);

    $user->profile()->create([
        'phone' => '023483249',
        'address'   => 'Jl. Raya Ku Juga Suka'
    ]);

    return $user;
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

Route::get('/read_user', function () {
    $user = User::find(1);

    $data = [
        'name'  => $user->name,
        'phone' => $user->profile->phone,
        'address'   => $user->profile->address
    ];

    return $data;
});

Route::get('/read_profile', function () {
    $profile = Profile::where('phone', '024243234')->first();

    // return $profile->user->name;
    $data = [
        'name'      => $profile->user->name,
        'email'     => $profile->user->email,
        'phone'     => $profile->phone,
        'address'   => $profile->address
    ];
    return $data;
});

Route::get('/update_profile', function () {
    $user = User::find(2);

    $data = [
        'phone' => '170008',
        'address'   => 'Jl. Aku Cinta Kamu'
    ];
    $user->profile()->update($data);

    // $user->profile()->update([
    //     'phone' => '129128127',
    //     'address'   => 'Jl.Kasih Sayang'
    // ]);

    return $user;
});

Route::get('/delete_profile', function () {
    $user = User::find(1);
    $user->profile()->delete();

    return $user;
});

Route::get('/create_post', function () {
    $user = User::create([
        'name'  => 'MyLufi',
        'email' => 'mylufi@mailo.com',
        'password'  => bcrypt('password')
    ]);

    // $user = User::findOrFail(1);

    $user->posts()->create([
        'title' => 'Ini title dari Post Terbaru My Lufi',
        'body'  => 'Ini isi dari Body yang di coba lewat route Terbaru My Lufi'
    ]);

    return 'success';
});

Route::get('/read_posts', function (){
    $user = User::find(1);

    $posts = $user->posts()->get();

    foreach ($posts as $post){
        $data[] = [
            'name'      => $post->user->name,
            'post_id'   => $post->id,
            'title'     => $post->title,
            'body'      => $post->body,
        ];
    }

    return $data;
});

Route::get('/update_post', function(){
    $user = User::findOrFail(1);

    // $user->posts()->whereId(1)->update([
    $user->posts()->where('id',2)->update([
        'title' => 'ini isian title post update 2',
        'body'  => 'Ini isian body post yang sudah di update 2'
    ]);

    return 'Success';
});

Route::get('/delete_post', function () {
    $user = User::find(2);

    $user->posts()->whereUserId(2)->delete();

    return 'Success';
});

Route::get('/create_category', function () {
    // $post = Post::findOrFail(1);

    // $post->category()->create([
    //     'slug'  => str_slug('PHP', '-'),
    //     'category'  => 'PHP'
    // ]);

    // return 'Success';

    $user = User::create([
        'name'  => 'Efull',
        'email' => 'effulll@sumail.com',
        'password'  => bcrypt('password')
    ]);

    $user->posts()->create([
        'title' => 'New Title',
        'body'  => 'New Body Content Coba Lah'
    ])->category()->create([
        'slug'  => str_slug('Kategori Baru', '-'),
        'category' => 'New Category'
    ]);

    return 'Success';
});

Route::get('/read_category', function () {
    // $post = Post::find(1);

    // $categories = $post->category->where('id',1);

    // foreach($categories as $cat){
    //     echo $cat->slug. '</br>';
    // }

    $category = Category::find(3);

    $posts = $category->posts;

    foreach($posts as $post) {
        echo $post->title. '</br>';
    }
});


Route::get('/attach', function () {
    $post = Post::find(3);
    $post->category()->attach([1,2,3]);

    return 'Success';
});

Route::get('/detach', function () {
    $post = Post::find(3);
    $post->category()->detach([1,2]); //jika array / variable dikosongkan, maka akan menghapus semua data berdasatkan post_id

    return 'Success';
});

Route::get('/sync', function () {
    $post = Post::find(3);
    $post->category()->detach([1,2]);

    return 'Success';
});