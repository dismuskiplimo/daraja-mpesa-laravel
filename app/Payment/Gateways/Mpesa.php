<?php 
    namespace App\Payment\Gateways;

    class Mpesa{
        // MPESA Constants

        // MPESA Response Errors
        protected const TRANSACTION_ERRORS = [
            '0' => 'Success',
            '1' => 'Insufficient Funds',
            '2' => 'Less Than Minimum Transaction Value',
            '3' => 'More Than Maximum Transaction Value',
            '4' => 'Would Exceed Daily Transfer Limit',
            '5' => 'Would Exceed Minimum Balance',
            '6' => 'Unresolved Primary Party',
            '7' => 'Unresolved Receiver Party',
            '8' => 'Would Exceed Maxiumum Balance',
            '11' => 'Debit Account Invalid',
            '12' => 'Credit Account Invalid',
            '13' => 'Unresolved Debit Account',
            '14' => 'Unresolved Credit Account',
            '15' => 'Duplicate Detected',
            '17' => 'Internal Failure',
            '20' => 'Unresolved Initiator',
            '26' => 'Traffic blocking condition in place',
            '1032' => 'Request cancelled by user'
        ];
    
        // MPESA HTTP Errors
        protected const HTTP_ERRORS = [
            '400' => 'Bad Request',
            '401' => 'Unauthorized',
            '403' => 'Forbidden',
            '404' => 'Not Found',
            '405' => 'Method Not Allowed',
            '406' => 'Not Acceptable - You requested a format that isn\'t json',
            '429' => 'Too Many Requests - You\'re requesting too many kittens! Slow down!',
            '500' => 'Internal Server Error - We had a problem with our server. Try again later.',
            '503' => 'Service Unavailable - We\'re temporarily offline for maintenance. Please try again later.',
            
        ];
        
        // MPESA URLs
        // LIVE
        protected const SANDBOX_AUTHORIZATION_URL = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        protected const SANDBOX_REQUEST_URL = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        protected const SANDBOX_QUERY_URL = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

        // SANDBOX
        protected const LIVE_AUTHORIZATION_URL = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        protected const LIVE_REQUEST_URL = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        protected const LIVE_QUERY_URL = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        
        // MPESA Credentials
        protected $shortcode;
        protected $consumer_key;
        protected $consumer_secret;
        protected $passkey;

        // MPESA URLs
        protected $authorization_url;
        protected $request_url;
        protected $query_url;

        // MPESA transaction type
        protected $transaction_type;

        /**
         * Constructor
         * 
         * param 1. shortcode - Business Shortcode (paybill or till number)
         * param 2. consumer_key - API consumer key
         * param 3. consumer_secret - API consumer secret
         * Param 4. passkey - API passkey (optional)
         * param 5. transaction_type - Transaction type. One of two values ('paybill' or 'till')
         * param 6. environment - MPESA environment. One of two values ('live' or 'sandbox')
         */
        public function __construct($shortcode, $consumer_key, $consumer_secret, $passkey = '', $transaction_type = 'paybill',  $environment = "live"){
            // initialize the values
            $this->shortcode = $shortcode;
            $this->consumer_key = $consumer_key;
            $this->consumer_secret = $consumer_secret;
            $this->passkey = $passkey;
            
            // set the transaction type
            $this->set_transaction_type($transaction_type);

            // set API urls based on environment
            $this->set_api_urls($environment);
        }

        /**
         * Generates Access Token
         */
        protected function generate_access_token(){
            $curl = curl_init();

            // set the URL
            curl_setopt($curl, CURLOPT_URL, $this->authorization_url);
            
            // enable headers
            curl_setopt($curl, CURLOPT_HEADER, true);

            // set the headers
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Authorization: Basic ' . base64_encode($this->consumer_key . ':' . $this->consumer_secret),
            ]);
            
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            // return value instead of echoing out to screen
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            // execute the curl request
            $response = curl_exec($curl);
            
            // close the curl request
            curl_close($curl);

            // split header and body
            list($header, $body) = explode("\r\n\r\n", $response, 2);

            // decode the body
            $body = json_decode($body);

            // Throw exception if body is empty
            if(is_null($body)){
                throw new \Exception("MPESA Error. Please Contact Admin");
            }
            
            // return the access token
            return $body->access_token;
        }

        /**
         * Performs STK push on customers Phone
         * 
         * Param 1. phone - Phone number to receive STK Push
         * Param 2. amount - The amount to request (only whole numbers)
         * Param 3. callback_url - The URL to be pinged once the transaction is complete
         * Param 4. account_reference - The account reference (between 1 and 12 characters)
         * Param 5. transaction_description - Description that wil be sent to the customer (between 1 and 13 characters)
         */
        public function request_stk_push($phone, $amount, $callback_url, $account_reference, $transaction_description){
            // Generate the access token
            $access_token = $this->generate_access_token();

            // Generate password according to Daraja Specifications (base64.encode(Shortcode+Passkey+Timestamp))
            $password = base64_encode($this->shortcode . $this->passkey . $this->generate_timestamp());
            
            return "";
        }


        // UTILITY METHODS
        
        /**
         * Generates and returns a timestamp in the format YYYYMMDDHHmmss
         * 
         * RETURN formatted timestamp as string
         */
        protected function generate_timestamp(){
            return (new \DateTime())->format("YmdHis");
        }

        /**
         * Updates the urls based on the environment
         */

         protected function set_api_urls($envionment){
            if($envionment == 'live'){
                $this->authorization_url = $this::LIVE_AUTHORIZATION_URL;
                $this->request_url = $this::LIVE_REQUEST_URL;
                $this->query_url = $this::LIVE_QUERY_URL;
            }

            else{
                $this->authorization_url = $this::SANDBOX_AUTHORIZATION_URL;
                $this->request_url = $this::SANDBOX_REQUEST_URL;
                $this->query_url = $this::SANDBOX_QUERY_URL;
            }
         }

         /**
          * Set the transaction type based on constructor parameter
          */

         protected function set_transaction_type($transaction_type){
            if($transaction_type == 'paybill'){
                $this->transaction_type = 'CustomerPayBillOnline';
            }

            else{
                $this->transaction_type = 'CustomerBuyGoodsOnline';
            }
         }


    }