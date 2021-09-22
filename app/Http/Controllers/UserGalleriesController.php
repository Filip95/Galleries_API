<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserGalleriesController extends Controller
{
    public function show(User $author){
        $galleries = $author->galleries()->orderBy('created_at', 'desc');
        return response()->json($galleries);
    }
}
