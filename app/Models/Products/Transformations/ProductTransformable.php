<?php

namespace App\Models\Products\Transformations;

use App\Models\Products\Product;
use App\Models\Variants\Variant;

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
        $prod = new Product;
        $prod->id = (int) $product->id;
        $prod->name = $product->name;
        $prod->slug = $product->slug;
        $prod->price = number_format($product->amount, 0,",",".");
        $prod->data = array_slice($product->parameters, 0, 2);
        $prod->thumbnail = $product->thumbnailUrl;
        return $prod;
    }

    protected function transformProductDetail(Product $product)
    {
        $prod = new Product;
        $prod->id = (int) $product->id;
        $prod->name = $product->name;
        $prod->slug = $product->slug;
        $prod->excerpt = $product->excerpt;
        $prod->content = $product->content;
        $prod->price = number_format($product->amount, 0,",",".");
        $prod->priceInt = $product->amount;
        $prod->data = $product->parameters;
        $prod->thumbnail = $product->thumbnailUrl;
        $productImages = [];
        $product->images->map(function ($image) use (&$productImages) {
            $productImages[] = [
                'small' => $image->url100x100,
                'normal' => $image->url
            ];
        });

        $variantImages = [];
        $variants = $product->variants->map(function (Variant $variant) use (&$variantImages) {
            $variantResponse = new Variant;
            $variantResponse->id = $variant->id;
            $variantResponse->size = $variant->size;
            $variantResponse->color = $variant->color;
            $variantResponse->price = number_format($variant->amount, 0,",",".");
            $variantResponse->thumbnail = $variant->thumbnail->url;
            $variantImages[] = [
                'small' => $variant->thumbnail->url100x100,
                'normal' => $variant->thumbnail->url
            ];
            return  $variantResponse;
        });

        $prod->images = array_merge($variantImages, $productImages);
        $prod->variants = $variants;
        return $prod;
    }
}
