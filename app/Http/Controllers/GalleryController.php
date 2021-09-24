<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Http\Requests\UpdateGalleryRequest;
use App\Http\Requests\CreateGalleryRequest;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
        public function index(Request $request)
        {
            $term = $request->query('name');
            $per_page = $request->query('per_page', 10);

            $galleries = Gallery::filter($term)->paginate($per_page);

            return response()->json($galleries);
        }

    public function showSingleGallery(Gallery $gallery)
        {
            $gallery->load('images','user' ,'comments');
            return response()->json($gallery);
        }


    public function showMyGalleries($user_id){
        $galleries = Gallery::with('images')->where('user_id',$user_id)->get();
        return response()->json($galleries);
    }

    public function store(CreateGalleryRequest $request){
        $data = $request->validated();

        $gallery = new Gallery;
        $gallery->name = $data['name'];
        $gallery->description = $data['description'];
        $gallery->user()->associate(Auth::user());
        $gallery->save();

        $image = new Image;
        $image->image_url = $data['image_url'];
        $image->gallery()->associate($gallery);
        $image->save();

        return response()->json($gallery);
    }
    // ['name' => $data['name']],['description' => $data['description']]

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
