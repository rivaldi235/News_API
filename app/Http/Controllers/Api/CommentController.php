<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required'
        ]);

        $commentData = [
            'user_id' => $request->user()->id,
            'post_id' => $request->input('post_id'),
            'comment' => $request->input('comment'),
        ];
        
        // Simpan data komentar ke dalam Redis sebagai antrian 
        Redis::rpush('comment_queue', json_encode($commentData));

        
        //Menyimpan data dari antrian redis ke database Mysql
        $comment = new Comment();
        $comment->user_id = $commentData['user_id'];
        $comment->post_id = $commentData['post_id'];
        $comment->comment = $commentData['comment'];
        $comment->save();

        return new CommentResource($comment->loadMissing(['comentator:id,name']));
    }

}
