<?php

namespace App\Policies;

use App\Models\Traspaso;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TraspasoPolicy
{
    public function validar(User $user, Traspaso $traspaso)
    {
        return $user->esAdmin()? Response::allow()
        : Response::deny('Solo el administrador puede validar el traspaso');
    }

    public function rechazar(User $user, Traspaso $traspaso)
    {
        return $user->esAdmin()? Response::allow()
        : Response::deny('Solo el administrador puede rechazar el traspaso');
    }


    public function solicitar(User $user, Traspaso $traspaso)
    {   
        if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($carga->almacenDestino->user_responsable_id === $user->id) {
            return Response::allow();
        }
        return Response::deny('Solo el administrador o el responsable puede solicitar el traspaso');
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Traspaso $traspaso): bool
    {
        //
    }

    public function create(User $user): bool
    {
         if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($carga->almacenDestino->user_responsable_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Solo el administrador o el responsable puede capturar el traspaso');   
    }

    public function update(User $user, Traspaso $traspaso): bool
    {
     
        
    }

    public function delete(User $user, Traspaso $traspaso): bool
    {
        if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($carga->almacenDestino->user_responsable_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Solo el administrador o el responsable puede eliminar el traspaso');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Traspaso $traspasoa): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Traspaso $traspaso): bool
    {
        //
    }

}
