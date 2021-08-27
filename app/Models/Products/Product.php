<?php
namespace App\Models\Products;

use App\Models\Brands\Brand;
use App\Models\Categories\Category;
use App\Models\Images\Image;
use App\Models\Tools\SearchableTrait;
use App\Models\Variants\Variant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;

class Product extends Model
{
    use SearchableTrait;
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
        return $this->belongsToMany(Image::class, 'products_images', 'product_id', 'image_id')->orderByPivot('sort', 'asc');
    }

    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id');
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
