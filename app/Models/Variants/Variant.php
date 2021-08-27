<?php
namespace App\Models\Variants;

use Illuminate\Database\Eloquent\Model;
use App\Models\Images\Image;
use App\Models\Products\Product;

class Variant extends Model
{
    protected $fillable = [
        'size',
        'color',
        'product_id',
        'amount',
        'amount_root',
        'quantity',
        'featured_image'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function thumbnail()
    {
        return $this->hasOne(Image::class, 'id', 'featured_image');
    }

    public function getThumbnailUrlAttribute()
    {
        $thumbnail = env('APP_URL') . DIRECTORY_SEPARATOR . 'images/none_image.png';
        if ($this->thumbnail) :
            $thumbnail = $this->thumbnail->url;
        endif;
        return $thumbnail;
    }

    public function getThumbnailUrl50x50Attribute()
    {
        $thumbnail = env('APP_URL') . DIRECTORY_SEPARATOR . 'images/none_image.png';
        if ($this->thumbnail) :
            $thumbnail = $this->thumbnail->url50x50;
        endif;
        return $thumbnail;
    }

    public function getThumbnailUrl100x100Attribute()
    {
        $thumbnail = env('APP_URL') . DIRECTORY_SEPARATOR . 'images/none_image.png';
        if ($this->thumbnail) :
            $thumbnail = $this->thumbnail->url100x100;
        endif;
        return $thumbnail;
    }
}