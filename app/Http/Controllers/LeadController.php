<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Lead;
use Illuminate\Support\Carbon;

class LeadController extends Controller
{
    public function show(){
        $userId = Auth::id();
        $user_leads = Lead::where('user_id', $userId)->get();
        foreach($user_leads as $lead){
            //relative date handling (X days ago)
            $days_ago = Carbon::parse($lead->last_contact)->diffForHumans();
            $lead->days_ago = $days_ago;
        }
        $successMessage = session()->get('successMessage');
        return view('leads.show', compact('user_leads', 'successMessage'));
    }

    public function create(Request $request){
        dd($request->all());
    }
}
