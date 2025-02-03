<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\ActivityLogService;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        ActivityLogService::log(
            'Created',
            'Product',
            "تم إضافة منتج : $product->name.",
            null,
            $product->toArray()
        );
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        ActivityLogService::log(
            'Updated',
            'Product',
            "تم تعديل منتج : $product->name.",
            $product->getOriginal(),
            $product->getChanges()
        );
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        ActivityLogService::log(
            'Deleted',
            'Product',
            "تم حذف منتج : $product->name.",
            $product->toArray(),
            null
        );
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
