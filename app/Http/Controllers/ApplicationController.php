<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Application;
use Illuminate\Support\Carbon;

class ApplicationController extends Controller
{
    public function show(){
        $userId = Auth::id(); //define user's id
        $user_applications = Application::where('user_id', $userId)->get(); //get ALL of the user's applications
        $number_of_applications = 0; //used to determine the index of each application
        foreach($user_applications as $application){
            $number_of_applications++; //increment the index for each application
            $application->index = $number_of_applications; //add the current index to the application 
            $days_ago = Carbon::parse($application->last_contact)->diffForHumans(); //relative date handling (X days ago)
            $application->days_ago = $days_ago;
            $application->interview ? $application->interviewImage = 'images/interview.svg' : $application->interviewImage = 'images/nointerview.svg'; //yes or no interview icon 
            $application->statusImage = "images/$application->status.svg"; //custom status image 
        }
        $successMessage = session()->get('successMessage');
        return view('applications.show', compact('user_applications', 'successMessage'));
    }
    
    public function create(Request $request){
        //dd($request->all()) for debugging purposes;
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
            'status' => 'required|string|max:255',
            'link' => 'nullable|url',
            'comments' => 'nullable' 
        ],[
            'user_id.required' => 'Something went wrong, please try again later!',
            'company_name.required' => 'Please enter a company name!',
            'company_name.max' => 'Please enter a valid email address!',
            'location.required' => 'Please enter a location!',
            'location.max' => 'Please enter a valid location!',
            'sector.required' => 'Please enter a sector!',
            'sector.max' => 'Please enter a valid sector!',
            'discovered_on.required' => 'Please enter a date of discovery!',
            'first_contact.required' => 'Please enter a date of first contact!',
            'last_contact.required' => 'Please enter a date of last contact!',
            'date' => 'Please enter a valid date format (YYYY-MMM-DD)!',
            'via.required' => 'Please enter a how you discovered the company (via)!',
            'via.max' => 'Please enter a valid via!',
            'interview.required' => 'Please enter if you had an interview!',
            'interview.boolean' => 'Please only use "Yes" or "No" in the interview field!',
            'status.required' => 'Please enter a status!',
            'status.max' => 'Please enter a valid status!',
            'link.url' => 'Please enter a valid link (https://...)!',
        ]
    );
        Application::create($validatedData);
        $successMessage = 'Application created successfully!';
        return redirect()->route('applications.show')->with([ 'successMessage' => $successMessage ]);
    }

    public function edit($id){ //grabs the application with the id and passes it to the edit view for display
        $application = Application::find($id);
        if ($application == null){
            $errorMessage = 'Application not found!';
            return redirect()->route('applications.show')->with('error', $errorMessage);
        }elseif($application->user_id != Auth::id()){
            $errorMessage = 'You are not authorized to edit this application!';
            return redirect()->route('applications.show')->with('error', $errorMessage);
        }
        return view('applications.edit', compact('application'));
    }

    public function applyEdit(Request $request, $id){ //updates the selected application with new data from the edit page form
        $application = Application::find($id);
        if($application->user_id != Auth::id()){
            return redirect()->route('dashboard');
        }
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'discovered_on' => 'required|date',
            'first_contact' => 'required|date',
            'last_contact' => 'required|date',
            'via' => 'required|string|max:255',
            'interview' => 'required|boolean', 
            'status' => 'required|string|max:255',
            'link' => 'nullable|url',
            'comments' => 'nullable' 
        ],[
            'company_name.required' => 'Please enter a company name!',
            'company_name.max' => 'Please enter a valid email address!',
            'location.required' => 'Please enter a location!',
            'location.max' => 'Please enter a valid location!',
            'sector.required' => 'Please enter a sector!',
            'sector.max' => 'Please enter a valid sector!',
            'discovered_on.required' => 'Please enter a date of discovery!',
            'first_contact.required' => 'Please enter a date of first contact!',
            'last_contact.required' => 'Please enter a date of last contact!',
            'date' => 'Please enter a valid date format (YYYY-MMM-DD)!',
            'via.required' => 'Please enter a how you discovered the company (via)!',
            'via.max' => 'Please enter a valid via!',
            'interview.required' => 'Please enter if you had an interview!',
            'interview.boolean' => 'Please only use "Yes" or "No" in the interview field!',
            'status.required' => 'Please enter a status!',
            'status.max' => 'Please enter a valid status!',
            'link.url' => 'Please enter a valid link (https://...)!',
        ]);
        $application->update($validatedData);
        return redirect()->route('applications.show');
    }

    public function delete($id){ //deletes the selected application
        $application = Application::find($id); //get the application
        if($application->user_id != Auth::id()){ //check if user has permission to delete
            return redirect()->route('dashboard');
        }else{
            $application->delete(); //delete the application
        };
        return redirect()->route('applications.show');
    }
}
