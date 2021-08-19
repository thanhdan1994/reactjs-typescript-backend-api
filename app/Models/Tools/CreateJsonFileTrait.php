<?php
namespace App\Models\Tools;

use Illuminate\Support\Facades\Storage;

trait CreateJsonFileTrait
{
    public static function createJsonFilePostDetail($post, $comments)
    {
        $data = array();
        $post->category = $post->category()->first();
        $post->author = $post->author()->first();
        $post->tags = $post->tags;
        $post->featured_image = $post->thumbnailUrl;
        $post->image = !empty($post->getFirstMedia('images'))
            ? $post->getFirstMedia('images')->getFullUrl()
            : $post->thumbnailUrl;
        $data['detail'] = $post;
        $data['comments'] = $comments;
        Storage::disk('local')->put('public/data/posts/'.$post->id.'.json', json_encode($data));
    }

    public static function createJsonFile($filePath, $data, $disk = 'local')
    {
        Storage::disk($disk)->put($filePath, json_encode($data));
    }
}