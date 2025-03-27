<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ImageService
{
    protected ImageManager $image;

    public function __construct()
    {
        // Initializing the ImageManager with GD driver
        $this->image = new ImageManager(new Driver());
    }

    /**
     * Upload and process the image.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path
     * @param int $width
     * @param int|null $height
     * @return string
     * @throws \RuntimeException
     */
    public function upload($file, $path, $width = 800, $height = null)
    {
        try {
            // Validate if file is valid
            if (!$file->isValid()) {
                throw new RuntimeException('Invalid file upload');
            }

            // Read the image file into Intervention Image instance
            $image = $this->image->read($file->getRealPath());

            // Set a filename with a timestamp to avoid name conflicts
            $filename = time() . '_' . $file->getClientOriginalName();

            // Resize the image if height is provided, else maintain aspect ratio
            if ($height) {
                $image->resize($width, $height);
            } else {
                $image->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio(); // Maintain aspect ratio
                });
            }

            // Encode the image into WebP format with 80% quality
            $image = $image->encode(new WebpEncoder(80));

            // Store the image in the specified path
            Storage::put($path . '/' . $filename, $image);

            // Return the full path to the stored image
            return $path . '/' . $filename;

        } catch (\Exception $e) {
            throw new RuntimeException('Image processing failed: ' . $e->getMessage());
        }
    }
}
