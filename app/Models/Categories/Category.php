<?php

namespace App\Models\Categories;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;
use App\Models\Images\Image;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'parent',
        'featured_image',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    //each category might have one parent
    public function parent() {
        return $this->belongsTo(static::class, 'parent');
    }

    //each category might have multiple children
    public function children() {
        return $this->belongsToMany(static::class, 'parent')->orderBy('id', 'DESC');
    }

    public function thumbnail()
    {
        return $this->hasOne(Image::class, 'id', 'featured_image');
    }

    public function getThumbnailUrlAttribute()
    {
        $thumbnail = env('APP_URL') . DIRECTORY_SEPARATOR . 'images/none_image.png';
        if ($this->thumbnail) :
            $thumbnail = $this->thumbnail->getUrl('thumb-350');
        endif;
        return $thumbnail;
    }
}
