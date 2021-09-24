<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Gallery;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Gallery $gallery,CreateCommentRequest $request){
        $data = $request->validated();

        $comment = new Comment;
        $comment->body = $data['body'];
        $comment->user()->associate(Auth::user());
        $comment->gallery()->associate($gallery);
        $comment->save();
        return response()->json($comment,201);
    }
    public function destroy(Comment $comment){
        $comment -> delete();
        return response()->noContent();
    }
}
