<?php

namespace Services\Models\Common;

class FilesUploader
{
    public static function ImageUpload($file, $name, $folder, $crop_width = 0, $crop_height = 0, $quality = 100, $allow = array('jpg', 'png', 'jpeg', 'webp', 'gif')): bool
    {
        // Getting file name
        $filename = $file;

        $tmp_name = $file['tmp_name'];

        // Valid extension
        $valid_ext = $allow;

        // Get the file extension
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        $new_file_name = $name . '.' . $extension;

        // Location
        $location = $folder . '/' . $new_file_name;

        // File extension
        $file_extension = strtolower($extension);

        // Check extension
        if (in_array($file_extension, $valid_ext)) {
            // Get the image type
            $image_info = getimagesize($tmp_name);
            // Create an image resource based on the image type
            switch ($image_info[2]) {
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($tmp_name);
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($tmp_name);
                    break;
                case IMAGETYPE_GIF:
                    $image = imagecreatefromgif($tmp_name);
                    break;
                case IMAGETYPE_WEBP:
                    $image = imagecreatefromwebp($tmp_name);
                    break;
                default:
                    // Unsupported image type
                    return false;
            }


            if ($crop_width === 0 && $crop_height === 0) {
                imagejpeg($image, $location, $quality);
                imagedestroy($image); // Free up memory
                return true;
            } else {
                $width = imagesx($image);
                $height = imagesy($image);

                // Usage example:
                $thumb_width = $crop_width; // crop width // 576
                $thumb_height = $crop_height; // crop height // 864

                $original_aspect = $width / $height;
                $thumb_aspect = $thumb_width / $thumb_height;

                if ($original_aspect >= $thumb_aspect) {
                    // If image is wider than thumbnail (in aspect ratio sense)
                    $new_height = $thumb_height;
                    $new_width = $width / ($height / $thumb_height);
                } else {
                    // If the thumbnail is wider than the image
                    $new_width = $thumb_width;
                    $new_height = $height / ($width / $thumb_width);
                }

                $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

                // Resize and crop
                imagecopyresampled(
                    $thumb,
                    $image,
                    0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                    0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                    0,
                    0,
                    $new_width,
                    $new_height,
                    $width,
                    $height
                );

                imagejpeg($thumb, $location, $quality);

                imagedestroy($image); // Free up memory
                imagedestroy($thumb); // Free up memory

                return true;
            }
        } else {
            return false;
        }
        return false;
    }
}
