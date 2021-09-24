<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gallery;

class UserGalleriesController extends Controller
{
    public function show($user_id){
        $galleries = Gallery::with('images')->where('user_id',$user_id)->get();
        return response()->json($galleries);
    }
}
