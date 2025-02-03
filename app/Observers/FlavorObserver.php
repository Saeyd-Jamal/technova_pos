<?php

namespace App\Observers;

use App\Models\Flavor;
use App\Services\ActivityLogService;

class FlavorObserver
{
    /**
     * Handle the Flavor "created" event.
     */
    public function created(Flavor $flavor): void
    {
        ActivityLogService::log(
            'Created',
            'Flavor',
            "تم إضافة نكهة : $flavor->name.",
            null,
            $flavor->toArray()
        );
    }

    /**
     * Handle the Flavor "updated" event.
     */
    public function updated(Flavor $flavor): void
    {
        ActivityLogService::log(
            'Updated',
            'Flavor',
            "تم تعديل نكهة : $flavor->name.",
            $flavor->getOriginal(),
            $flavor->getChanges()
        );
    }

    /**
     * Handle the Flavor "deleted" event.
     */
    public function deleted(Flavor $flavor): void
    {
        ActivityLogService::log(
            'Deleted',
            'Flavor',
            "تم حذف نكهة : $flavor->name.",
            $flavor->toArray(),
            null
        );
    }

    /**
     * Handle the Flavor "restored" event.
     */
    public function restored(Flavor $flavor): void
    {
        //
    }

    /**
     * Handle the Flavor "force deleted" event.
     */
    public function forceDeleted(Flavor $flavor): void
    {
        //
    }
}
