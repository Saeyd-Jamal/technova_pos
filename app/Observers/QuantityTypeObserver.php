<?php

namespace App\Observers;

use App\Models\QuantityType;
use App\Services\ActivityLogService;

class QuantityTypeObserver
{
    /**
     * Handle the QuantityType "created" event.
     */
    public function created(QuantityType $quantityType): void
    {
        ActivityLogService::log(
            'Created',
            'QuantityType',
            "تم إضافة نوع كمية : $quantityType->name.",
            null,
            $quantityType->toArray()
        );
    }

    /**
     * Handle the QuantityType "updated" event.
     */
    public function updated(QuantityType $quantityType): void
    {
        ActivityLogService::log(
            'Updated',
            'QuantityType',
            "تم تعديل نوع كمية : $quantityType->name.",
            $quantityType->getOriginal(),
            $quantityType->getChanges()
        );
    }

    /**
     * Handle the QuantityType "deleted" event.
     */
    public function deleted(QuantityType $quantityType): void
    {
        ActivityLogService::log(
            'Deleted',
            'QuantityType',
            "تم حذف نوع كمية : $quantityType->name.",
            $quantityType->toArray(),
            null
        );
    }

    /**
     * Handle the QuantityType "restored" event.
     */
    public function restored(QuantityType $quantityType): void
    {
        //
    }

    /**
     * Handle the QuantityType "force deleted" event.
     */
    public function forceDeleted(QuantityType $quantityType): void
    {
        //
    }
}
