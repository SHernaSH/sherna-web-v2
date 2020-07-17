<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Class handling AJAX calls from Summernote/Tinymce WYSIWYG editors to upload images
 *
 * Class ImageController
 * @package App\Http\Controllers\Admin
 */
class ImageController extends Controller
{
    /**
     * Get the image form the storage
     *
     * @param string $name   name of the file
     * @return string         path of the file
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getImage(string $name)
    {
        $disk = Storage::disk('local');

        return $disk->get('/summer_images/' . $name);
    }

    /**
     * Save the image to the storage
     *
     * @param Request $request  request containing the file to be saves
     * @return string           path to the image from the storage
     */
    public function saveImage(Request $request)
    {
        $disk = Storage::disk('local');
        if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                $name = md5(rand(100, 200));
                $ext = explode('.', $_FILES['file']['name']);
                $filename = $name . '.' . $ext[1];

//                $destination = '/assets/images/' . $filename; //change this directory
                $destination = public_path();
                $destination .= "/summer_images/";


                $location = $_FILES["file"]["tmp_name"];

                if (!file_exists($destination)) {
                    File::makeDirectory($destination);
                }
                move_uploaded_file($location, $destination . $filename);
                return asset(url('/summer_images/' . $filename));
            } else {
                echo $message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            }
        }
    }
}
