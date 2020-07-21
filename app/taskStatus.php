<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class taskStatus extends Model
{
    /* fbsg-signature-addTableNames:<begin> taskStatus */
    protected $table = 'task_statuses';
    /* fbsg-signature-addTableNames:<end> taskStatus */
    //
    public function task() {
       return $this->hasMany('App\task', 'status_id');
    }
}
