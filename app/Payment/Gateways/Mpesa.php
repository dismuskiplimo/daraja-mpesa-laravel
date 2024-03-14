<?php 
    namespace App\Payment\Gateways;

    class Mpesa{
        // MPESA URLs
        private $authorization_url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        
        // MPESA Credentials
        private $shortcode;
        private $consumer_key;
        private $consumer_secret;

        // MPESA environment
        private $envionment;

        // constructor
        public function __construct($shortcode, $consumer_key, $consumer_secret, $envionment = "live"){
            $this->shortcode = $shortcode;
            $this->consumer_key = $consumer_key;
            $this->consumer_secret = $consumer_secret;
            $this->envionment = $envionment;
        }

        // generate access token
        public function generate_access_token(){
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Authorization: Basic ' . base64_encode('YOUR_APP_CONSUMER_KEY:YOUR_APP_CONSUMER_SECRET')
            ]);
            
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($curl);
            
            echo json_decode($response);
        }

        
    }