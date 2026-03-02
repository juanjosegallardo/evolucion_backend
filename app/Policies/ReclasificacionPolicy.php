<?php

namespace App\Policies;

use App\Models\Reclasificacion;
use App\Models\User;
use App\Models\Almacen;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;


class ReclasificacionPolicy
{

    public function validar(User $user, Reclasificacion $reclasificacion)
    {
        return $user->esAdmin()? Response::allow()
        : Response::deny('Solo el administrador puede validar la reclasificación');
    }

    public function cancelar(User $user, Reclasificacion $reclasificacion)
    {
        return $user->esAdmin()? Response::allow()
        : Response::deny('Solo el administrador puede cancelar la reclasificación');
    }
   

    public function rechazar(User $user, Reclasificacion $reclasificacion)
    {
        return $user->esAdmin()? Response::allow()
        : Response::deny('Solo el administrador puede rechazar la reclasificación');
    }
  


    public function solicitar(User $user, Reclasificacion $reclasificacion)
    {   
        if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($reclasificacion->almacen->user_responsable_id === $user->id) {
            return Response::allow();
        }
        return Response::deny('Solo el administrador o el responsable puede solicitar la reclasificación');
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Reclasificacion $reclasificacion): bool
    {
        //
    }

    public function create(User $user,$request)
    {
         if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($user->almacenes->pluck("id")->contains($request->almacen_id)) {
            return Response::allow();
        }


        return Response::deny('Solo el administrador o el responsable puede capturar la carga');   
    }

    public function update(User $user, Reclasificacion $reclasificacion): bool
    {
     
        
    }

    public function delete(User $user, Reclasificacion $reclasificacion)
    {
        if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($user->almacenes->pluck("id")->contains($reclasificacion->almacen_id)) {
            return Response::allow();
        }

        return Response::deny('Solo el administrador o el responsable puede eliminar la carga');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reclasificacion $reclasificacion): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reclasificacion $reclasificacion): bool
    {
        //
    }
}
