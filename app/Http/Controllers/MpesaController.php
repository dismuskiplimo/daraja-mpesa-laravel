<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\View\View;
use App\Models\{Donation, MpesaErrorLog, MpesaCallbackLog};

use App\Payment\Gateways\Mpesa;


class MpesaController extends Controller
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
    
    /**
     * Index Page to get donor details
     */
    public function index(Request $request, Response $response): View{
        return view("pages.index", []);
    }


    /**
     * Initiate STK Push
     */
    public function request_stk_push(Request $request, Response $response){
        // validate parameters
        $request->validate([
            "donor_name"=> "string|required",
            "phone"=> "numeric|required",
            "amount"=> "numeric|required|min:1",
            "donation_type"=> "string|required",
            "donor_note"=> "string|required",
        ]);

        $callback_url = route("mpesa_callback");
        $account_reference = "DONATION";
        $transaction_description = "Donation ACC";

        // attempt STK push
        try{
            $result = $this->mpesa->request_stk_push($request->phone, $request->amount, $callback_url, $account_reference, $transaction_description);
            
            // get the MerchantRequestID and CheckoutRequestID
            $merchant_request_id = $result->MerchantRequestID;
            $checkout_request_id = $result->CheckoutRequestID;

            // save the transaction to database
            $donation = new Donation();

            $donation->donor_name = $request->donor_name;
            $donation->phone = $this->mpesa::format_phone_number($request->phone);
            $donation->donation_type = $request->donation_type;
            $donation->amount = ceil($request->amount);
            $donation->donor_note = $request->donor_note;
            $donation->merchant_request_id = $merchant_request_id;
            $donation->checkout_request_id = $checkout_request_id;

            // Save to daabase
            $donation->save();

            // Save flash message to session
            session()->flash('success', "STK Push sent to phone. Please Input MPESA PIN and click OK");
            
            // redirect to the thank you page
            return redirect()->route("thank_you");
        }

        // Error occurred while submitting STK push
        catch(\Exception $e){
            // Create MPESA Error Log
            $log = new MpesaErrorLog();
            $log->body = $e;
            $log->save();

            session()->flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        } 
    }

    /**
     * Handle MPESA callback
     */
    public function mpesa_callback(Request $request, Response $response){
        // attempt to parse the equest
        try{
            // parse body
            $body = $this->mpesa->process_callback($request);
            
            // Create MPESA Log
            $log = new MpesaCallbackLog();
            $log->body = json_encode($body);
            $log->save();

            // query the stk response
            $checkout_request_id = $body->Body->stkCallback->CheckoutRequestID;
            
            // ensures that the transaction completed
            $this->mpesa->query_stk_push($checkout_request_id);

            // transaction details
            $amount = $body->Body->stkCallback->CallbackMetadata->Item[0]->Value;
            $mpesa_receipt_number = $body->Body->stkCallback->CallbackMetadata->Item[1]->Value;
            $transaction_date = $body->Body->stkCallback->CallbackMetadata->Item[2]->Value;
            $phone = $body->Body->stkCallback->CallbackMetadata->Item[3]->Value;

            // update the donation details
            $donation = Donation::where("checkout_request_id", $checkout_request_id)->first();
            $donation->amount = $amount;
            $donation->mpesa_receipt_number = $mpesa_receipt_number;
            $donation->transaction_date = $transaction_date;
            $donation->phone = $phone;
            $donation->fulfilled = '1';
            $donation->update();

            // Send Email

        }
        
        catch(\Exception $e){
            // Create MPESA Error Log
            $log = new MpesaErrorLog();
            $log->body = $e;
            $log->save();
        }
    }
}
