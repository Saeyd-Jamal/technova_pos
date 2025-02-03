<?php

namespace App\Observers;

use App\Models\Category;
use App\Services\ActivityLogService;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        ActivityLogService::log(
            'Created',
            'Category',
            "تم إضافة صنف : $category->name.",
            null,
            $category->toArray()
        );
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        ActivityLogService::log(
            'Updated',
            'Category',
            "تم تعديل صنف : $category->name.",
            $category->getOriginal(),
            $category->getChanges()
        );
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        ActivityLogService::log(
            'Deleted',
            'Category',
            "تم حذف صنف : $category->name.",
            $category->toArray(),
            null
        );
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
