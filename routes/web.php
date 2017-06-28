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

use App\Post;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('feed/json', function () {
    $posts = Post::limit(20)->get();

    $data = [
        'version' => '',
        'title' => '',
        'home_page_url' => '',
        'feed_url' => '',
        'icon' => '',
        'favicon' => '',
        'items' => [],
    ];

    foreach ($posts as $key => $post) {
        $data['items'][$key] = [
            'id' => $post->id,
            'title' => $post->title,
            'url' => $post->url,
            'image' => $post->image,
            'content_html' => $post->content_html,
            'date_published' => $post->created_at->tz('UTC')->toRfc3339String(),
            'date_modified' => $post->updated_at->tz('UTC')->toRfc3339String(),
            'author' => [
                'name' => $post->user->name
            ],
        ];
    }

    return $data;
});
