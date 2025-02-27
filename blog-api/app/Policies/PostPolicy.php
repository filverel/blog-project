<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function show(?User $user, Post $post)
    {
        return $post->published == true;
    }

    public function before(?User $user)
    {
        if ($user) { // check if the user is signed in; this is usually done with roles and permissions
            return true;
        }
        return null;
    }
}
