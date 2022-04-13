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
        if(isset($args['force_edit']) && $args['force_edit'] ){
            $args = array_diff_key($args, array_flip(['directive']));
            return tap(Post::find($args['id']))
            ->update($args);
        }
        $post = Post::find($args['id']);
        if($post->user->id != Auth::id()){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'input.id' => ["Permission denied."],
            ]);
            throw $error;
        }
        $args = array_diff_key($args, array_flip(['directive']));
        return tap(Post::find($args['id']))
            ->update($args);

    }

    public function deletePost($_, array $args){
        if(isset($args['force_delete']) && $args['force_delete']) 
            return Post::destroy($args['id']) > 0 ? true : false;
        $dev = Post::find($args['id']);
        if($dev->user->id != Auth::id()){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'input.id' => ["Permission denied."],
            ]);
            throw $error;
        }
        return Post::destroy($args['id']);
    }
}