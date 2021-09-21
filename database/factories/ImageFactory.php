<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Gallery;


class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    private $imageUrls = [
        'https://upload.wikimedia.org/wikipedia/commons/c/c3/AA78_by_Zdzislaw_Beksinski_1978.jpg',
        'https://leoplaw.com/wp-content/uploads/2009/08/beksinski.jpg',
        'https://leoplaw.com/wp-content/uploads/2009/08/l_7e6a23eed7879a1ecd8c3ede501600fd.jpg',
        'https://miro.medium.com/proxy/1*QSzr0TEaY9kj3jAr4UaLzw.jpeg',
        'https://media.architecturaldigest.com/photos/5b115f27c650232a884f70da/master/w_1920%2Cc_limit/3.%2520Hand%2520with%2520Reflecting%2520Sphere.jpg',
        'https://media.architecturaldigest.com/photos/5b115f2775a4f940de3daa82/master/w_1920%2Cc_limit/8.%2520Day%2520and%2520Night.jpg',
        'https://media.architecturaldigest.com/photos/5b115f2775a4f940de3daa82/master/w_1920%2Cc_limit/8.%2520Day%2520and%2520Night.jpg',
        'https://media.architecturaldigest.com/photos/5b115f2a75a4f940de3daa84/master/w_1920%2Cc_limit/12.%2520Up%2520and%2520Down.jpg',
        'https://media.architecturaldigest.com/photos/5b115f2aa7a427430454e81f/master/w_1920%2Cc_limit/11.%2520Belvedere.jpg',
        'https://upload.wikimedia.org/wikipedia/en/d/dd/The_Persistence_of_Memory.jpg',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image_url' => $this->faker->randomElement($this->imageUrls),
            'gallery_id' => Gallery::inRandomOrder()->first()->id,
        ];
    }
}
