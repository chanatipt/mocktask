<?php

namespace App\Policies;

use App\User;
use App\task;
use Illuminate\Auth\Access\HandlesAuthorization;

class taskPolicy
{
    use HandlesAuthorization;

    /* fbsg-signature-writeHasRoleFunc:<begin> indextask,task */
    public function indextask(User $User)
    {
        return true;
    }
    /* fbsg-signature-writeHasRoleFunc:<end> indextask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> addtask,task */
    public function addtask(User $User)
    {
        return $User->hasAnyRole(['owner','staff','admin',]);
    }
    /* fbsg-signature-writeHasRoleFunc:<end> addtask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> viewdrafttask,task */
    public function viewdrafttask(User $User,task $task)
    {
        return $User->hasAnyRole(['owner','staff','admin',]) &&
               $task->taskStatus->name == 'draft';
    }
    /* fbsg-signature-writeHasRoleFunc:<end> viewdrafttask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> viewactivetask,task */
    public function viewactivetask(User $User,task $task)
    {
        return $User->hasAnyRole(['owner','staff','admin',]) &&
               $task->taskStatus->name == 'active';
    }
    /* fbsg-signature-writeHasRoleFunc:<end> viewactivetask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> viewinactivetask,task */
    public function viewinactivetask(User $User,task $task)
    {
        return $User->hasAnyRole(['owner','staff','admin',]) &&
               $task->taskStatus->name == 'inactive';
    }
    /* fbsg-signature-writeHasRoleFunc:<end> viewinactivetask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> updatedrafttask,task */
    public function updatedrafttask(User $User,task $task)
    {
        return $User->hasAnyRole(['owner','staff','admin',]) &&
               $task->taskStatus->name == 'draft';
    }
    /* fbsg-signature-writeHasRoleFunc:<end> updatedrafttask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> updateactivetask,task */
    public function updateactivetask(User $User,task $task)
    {
        return $User->hasAnyRole(['owner','staff','admin',]) &&
               $task->taskStatus->name == 'active';
    }
    /* fbsg-signature-writeHasRoleFunc:<end> updateactivetask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> deletedrafttask,task */
    public function deletedrafttask(User $User,task $task)
    {
        return $User->hasAnyRole(['admin',]) &&
               $task->taskStatus->name == 'draft';
    }
    /* fbsg-signature-writeHasRoleFunc:<end> deletedrafttask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> deleteactivetask,task */
    public function deleteactivetask(User $User,task $task)
    {
        return $User->hasAnyRole(['admin',]) &&
               $task->taskStatus->name == 'active';
    }
    /* fbsg-signature-writeHasRoleFunc:<end> deleteactivetask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> deleteinactivetask,task */
    public function deleteinactivetask(User $User,task $task)
    {
        return $User->hasAnyRole(['owner','staff','admin',]) &&
               $task->taskStatus->name == 'inactive';
    }
    /* fbsg-signature-writeHasRoleFunc:<end> deleteinactivetask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> canceldrafttask,task */
    public function canceldrafttask(User $User,task $task)
    {
        return $User->hasAnyRole(['owner','staff','admin',]) &&
               $task->taskStatus->name == 'draft';
    }
    /* fbsg-signature-writeHasRoleFunc:<end> canceldrafttask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> cancelactivetask,task */
    public function cancelactivetask(User $User,task $task)
    {
        return $User->hasAnyRole(['owner','staff','admin',]) &&
               $task->taskStatus->name == 'active';
    }
    /* fbsg-signature-writeHasRoleFunc:<end> cancelactivetask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> uncancelinactivetask,task */
    public function uncancelinactivetask(User $User,task $task)
    {
        return $User->hasAnyRole(['owner','staff','admin',]) &&
               $task->taskStatus->name == 'inactive';
    }
    /* fbsg-signature-writeHasRoleFunc:<end> uncancelinactivetask,task */

    /* fbsg-signature-writeHasRoleFunc:<begin> activateapprovetaskdrafttask,task */
    public function activateapprovetaskdrafttask(User $User,task $task)
    {
        return $User->hasAnyRole(['owner','staff','admin',]) &&
               $task->taskStatus->name == 'draft';
    }
    /* fbsg-signature-writeHasRoleFunc:<end> activateapprovetaskdrafttask,task */

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\task  $task
     * @return mixed
     */
    public function view(User $user, task $task)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\task  $task
     * @return mixed
     */
    public function update(User $user, task $task)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\task  $task
     * @return mixed
     */
    public function delete(User $user, task $task)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\task  $task
     * @return mixed
     */
    public function restore(User $user, task $task)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\task  $task
     * @return mixed
     */
    public function forceDelete(User $user, task $task)
    {
        //
    }
}
