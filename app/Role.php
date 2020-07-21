<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /* fbsg-signature-addTableNames:<begin> Role */
    protected $table = 'roles';
    /* fbsg-signature-addTableNames:<end> Role */
    //
    /* fbsg-signature-addUserRoleLinkRef:<begin> */
    public function User() {
        return $this->belongsToMany(User::class,'role_users');
    }
    /* fbsg-signature-addUserRoleLinkRef:<end> */
}
