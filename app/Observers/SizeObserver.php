<?php

namespace App\Observers;

use App\Models\Size;
use App\Services\ActivityLogService;

class SizeObserver
{
    /**
     * Handle the Size "created" event.
     */
    public function created(Size $size): void
    {
        ActivityLogService::log(
            'Created',
            'Size',
            "تم إضافة حجم : $size->name.",
            null,
            $size->toArray()
        );
    }

    /**
     * Handle the Size "updated" event.
     */
    public function updated(Size $size): void
    {
        ActivityLogService::log(
            'Updated',
            'Size',
            "تم تعديل حجم : $size->name.",
            $size->getOriginal(),
            $size->getChanges()
        );
    }

    /**
     * Handle the Size "deleted" event.
     */
    public function deleted(Size $size): void
    {
        ActivityLogService::log(
            'Deleted',
            'Size',
            "تم حذف حجم : $size->name.",
            $size->toArray(),
            null
        );
    }

    /**
     * Handle the Size "restored" event.
     */
    public function restored(Size $size): void
    {
        //
    }

    /**
     * Handle the Size "force deleted" event.
     */
    public function forceDeleted(Size $size): void
    {
        //
    }
}
