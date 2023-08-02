<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

class Post
{
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
