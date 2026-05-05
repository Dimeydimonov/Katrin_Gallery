<?php

namespace App\Policies;

use App\Models\Artwork;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

// скопировано с ларавел
class ArtworkPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Artwork $artwork): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function update(User $user, Artwork $artwork): bool
    {
        return $user->id === $artwork->user_id || $user->isAdmin();
    }

    public function delete(User $user, Artwork $artwork): bool
    {
        return $user->id === $artwork->user_id || $user->isAdmin();
    }

    public function restore(User $user, Artwork $artwork): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Artwork $artwork): bool
    {
        return $user->isAdmin();
    }
}
