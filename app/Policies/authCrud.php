<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class authCrud
{

    //create const admin and user 
    const USER = 1;
    const ADMIN = 2;
    const WRITTER = 3;   

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->rol_id === self::ADMIN ? Response::allow() : Response::deny('No tienes permiso para crear.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): Response
    {
        // Roles que pueden actualizar
        $allowedRoles = [self::ADMIN, self::WRITTER];    
    
        if (in_array($user->rol_id, $allowedRoles)) {
            return Response::allow();
        } else {
            return Response::deny('No tienes permiso para actualizar.');
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): Response
    {
        //Roles que pueden eliminar
        $allowedRoles = [self::WRITTER, self::ADMIN];
        if(in_array($user->rol_id, $allowedRoles)){
            return Response::allow();
        }else{
            return Response::deny('No tienes permiso para eliminar.');
        }

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): Response
    {
        $allowedRoles = [self::ADMIN, self::WRITTER];
        if(in_array($user->rol_id, $allowedRoles)){
            return Response::allow();
        }else{
            return Response::deny('No tienes permiso para restaurar.');
        }
    }
    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): Response
    {
        $allowedRoles = [self::ADMIN];
        if(in_array($user->rol_id, $allowedRoles)){
            return Response::allow();
        }else{
            return Response::deny('No tienes permiso para eliminar permanentemente.');
        }
    }

    
    /**
     * Determine whether the user can view trashed.
     */
    public function viewTrashed(User $user): Response
    {
        $allowedRoles = [self::WRITTER, self::ADMIN];
        if(in_array($user->rol_id, $allowedRoles)){
            return Response::allow();
        }else{
            return Response::deny('No tienes permiso para ver los eliminados.');
        }
    }

}
