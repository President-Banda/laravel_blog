<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

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

        $path = resource_path("posts/{$slug}.html");

        //ddd($path);
        if (!file_exists($path)) {
            //dd('file does not exist');
            throw ModelNotFoundException();
            //abort(404);
        }

        return $post = cache()->remember("posts.{$slug}", 5, fn () => file_get_contents($path));
    }

    public static function all()
    {
        $files = File::files(resource_path("posts/"));

        return array_map(function ($file) {
            return $file->getContents();
        }, $files);
    }
}
