<?php

namespace App\Models;

class Post
{
    public static function find($slug)
    {

        $path = resource_path("posts/{$slug}.html");

        //ddd($path);
        if (!file_exists($path)) {
            //dd('file does not exist');
            return redirect('/');
            //abort(404);
        }

        return $post = cache()->remember("posts.{$slug}", 5, fn () => file_get_contents($path));
    }
}
