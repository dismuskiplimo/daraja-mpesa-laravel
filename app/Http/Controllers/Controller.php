<?php

namespace App\Http\Controllers;

use App\Payment\Gateways\Mpesa;

abstract class Controller
{
    protected $mpesa;

    public function __construct(){
        $this->mpesa = new Mpesa(
            env("MPESA_SHORTCODE"), 
            env("MPESA_CONSUMER_KEY"), 
            env("MPESA_CONSUMER_SECRET"),
            env("MPESA_PASSKEY"),
            env("MPESA_TRANSACTION_TYPE"),
            env("MPESA_ENVIRONMENT")
        );
    }
}
