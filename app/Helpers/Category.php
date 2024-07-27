<?php

namespace App\Helpers;
use App\Models\Category;

class CategoryHelper
{
    public static function getCategoryChain($categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return '';
        }

        $chain = [$category->category];

        while ($category->parent) {
            $category = $category->parent;
            array_unshift($chain, $category->category); // Başına ekle
        }

        return implode('-', $chain);
    }
}