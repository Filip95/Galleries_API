<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id'
    ];

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function filter($term,$per_page)
    {
        $query = Gallery::query()->with('images');


        if($term) {
            $query->where(function($fnquery) use ($term){
                $fnquery->where('name', 'like', '%'.$term.'%')
                  ->orWhere('description','like', '%'.$term.'%')
                  ->orWhereHas('user', function($q) use ($term){
                      $q->where('first_name', 'like', '%'.$term.'%')
                        ->orWhere('last_name','like', '%'.$term.'%');
                  });
                });
        }

        return response()->json([
            'galleries' =>  $query->latest()->paginate($per_page)
        ]);
    }
}
