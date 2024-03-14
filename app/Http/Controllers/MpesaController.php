<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\View\View;

use App\Payment\Gateways\Mpesa;

class MpesaController extends Controller
{
    /**
     * Index Function
     */
    public function index(Request $request, Response $response): View{
        return view("pages.index", []);
    }


    public function request_stk_push(Request $request, Response $response){
        $error = false;
        
        // validate parameters
        $request->validate([
            "phone"=> "numeric|required",
            "amount"=> "numeric|required|min:1",
        ]);
        
        $mpesa = new Mpesa(
            env("MPESA_SHORTCODE"), 
            env("MPESA_CONSUMER_KEY"), 
            env("MPESA_CONSUMER_SECRET"),
            env("MPESA_PASSKEY"),
            env("MPESA_TRANSACTION_TYPE"),
            env("MPESA_ENVIRONMENT")
        );

        $callback_url = route("mpesa_callback");
        $account_reference = "donation";
        $transaction_description = "Donation ACC";

        // attempt stk push
        try{
            $result = $mpesa->request_stk_push($request->phone, $request->amount, $callback_url, $account_reference, $transaction_description);
            
            // get the MerchantRequestID and CheckoutRequestID

            session()->flash('success', "Success");
        }

        // Error occurred while submitting STK push
        catch(\Exception $e){
            echo $e->getMessage();
            session()->flash('error', "Error: " . $e->getMessage());
            
            //return redirect()->back()->withInput(request()->all());
        }
        

        // return view("pages.mpesa-response", []);
    }
}
