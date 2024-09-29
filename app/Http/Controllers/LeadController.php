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
            $days_ago = Carbon::parse($lead->discovered_on)->diffForHumans();
            $lead->days_ago = $days_ago;
        }
        $successMessage = session()->get('successMessage');
        return view('leads.show', compact('user_leads', 'successMessage'));
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'discovered_on' => 'required|date',
            'via' => 'required|string|max:255',
            'link' => 'nullable|url',
            'comments' => 'nullable',
            'quality' => 'required|integer|between:0,10',
        ],[
            'user_id.required' => 'Something went wrong, please try again later!',
            'company_name.required' => 'Please enter a company name!',
            'company_name.max' => 'Please enter a valid company name!',
            'location.required' => 'Please enter a location!',
            'location.max' => 'Please enter a valid location!',
            'sector.required' => 'Please enter a sector!',
            'sector.max' => 'Please enter a valid sector!',
            'discovered_on.required' => 'Please enter a date of discovery!',
            'date' => 'Please enter a valid date format (YYYY-MMM-DD)!',
            'via.required' => 'Please enter a how you discovered the company (via)!',
            'via.max' => 'Please enter a valid via!',
            'quality.required' => 'Please enter a quality rating!',
            'quality.integer' => 'Please enter a valid quality rating!',
            'quality.between' => 'Please enter a quality rating between 0 and 10!',
        ]);
        Lead::create($validatedData);
        $successMessage = 'Lead created successfully!';
        return redirect()->route('leads.show')->with([ 'successMessage' => $successMessage ]);
    }
}
