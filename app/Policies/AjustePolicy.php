<?php

namespace App\Policies;

use App\Models\Ajuste;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AjustePolicy
{

    public function validar(User $user, Ajuste $ajuste)
    {
        return $user->esAdmin()
            ? Response::allow()
            : Response::deny('Solo el administrador puede validar el ajuste');
    }

    public function cancelar(User $user, Ajuste $ajuste)
    {
        return $user->esAdmin()
            ? Response::allow()
            : Response::deny('Solo el administrador puede cancelar el ajuste');
    }

    public function rechazar(User $user, Ajuste $ajuste)
    {
        return $user->esAdmin()
            ? Response::allow()
            : Response::deny('Solo el administrador puede rechazar el ajuste');
    }

    public function solicitar(User $user, Ajuste $ajuste)
    {
        if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($ajuste->almacen->user_responsable_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Solo el administrador o el responsable puede solicitar la validación del ajuste');
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Ajuste $ajuste): bool
    {
        return true;
    }

    public function create(User $user, $request)
    {
        if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($user->almacenes->pluck("id")->contains($request->almacen_id)) {
            return Response::allow();
        }

        return Response::deny('Solo el administrador o el responsable puede capturar el ajuste');
    }

    public function update(User $user, Ajuste $ajuste): bool
    {
        return false;
    }

    public function delete(User $user, Ajuste $ajuste)
    {
        if ($user->esAdmin()) {
            return Response::allow();
        }

        if ($user->almacenes->pluck("id")->contains($ajuste->almacen_id)) {
            return Response::allow();
        }

        return Response::deny('Solo el administrador o el responsable puede eliminar el ajuste');
    }

    public function restore(User $user, Ajuste $ajuste): bool
    {
        return false;
    }

    public function forceDelete(User $user, Ajuste $ajuste): bool
    {
        return false;
    }
}