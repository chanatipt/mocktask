<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    //
    /* fbsg-signature-addDataLogger:<begin> createLogActivityModel */
    protected $table = 'log_activity';
    protected $fillable = [
        'subject', 'url', 'method', 'ip', 'agent', 'user_id'
    ];
    /* fbsg-signature-addDataLogger:<end> createLogActivityModel */
}
