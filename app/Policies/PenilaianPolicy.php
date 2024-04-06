<?php

namespace App\Policies;

use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenilaianPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function update(User $user, Penilaian $penilaian){
        $laporan = $penilaian->laporan->user_id;

        return $user->id === $laporan || $user->role === 'admin';
    }

    public function update_rekomendasi(User $user, Penilaian $penilaian)
    {
        return $user->role === 'admin';
    }
}
