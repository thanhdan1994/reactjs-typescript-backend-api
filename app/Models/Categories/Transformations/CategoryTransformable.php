<?php

namespace App\Models\Categories\Transformations;

use App\Models\Categories\Category;

trait CategoryTransformable
{
    /**
     * Transform the post
     *
     * @param Category $post
     * @return Category
     */
    protected function transformCategory(Category $category)
    {
        $new_category = new Category;
        $new_category->id = (int) $category->id;
        $new_category->name = $category->name;
        $new_category->slug = $category->slug;
        $new_category->taxonomy = $category->taxonomy;
        $new_category->parent = $category->parent;
        $new_category->thumbnail = $category->thumbnailUrl;
        $new_category->parent_name = $category->category;
        $new_category->total_places = $category->places_count;
        $new_category->total_posts = $category->posts_count;
        if (!empty($category->parent()->first())) {
            $new_category->parent_name = $category->parent()->first()->category;
        }
        $new_category->created_at = $category->created_at;
        $new_category->updated_at = $category->updated_at;
        return $new_category;
    }
}
