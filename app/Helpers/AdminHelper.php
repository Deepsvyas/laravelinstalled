<?php

namespace App\Helpers;

use App\Models\Categories;
use App\Models\TrendingTags;

class AdminHelper {

    public static function countTotalCategories() {
        $catObj = new Categories();
        return $catObj->countTotalCategories();
    }

    public static function countTotalTrendingTag() {
        $tagObj = new TrendingTags();
        return $tagObj->countTotalTrendingTag();
    }

}
