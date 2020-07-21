<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
/* fbsg-signature-addPassportConfig:<begin> */
use Laravel\Passport\HasApiTokens;
/* fbsg-signature-addPassportConfig:<end> */
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /* fbsg-signature-addPassportConfig:<begin> */
    use HasApiTokens;
    /* fbsg-signature-addPassportConfig:<end> */
    use Notifiable;

	/* fbsg-signature-createSocialite:<begin> UserLinkedAccount */
	public function LinkedSocialAccount(){
	    return $this->hasMany('App\LinkedSocialAccount');
	}
	/* fbsg-signature-createSocialite:<end> UserLinkedAccount */
    public function task() {
       return $this->hasMany('App\task', 'user_id');
    }
   /* fbsg-signature-addUserisPrivilegedFunc:<begin> */
    public function isPrivilegedUser() {
        return $this->hasAnyRole(['admin',]);
    }
   /* fbsg-signature-addUserisPrivilegedFunc:<end> */
	/* fbsg-signature-addUserhasRoleFunc:<begin> */
    public function hasAnyRole($roles) {
        if(is_array($roles)) {
            foreach($roles as $role) {
                if($this->Role()->where('name',$role)->first()) {
                    return true;
                }
            }
        } else {
            if($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }
	/* fbsg-signature-addUserhasRoleFunc:<end> */
    /* fbsg-signature-addUserRoleLinkRef:<begin> */
    public function Role() {
        return $this->belongsToMany(Role::class,'role_users');
    }
    /* fbsg-signature-addUserRoleLinkRef:<end> */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
