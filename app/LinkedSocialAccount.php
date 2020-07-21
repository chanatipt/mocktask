<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkedSocialAccount extends Model
{
    //
	/* fbsg-signature-createSocialite:<begin> LinkedSocialAccounts */
	protected $fillable = ['provider_name', 'provider_id' ];
	public function user(){
           return $this->belongsTo('App\User');
	}
	/* fbsg-signature-createSocialite:<end> LinkedSocialAccounts */
}
