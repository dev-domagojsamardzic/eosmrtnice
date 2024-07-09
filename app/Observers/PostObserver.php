<?php

namespace App\Observers;

use App\Models\post;
use Illuminate\Support\Str;

class PostObserver
{
    /**
     * Handle the post "created" event.
     */
    public function saved(post $post): void
    {
        if ($post->isDirty('deceased_full_name_lg')) {
            $post->slug = Str::slug($post->deceased_full_name_lg);
        }
    }
}
