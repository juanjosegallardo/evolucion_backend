<?php

namespace App\Policies;

use App\Models\Carga;
use App\Models\User;
use App\Models\Almacen;
use Illuminate\Auth\Access\Response;


class CargaPolicy
{

    public function validar(User $user, Carga $carga)
    {
        return $user->esAdmin()? Response::allow()
        : Response::deny('Solo el administrador puede validar la carga');
    }

    public function cancelar(User $user, Carga $carga)
    {
        return $user->esAdmin()? Response::allow()
        : Response::deny('Solo el administrador puede cancelar la carga');
    }

    public function rechazar(User $user, Carga $carga)
    {
        return $user->esAdmin()? Response::allow()
        : Response::deny('Solo el administrador puede rechazar la carga');
    }


    public function solicitar(User $user, Carga $carga)
    {   
        if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($carga->almacen->user_responsable_id === $user->id) {
            return Response::allow();
        }
        return Response::deny('Solo el administrador o el responsable puede rechazar la carga');
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Carga $carga): bool
    {
        //
    }

    public function create(User $user): bool
    {
         if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($carga->almacen->user_responsable_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Solo el administrador o el responsable puede capturar la carga');   
    }

    public function update(User $user, Carga $carga): bool
    {
     
        
    }

    public function delete(User $user, Carga $carga): bool
    {
        if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($carga->almacen->user_responsable_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Solo el administrador o el responsable puede eliminar la carga');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Carga $carga): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Carga $carga): bool
    {
        //
    }
}
