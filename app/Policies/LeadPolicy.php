<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admins and agents can view all leads, users can view their own
        return $user->canManageLeads() || $user->isUser();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Lead $lead): bool
    {
        // Admins can view all leads
        if ($user->isAdmin()) {
            return true;
        }

        // Agents can view leads assigned to them or unassigned leads
        if ($user->isAgent()) {
            return $lead->assigned_to === $user->id || $lead->assigned_to === null;
        }

        // Users can only view their own leads
        return $lead->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // All authenticated users can create leads
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lead $lead): bool
    {
        // Admins can update all leads
        if ($user->isAdmin()) {
            return true;
        }

        // Agents can update leads assigned to them
        if ($user->isAgent()) {
            return $lead->assigned_to === $user->id;
        }

        // Users cannot update leads
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lead $lead): bool
    {
        // Only admins can delete leads
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lead $lead): bool
    {
        // Only admins can restore leads
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lead $lead): bool
    {
        // Only admins can force delete leads
        return $user->isAdmin();
    }
}
