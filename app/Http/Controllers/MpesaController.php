<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\View\View;
use App\Models\Donation;

class MpesaController extends Controller
{
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
        
        $mpesa = 

        $callback_url = route("mpesa_callback");
        $account_reference = "donation";
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
            return view("pages.mpesa-response", []);
        }

        // Error occurred while submitting STK push
        catch(\Exception $e){
            session()->flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        } 
    }

    /**
     * Handle MPESA callback
     */
    public function mpesa_callback(Request $request, Response $response){

    }
}
