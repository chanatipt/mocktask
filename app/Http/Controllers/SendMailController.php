<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendMailController extends Controller
{
    //
    /* fbsg-signature-setMailQueue:<begin> SendMailController */
    public function sendEmail()
    {
       $emailJob = (new SendEmailJob())->delay(Carbon::now()->addSeconds(3));
       dispatch($emailJob);
    }
    /* fbsg-signature-setMailQueue:<end> SendMailController */
}
