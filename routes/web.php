<?php

use App\Core\Files\ImageAdder;
use Illuminate\Support\Facades\Route;
use Spatie\Image\Image;

Route::get('/', function (ImageAdder $imageAdder) {

    $imageAdder->modify(
        $imageAdder->store(storage_path('app/public/example.jpg'), 'images.jpg'),
        function (Image $image, string $path) {
            $image
            ->save();
        }
    );

    return view('welcome');
});
