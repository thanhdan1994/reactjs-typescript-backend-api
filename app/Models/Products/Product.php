<?php
namespace App\Models\Products;

use App\Models\Brands\Brand;
use App\Models\Categories\Category;
use App\Models\Tools\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, SearchableTrait;
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'content',
        'parameters',
        'featured_image',
        'category_id',
        'brand_id',
        'amount',
        'unit',
        'user_id',
        'status'
    ];

        /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'parameters' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'products.name' => 5,
            'products.excerpt' => 10,
            'categories.name' => 20
        ],
        'joins' => [
            'categories' => ['products.category_id', 'categories.id'],
            'brands' => ['products.brand_id', 'brands.id'],
        ],
    ];

    /**
     * @param string $text
     * @return Collection
     */
    public function searchProduct(string $text) : Collection
    {
        return self::search($text)->get();
    }

    /**
     * @param string $text
     * @param int $limit
     * @return mixed
     */
    public function searchProductPaginate(string $text, int $limit = 10)
    {
        return self::search($text)->paginate($limit);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->belongsToMany(Media::class, 'media_product', 'product_id', 'media_id');
    }

    public function registerMediaCollections(Media $media = null) : void
    {

        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(150);
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

    public function setParametersAttribute($value)
    {
        $parameters = [];
        foreach ($value as $array_item) {
            if (!is_null($array_item['key'])) {
                $parameters[] = $array_item;
            }
        }
        $this->attributes['parameters'] = json_encode($parameters);
    }
    
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::of($value)->slug('-');
    }
}
