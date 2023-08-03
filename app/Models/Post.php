<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }

    public static function find($slug)
    {
        $posts = static::all();

        $post = $posts->firstWhere('slug', $slug);

        //dd($post);
        return $post;

        // $path = resource_path("posts/{$slug}.html");

        // //ddd($path);
        // if (!file_exists($path)) {
        //     //dd('file does not exist');
        //     throw ModelNotFoundException();
        //     //abort(404);
        // }

        // return $post = cache()->remember("posts.{$slug}", 5, fn () => file_get_contents($path));
    }

    public static function all()
    {
        return cache()->rememberForever('post.all', function () {
            $files = File::files(resource_path("posts/"));

            // Using collections
            return collect($files)
                ->map(function ($file) {
                    return YamlFrontMatter::parseFile($file);
                })
                ->map(function ($document) {
                    return new Post(
                        $document->title,
                        $document->excerpt,
                        $document->date,
                        $document->body(),
                        $document->slug
                    );
                })->sortBy('date');
        });
    }
}
