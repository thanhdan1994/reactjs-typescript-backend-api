<?php

namespace App\Models\Brands;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;

class Brand extends Model implements HasMedia
{
    use InteractsWithMedia;
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

    public function registerMediaCollections(Media $media = null) : void
    {
        $this->addMediaConversion('logo')
            ->width(220)
            ->height(48);
    }

    public function thumbnail()
    {
        return $this->hasOne(Media::class, 'id', 'logo');
    }

    public function getLogoUrlAttribute()
    {
        $logo = 'https://kuruma-tabinavi.com/wp-content/themes/campingcardesktop/shared/img/default-camping-car.jpg';
        if ($this->thumbnail) :
            $logo = $this->thumbnail->getUrl('logo');
        endif;
        return $logo;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::of($value)->slug('-');
    }
}
