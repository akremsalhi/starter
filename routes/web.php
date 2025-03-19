<?php

use App\Core\Files\ImageAdder;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Interfaces\ImageInterface;

Route::get('/', function (ImageAdder $imageAdder, string $path) {

    $imageAdder->modify(
        $imageAdder->store(storage_path('app/public/example.jpg'), 'images.jpg'),
        function (ImageInterface $image) {
            $image->resizeDown(500, 500)->save();
        }
    );

    return view('welcome');
});
