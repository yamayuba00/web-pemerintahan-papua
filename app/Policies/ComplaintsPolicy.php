<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Complaints;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComplaintsPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Complaints');
    }

    public function view(AuthUser $authUser, Complaints $complaints): bool
    {
        return $authUser->can('View:Complaints');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Complaints');
    }

    public function update(AuthUser $authUser, Complaints $complaints): bool
    {
        return $authUser->can('Update:Complaints');
    }

    public function delete(AuthUser $authUser, Complaints $complaints): bool
    {
        return $authUser->can('Delete:Complaints');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Complaints');
    }

    public function restore(AuthUser $authUser, Complaints $complaints): bool
    {
        return $authUser->can('Restore:Complaints');
    }

    public function forceDelete(AuthUser $authUser, Complaints $complaints): bool
    {
        return $authUser->can('ForceDelete:Complaints');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Complaints');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Complaints');
    }

    public function replicate(AuthUser $authUser, Complaints $complaints): bool
    {
        return $authUser->can('Replicate:Complaints');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Complaints');
    }

}