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
})->name('main');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/posts/{postId}/{name?}', function ($id, $name = null) {

    $posts = [
        1 => [
            'title' => 'PHP vs Java',
            'body' => 'It\'s hart to say which one is better!!!'
        ],
        2 => [
            'title' => 'Travel or Marry',
            'body' => 'Pick what will not make you regret :D'
        ],
        3 => [
            'title' => 'Football or Run',
            'body' => '<b>Football has run inside :))</b>'
        ]
    ];

    $welcomeMsg = null;
    if (is_null($name)) {
        $welcomeMsg = "Welcome to our page!";
    } else {
        $welcomeMsg = "Hi " . $name . "! Welcome to our page";
    }

    if (!array_key_exists($id, $posts)) {
        throw new Exception('Post not found');
    }

    return view('post', ['post' => $posts[$id], 'postId' => $id, 'msg' => $welcomeMsg]);
})->name('post');

// Route::get('/about', function () {
//     return view('about');
// });

Route::view('/about', 'about')->name('about');
