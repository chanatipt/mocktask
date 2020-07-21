<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    /* fbsg-signature-addTableNames:<begin> task */
    protected $table = 'tasks';
    /* fbsg-signature-addTableNames:<end> task */
    //
	/* fbsg-signature-addHasActiveLinkedModels:<begin> task */
    // check if any active linked model still exists.
    public function hasActiveLinkedModels()
    {
        return false;
    }
	/* fbsg-signature-addHasActiveLinkedModels:<end> task */
    public function User() {
       return $this->belongsTo('App\User', 'user_id');
    }
    public function taskStatus() {
       return $this->belongsTo('App\taskStatus', 'status_id');
    }
}
