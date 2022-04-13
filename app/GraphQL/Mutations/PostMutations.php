<?php

namespace App\GraphQL\Mutations;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostMutations
{
    public function createPost($_, array $args){
        $args['user_id'] = Auth::id();
        return Post::create($args);
    }

    public function editPost($_, array $args){

        $post = Post::find($args['id']);

        return tap(Post::find($args['id']))
            ->update($args);

    }

    public function deletePost($_, array $args){
        return Post::find($args['id'])->delete();
    }
}