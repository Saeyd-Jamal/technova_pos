<?php

namespace App\Observers;

use App\Models\Supplier;
use App\Services\ActivityLogService;

class SupplierObserver
{
    /**
     * Handle the Supplier "created" event.
     */
    public function created(Supplier $supplier): void
    {
        ActivityLogService::log(
            'Created',
            'Supplier',
            "تم إضافة مورد : $supplier->name.",
            null,
            $supplier->toArray()
        );
    }

    /**
     * Handle the Supplier "updated" event.
     */
    public function updated(Supplier $supplier): void
    {
        ActivityLogService::log(
            'Updated',
            'Supplier',
            "تم تعديل مورد : $supplier->name.",
            $supplier->getOriginal(),
            $supplier->getChanges()
        );
    }

    /**
     * Handle the Supplier "deleted" event.
     */
    public function deleted(Supplier $supplier): void
    {
        ActivityLogService::log(
            'Deleted',
            'Supplier',
            "تم حذف مورد : $supplier->name.",
            $supplier->toArray(),
            null
        );
    }

    /**
     * Handle the Supplier "restored" event.
     */
    public function restored(Supplier $supplier): void
    {
        //
    }

    /**
     * Handle the Supplier "force deleted" event.
     */
    public function forceDeleted(Supplier $supplier): void
    {
        //
    }
}
