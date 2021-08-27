<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Images\Image;
use Illuminate\Http\Request;
use Carbon\Carbon;
use InterventionImage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $response = [];
        foreach ($request->filesUpload as $key => $file) {
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '-' . Carbon::now()->timestamp;
            $fileExt = $file->extension();
            $file->storeAs('public/images', $fileName . '.' . $fileExt);
            $image = Image::create([
                'name' => $fileName,
                'ext' => $fileExt,
                'store_path' => 'storage/images'
            ]);

            $destinationPath  = storage_path('app/public') . '/images/';
            $img = InterventionImage::make($file->path());
            $img->fit(100, 100, function ($constraint) { 
                $constraint->upsize();
            })->save($destinationPath . $fileName . '-100x100' . '.' . $fileExt, 80);

            $response[$key]['url'] = $image->url;
            $response[$key]['id'] = $image->id;
        }
        return $response;
    }

    public function destroy()
    {
        
    }
}