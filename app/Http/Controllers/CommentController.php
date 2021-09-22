<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Gallery;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Gallery $gallery,CreateCommentRequest $request){
        $data = $request->validated();
        $comment = $gallery->comments()->create($data);
        return response()->json($comment,201);
    }
    public function destroy(Comment $comment){
        $comment -> delete();
        return response()->noContent();
    }
}
