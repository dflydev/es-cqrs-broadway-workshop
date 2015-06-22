<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\Adapter\SuperAwesome\Eloquent;

use SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\PostCategoryCount;
use SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\PostCategoryCountRepository;

class EloquentPostCategoryCountRepositoryimplements implements PostCategoryCountRepository
{
    public function find($category)
    {
        try {
            return PostCategoryCount::firstOrFail([
                'category' => $category,
            ]);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function findAll()
    {
        return PostCategoryCount::get();
    }

    public function increment($category)
    {
        DB::transactional(function () use ($category) {
            $post_category_count = PostCategoryCount::firstOrNew([
                'category' => $category,
            ]);

            $post_category_count->category_count++;
            $post_category_count->save();
        });
    }

    public function decrement($category)
    {
        DB::transactional(function () use ($category) {
            $post_category_count = PostCategoryCount::firstOrNew([
                'category' => $category,
            ]);

            $post_category_count->category_count--;
            $post_category_count->save();
        });
    }
}
