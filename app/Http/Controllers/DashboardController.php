<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Lead;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function show(){
        $user_id = Auth::id();

        // get data for charts under chartData variable
        $chartData = new \stdClass();
        $chartData->lifetimeApplications = json_encode($this->getApplicationsStatus($user_id, 'lifetime'));
        $chartData->weeklyApplications = json_encode($this->getApplicationsStatus($user_id, 'weekly'));

        //get data for stats table under statsData megavariable
        $statsData = new \stdClass();
        $statsData->weekly = new \stdClass();
        $statsData->lifetime = new \stdClass();

        //get data for weekly stats table 
        $statsData->weekly->applicationTotal = $this->getApplicationCount($user_id, 'weekly');
        $statsData->weekly->applicationEvolution = $this->getApplicationEvolution($user_id, 'weekly');
        $statsData->weekly->applicationResponseRate = $this->getApplicationResponseRate($user_id, 'weekly');
        $statsData->weekly->leadTotal = $this->getLeadCount($user_id, 'weekly');
        $statsData->weekly->leadEvolution = $this->getLeadEvolution($user_id, 'weekly');

        //get data for lifetime stats table
        $statsData->lifetime->applicationTotal = $this->getApplicationCount($user_id, 'lifetime');
        $statsData->lifetime->applicationEvolution = $this->getApplicationEvolution($user_id, 'lifetime');
        $statsData->lifetime->applicationResponseRate = $this->getApplicationResponseRate($user_id, 'lifetime');
        $statsData->lifetime->leadTotal = $this->getLeadCount($user_id, 'lifetime');
        $statsData->lifetime->leadEvolution = $this->getLeadEvolution($user_id, 'lifetime');


        // get data for dates under dates variable
        $dates = new \stdClass();
        $dates->sevenDaysAgo = Carbon::now()->subDays(7)->format('d/m');
        $dates->today = Carbon::now()->format('d/m');
        $dates->weeklyDates = "$dates->sevenDaysAgo - $dates->today";

        $lastApplications = $this->getLastApplications($user_id, 5);


        return view('dashboard', compact('chartData', 'statsData', 'dates', 'lastApplications'));
    }

    public function getApplicationCount($user_id, $timeframe){
        if ($timeframe == 'weekly'){
            $applications = Application::where('user_id', $user_id)->whereBetween('first_contact', [Carbon::now()->subDays(7), Carbon::now()])->count();
        } else {
            $applications = Application::where('user_id', $user_id)->count();
        }
        return $applications;
    }
    public function getLeadCount($user_id, $timeframe){
        if ($timeframe == 'weekly'){
            $leads = Lead::where('user_id', $user_id)->whereBetween('discovered_on', [Carbon::now()->subDays(7), Carbon::now()])->count();
        } else {
            $leads = Lead::where('user_id', $user_id)->count();
        }
        return $leads;
    }
    public function getApplicationResponseRate($user_id, $timeframe){
        if ($timeframe == 'weekly'){
            $applications = Application::where('user_id', $user_id)->whereBetween('first_contact', [Carbon::now()->subDays(7), Carbon::now()])->count();
            $responses = Application::where('user_id', $user_id)->whereBetween('first_contact', [Carbon::now()->subDays(7), Carbon::now()])->where('status', 'accepted')->count();
        } else {
            $applications = Application::where('user_id', $user_id)->count();
            $responses = Application::where('user_id', $user_id)->where('status', 'accepted')->count();
        }
        if ($applications == 0){
            return 0;
        } else {
            return round(($responses / $applications) * 100, 2).'%';
        }
    }

    public function getApplicationEvolution($user_id, $timeframe){
        $today = Carbon::now();
        $lastWeek = Carbon::now()->subDays(7);
        $twoWeeksAgo = Carbon::now()->subDays(14);
        if($timeframe == 'weekly'){
            $applicationsLastWeek = Application::where('user_id', $user_id)->whereBetween('first_contact', [$lastWeek, $today])->count();
            $applicationsTwoWeeksAgo = Application::where('user_id', $user_id)->whereBetween('first_contact', [$twoWeeksAgo, $twoWeeksAgo])->count();
        } else {
            return 'N/A';
        }
        if ($applicationsTwoWeeksAgo == 0){
            return 0;
        } else {
            return round((($applicationsLastWeek - $applicationsTwoWeeksAgo) / $applicationsTwoWeeksAgo) * 100, 2).'%';
        }
    }
    public function getLeadEvolution($user_id, $timeframe){
        $today = Carbon::now();
        $lastWeek = Carbon::now()->subDays(7);
        $twoWeeksAgo = Carbon::now()->subDays(14);
        if($timeframe == 'weekly'){
            $leadsLastWeek = Lead::where('user_id', $user_id)->whereBetween('discovered_on', [$lastWeek, $today])->count();
            $leadsTwoWeeksAgo = Lead::where('user_id', $user_id)->whereBetween('discovered_on', [$twoWeeksAgo, $twoWeeksAgo])->count();
        } else {
            return 'N/A';
        }
        if ($leadsTwoWeeksAgo == 0){
            return 0;
        } else {
            return round((($leadsLastWeek - $leadsTwoWeeksAgo) / $leadsTwoWeeksAgo) * 100, 2).'%';
        }
    }


    // chart methods
    public function getApplicationsStatus($user_id, $timeframe){
        $processedApplications = [0, 0, 0]; //[accepted, rejected, waiting] -> make it simpler for rendering in js lol
        if ($timeframe == 'weekly'){
            $rawApplications = Application::where('user_id', $user_id)->whereBetween('first_contact', [Carbon::now()->subDays(7), Carbon::now()])->get();
        } else {
            $rawApplications = Application::where('user_id', $user_id)->get();
        }
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

    // bottom row methods
    public function getLastApplications($user_id, $amount){
        $lastApplications = Application::where('user_id', $user_id)->orderBy('first_contact', 'desc')->take($amount)->get();
        foreach ($lastApplications as $application){
            $days_ago = Carbon::parse($application->last_contact)->diffForHumans();
            $application->days_ago = $days_ago;
        }
        return $lastApplications;
    }
}
