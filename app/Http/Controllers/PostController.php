<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class PostController extends Controller
{
    public function show(Post $post): Factory|View
    {
        $post->load('seo');

        return view('frontend.post.show', [
            'post' => $post,
        ]);
    }
}
