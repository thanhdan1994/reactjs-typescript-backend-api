<?php

namespace App\Models\Brands\Transformations;

use App\Models\Brands\Brand;

trait BrandTransformable
{
    /**
     * Transform the brand
     *
     * @param Brand $brand
     * @return Brand
     */
    protected function transformBrand(Brand $brand)
    {
        $new_brand = new Brand;
        $new_brand->id = $brand->id;
        $new_brand->name = $brand->name;
        $new_brand->slug = $brand->slug;
        $new_brand->logo = $brand->logoUrl;
        return $new_brand;
    }
}
