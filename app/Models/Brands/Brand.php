<?php

namespace App\Models\Brands;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Images\Image;
use Illuminate\Support\Str;

class Brand extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'logo',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function thumbnail()
    {
        return $this->hasOne(Image::class, 'id', 'logo');
    }

    public function getLogoUrlAttribute()
    {
        $logo = env('APP_URL') . DIRECTORY_SEPARATOR . 'images/none_image.png';
        if ($this->thumbnail) :
            $logo = $this->thumbnail->url;
        endif;
        return $logo;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::of($value)->slug('-');
    }
}
