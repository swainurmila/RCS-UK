<?php

namespace App\Policies;

use App\Models\Complaint;
use App\Models\User;

class ComplaintApplicationPolicy
{
    /**
     * Determine if the user can view the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Complaint  $app
     * @return bool
     */
    public function view(User $user, Complaint $app)
    {
        return true;
        if (in_array($user->getRoleNames()->first(), ['superadmin', 'admin', 'register', 'society'])) {
            return true;
        }
        return $app->current_role === $user->role ||
            $app->submitted_to_user_id === $user->id ||
            $app->flows()->where(function ($q) use ($user) {
                $q->where('from_role', $user->role)->orWhere('to_role', $user->role);
            })->exists();
    }

    /**
     * Determine if the user can take action on the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Complaint  $app
     * @return bool
     */
    public function act(User $user, Complaint $app)
    {
        $userRole = strtolower($user->getRoleNames()->first()); // normalize to lowercase
        $appRole = strtolower($app->current_role);
        // if ($appRole == 'society') {
        //     return false;
        // }
        if (in_array($app->status, [2, 5])) {
            return false; // If the application is in final approval, no one can take action
        }
        if ($app->status == 1 && $appRole === 'arcs') {
            return $userRole === 'arcs' &&
                ($app->submitted_to_user_id === null || $app->submitted_to_user_id === $user->id);
        }

        return $appRole === $userRole &&
            ($app->submitted_to_user_id === null || $app->submitted_to_user_id === $user->id);
    }
}