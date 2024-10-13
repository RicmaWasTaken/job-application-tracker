<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function show(){
        $user_id = Auth::id();
        $lifetimeApplications = $this->getAllApplications($user_id);
        $weeklyApplications = $this->getWeeklyApplications($user_id);
        $sevenDaysAgo = Carbon::now()->subDays(7)->format('d/m');
        $today = Carbon::now()->format('d/m');
        $weeklyDates = "$sevenDaysAgo - $today";
        $lastApplications = $this->getLastApplications($user_id, 5);
        return view('dashboard', compact('weeklyApplications', 'lastApplications', 'weeklyDates', 'lifetimeApplications'));
    }

    public function getWeeklyApplications($user_id){
        $processedApplications = [0, 0, 0]; //[accepted, rejected, waiting] -> make it simpler for rendering in js lol
        $rawApplications = Application::where('user_id', $user_id)->whereBetween('first_contact', [Carbon::now()->subDays(7), Carbon::now()])->get();
        foreach ($rawApplications as $application){
            if ($application->status == 'accepted'){
                $processedApplications[0]++;
            } elseif ($application->status == 'rejected'){
                $processedApplications[1]++;
            } else {
                $processedApplications[2]++;
            }
        }
        return $processedApplications;
    }

    public function getAllApplications($user_id){
        $processedApplications = [0, 0, 0]; //[accepted, rejected, waiting] -> make it simpler for rendering in js lol
        $rawApplications = Application::where('user_id', $user_id)->get();
        foreach ($rawApplications as $application){
            if ($application->status == 'accepted'){
                $processedApplications[0]++;
            } elseif ($application->status == 'rejected'){
                $processedApplications[1]++;
            } else {
                $processedApplications[2]++;
            }
        }
        return $processedApplications;
    }

    public function getLastApplications($user_id, $amount){
        $lastApplications = Application::where('user_id', $user_id)->orderBy('first_contact', 'desc')->take($amount)->get();
        foreach ($lastApplications as $application){
            $days_ago = Carbon::parse($application->last_contact)->diffForHumans();
            $application->days_ago = $days_ago;
        }
        return $lastApplications;
    }
}
