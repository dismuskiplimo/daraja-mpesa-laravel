<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

class DonationController extends Controller
{
    /**
     * Return all the donations
     */

     public function index(Request $request){
        $donations = Donation::orderBy("created_at", 'DESC')->paginate(50);

        return view("pages.donations", [
            "donations" => $donations,
        ]);
     }
}
