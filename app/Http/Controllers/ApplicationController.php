<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Application;
use Illuminate\Support\Carbon;

class ApplicationController extends Controller
{
    public function show()
    {
        $userId = Auth::id();
        $user_applications = Application::where('user_id', $userId)->get();
        foreach($user_applications as $application){
            // relative date handling (X days ago)
            $days_ago = Carbon::parse($application->last_contact)->diffForHumans();
            $application->days_ago = $days_ago;
            //yes or no interview icon 
            $application->interview ? $application->interviewSource = 'images/interview.svg' : $application->interviewSource = 'images/nointerview.svg';
        }
        
        return view('applications.show', compact('user_applications'));
    }
    
    public function create(Request $request){
        //dd($request->all());
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'discovered_on' => 'required|date',
            'first_contact' => 'required|date',
            'last_contact' => 'required|date',
            'via' => 'required|string|max:255',
            'interview' => 'required|boolean', 
            'status' => 'required|integer',
            'link' => 'nullable',
            'comments' => 'nullable' 
        ]);
        Application::create($validatedData);
        return view('applications', compact('validatedData'));
    }

    public function edit($id){
        $application = Application::find($id);
        if($application->user_id != Auth::id()){
            return redirect()->route('dashboard');
        }
        return view('applications.edit', compact('$editable'));
    }
}
