<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venta;
use Illuminate\Auth\Access\Response;

class VentaPolicy
{

    public function validar(User $user, Venta $venta)
    {
        return $user->esAdmin()? Response::allow()
        : Response::deny('Solo el administrador puede validar la venta');
    }

    public function rechazar(User $user, Venta $venta)
    {
        return $user->esAdmin()? Response::allow()
        : Response::deny('Solo el administrador puede rechazar la venta');
    }


    public function solicitar(User $user, Venta $venta)
    {   
        if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($carga->almacen->user_responsable_id === $user->id) {
            return Response::allow();
        }
        return Response::deny('Solo el administrador o el responsable puede rechazar la venta');
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Venta $venta): bool
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

        return Response::deny('Solo el administrador o el responsable puede capturar la venta');   
    }

    public function update(User $user, Venta $venta): bool
    {
     
        
    }

    public function delete(User $user, Venta $venta): bool
    {
        if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($venta->user_vendedor_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Solo el administrador o el responsable puede eliminar la venta');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Venta $venta): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Venta $venta): bool
    {
        //
    }
}
