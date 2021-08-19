<?php

namespace App\Models\Products\Transformations;

use App\Models\Products\Product;

trait ProductTransformable
{
    /**
     * Transform the product
     *
     * @param Product $product
     * @return Product
     */
    protected function transformProduct(Product $product)
    {
        $pst = new Product;
        $pst->id = (int) $product->id;
        $pst->name = $product->name;
        $pst->slug = $product->slug;
        $pst->price = number_format($product->amount, 0,",",".");
        $pst->data = array_slice($product->parameters, 0, 2);
        $pst->thumbnail = $product->thumbnailUrl;
        return $pst;
    }

    protected function transformProductDetail(Product $product)
    {
        $pst = new Product;
        $pst->id = (int) $product->id;
        $pst->name = $product->name;
        $pst->slug = $product->slug;
        $pst->excerpt = $product->excerpt;
        $pst->content = $product->content;
        $pst->price = number_format($product->amount, 0,",",".");
        $pst->data = $product->parameters;
        $pst->thumbnail = $product->thumbnailUrl;
        $pst->images = $product->images->map(function ($image) {
            return [
                'small' => $image->getUrl('thumb-350'),
                'normal' => $image->getUrl()
            ];
        });
        return $pst;
    }
}
