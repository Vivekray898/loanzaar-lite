<?php

namespace App\Observers;

use App\Models\Lead;

class LeadObserver
{
    /**
     * Handle the Lead "created" event.
     */
    public function created(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "updated" event.
     */
    public function updated(Lead $lead): void
    {
        // Check if status has changed
        if ($lead->isDirty('status')) {
            \App\Models\LeadStatusLog::create([
                'lead_id' => $lead->id,
                'old_status' => $lead->getOriginal('status'),
                'new_status' => $lead->status,
                'changed_by' => auth()->id(),
                'notes' => 'Status changed via admin panel',
            ]);
        }
    }

    /**
     * Handle the Lead "deleted" event.
     */
    public function deleted(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "restored" event.
     */
    public function restored(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "force deleted" event.
     */
    public function forceDeleted(Lead $lead): void
    {
        //
    }
}
