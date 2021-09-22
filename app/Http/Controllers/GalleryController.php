<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Http\Requests\UpdateGalleryRequest;
use App\Http\Requests\CreateGalleryRequest;
use App\Models\User;

class GalleryController extends Controller
{
        public function index(Request $request)
        {
            $term = $request->query('name');
            $per_page = $request->query('per_page', 10);

            $galleries = Gallery::filter($term,$per_page);

            return response()->json($galleries);
        }

    public function showSingleGallery(Gallery $gallery)
        {
            return response()->json($gallery);
        }


    public function showMyGalleries(User $user){
        $galleries = $user->galleries()->with('user')->get();
        return response()->json($galleries);
    }

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
