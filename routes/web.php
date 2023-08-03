<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Spatie\YamlFrontMatter\YamlFrontMatter;

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
    $posts = Post::all();
    //ddd($posts);
    return view('welcome', [
        'posts' => $posts
    ]);
});

Route::get('/hello', function () {
    return ["Hello" => " World"];
});

Route::get('/posts', function () {

    // $files = File::files(resource_path("posts/"));

    // // Using collections
    // $posts = collect($files)
    //     ->map(function ($file) {
    //         return YamlFrontMatter::parseFile($file);
    //     })
    //     ->map(function ($document) {
    //         return new Post(
    //             $document->title,
    //             $document->excerpt,
    //             $document->date,
    //             $document->body(),
    //             $document->slug
    //         );
    //     });

    // $posts = array_map(function ($file) {
    //     $document = YamlFrontMatter::parseFile($file);

    //     return new Post(
    //         $document->title,
    //         $document->excerpt,
    //         $document->date,
    //         $document->body(),
    //         $document->slug
    //     );
    // }, $files);

    //ddd($posts);

    // $posts = Post::all();

    // //ddd($posts);
    return view(
        'posts',
        [
            'posts' => Post::all()
        ]
    );
});

Route::get('/posts/{post}', function ($slug) {
    $post = Post::find($slug);

    return view('post', [
        'post' => $post
    ]);


    // Most of this logic needs to be in the Model

    //return $slug;
    //     $path = __DIR__ . "/../resources/posts/{$slug}.html";

    //     //ddd($path);
    //     if (!file_exists($path)) {
    //         //dd('file does not exist');
    //         return redirect('/');
    //         //abort(404);
    //     }

    //     // helper functions for adding cache time now->addHour(), addMinutes(20), addDay
    //     // use path can be substituted to $post ... fn() => file_get_contents($path))
    //     $post = cache()->remember("post.{$slug}", 5, function () use ($path) {
    //         var_dump('file_get_contents');
    //         return file_get_contents($path);
    //     });
    //     //$post = file_get_contents($path);
    //     return view('post', [
    //         'post' => $post
    //     ]);
})->where('post', '[A-z_\-]+');

// whereAlphaNumeric('post');
