<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Http\Requests\UpdateGalleryRequest;
use App\Http\Requests\CreateGalleryRequest;

class GalleryController extends Controller
{
        public function index(Request $request)
        {
            $gallery = Gallery::all();
            return response()->json($gallery);
        }

    public function showSingleGallery(Gallery $gallery)
        {
            return response()->json($gallery);
        }

    public function showMyGalleries(){}

    public function create(CreateGalleryRequest $request){
        $data = $request->validated();
        $gallery = Gallery::create($data);
        return response()->json($gallery,201);
    }

    public function update(Gallery $gallery, UpdateGalleryRequest $request ){
        $data = $request->validated();
        if (
            $request->get('name') &&
            $request->get('description') &&
            Gallery::where('name', $request->get('name'))
            ->where('description', $request->get('description'))
            ->where('id', '!=', $gallery->id)
            ->exists()
        ) {
            return response()->json([
                'message' => "Movie with the same title and release_date already exists"
            ], 400);
        }
        $gallery->update($data);

        return response()->json($gallery);
    }


    public function destroy(Gallery $gallery)
        {
            $gallery->delete();
            return response()->noContent();
        }
}
