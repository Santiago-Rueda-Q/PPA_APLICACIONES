<?php

namespace App\Policies;

use App\Models\Incidente;
use App\Models\User;

class IncidentePolicy
{
    /**
     * Determine if the user can view any incidents.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('incidentes.view_all') ||
               $user->can('incidentes.view_assigned') ||
               $user->can('incidentes.view_area') ||
               $user->can('incidentes.view_own');
    }

    /**
     * Determine if the user can view the incident.
     */
    public function view(User $user, Incidente $incidente): bool
    {
        // SuperAdmin y Admin pueden ver todos
        if ($user->can('incidentes.view_all')) {
            return true;
        }

        // Operativo ve los asignados a él
        if ($user->can('incidentes.view_assigned')) {
            return $incidente->asignado_a === $user->id;
        }

        // Director ve los de su área
        if ($user->can('incidentes.view_area')) {
            return $incidente->solicitante_id === $user->id ||
                   $incidente->solicitante->area === $user->area;
        }

        // Docente ve solo los suyos
        if ($user->can('incidentes.view_own')) {
            return $incidente->solicitante_id === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can create incidents.
     */
    public function create(User $user): bool
    {
        return $user->can('incidentes.create');
    }

    /**
     * Determine if the user can update the incident.
     */
    public function update(User $user, Incidente $incidente): bool
    {
        // Admin puede editar todos
        if ($user->can('incidentes.edit_all')) {
            return true;
        }

        // Operativo puede editar los asignados
        if ($user->can('incidentes.edit_assigned')) {
            return $incidente->asignado_a === $user->id;
        }

        // Docente/Director puede editar los propios si están pendientes
        if ($user->can('incidentes.edit_own')) {
            return $incidente->solicitante_id === $user->id &&
                   $incidente->estado === 'pendiente';
        }

        return false;
    }

    /**
     * Determine if the user can delete the incident.
     */
    public function delete(User $user, Incidente $incidente): bool
    {
        return $user->can('incidentes.delete_all');
    }

    /**
     * Determine if the user can assign incidents.
     */
    public function assign(User $user, Incidente $incidente): bool
    {
        return $user->can('incidentes.assign');
    }

    /**
     * Determine if the user can change incident status.
     */
    public function changeStatus(User $user, Incidente $incidente): bool
    {
        // Admin puede cambiar cualquier estado
        if ($user->can('incidentes.change_status')) {
            return true;
        }

        // Operativo puede actualizar estado de los asignados
        if ($user->can('incidentes.update_status')) {
            return $incidente->asignado_a === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can add comments.
     */
    public function addComment(User $user, Incidente $incidente): bool
    {
        if (!$user->can('incidentes.add_comments')) {
            return false;
        }

        // Puede comentar si puede ver el incidente
        return $this->view($user, $incidente);
    }

    /**
     * Determine if the user can cancel their own incident.
     */
    public function cancel(User $user, Incidente $incidente): bool
    {
        if (!$user->can('incidentes.cancel_own')) {
            return false;
        }

        return $incidente->solicitante_id === $user->id &&
               in_array($incidente->estado, ['pendiente', 'asignado']);
    }
}
