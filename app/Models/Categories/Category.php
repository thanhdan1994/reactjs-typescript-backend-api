<?php

namespace App\Models\Categories;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia
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

    public function registerMediaCollections(Media $media = null) : void
    {
        $this->addMediaConversion('thumb-350')
            ->width(350)
            ->height(240);
    }

    public function thumbnail()
    {
        return $this->hasOne(Media::class, 'id', 'featured_image');
    }

    public function getThumbnailUrlAttribute()
    {
        $thumbnail = 'https://kuruma-tabinavi.com/wp-content/themes/campingcardesktop/shared/img/default-camping-car.jpg';
        if ($this->thumbnail) :
            $thumbnail = $this->thumbnail->getUrl('thumb-350');
        endif;
        return $thumbnail;
    }
}
