<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationAlert;

class SendApplicationAlert extends Command
{
    protected $signature = 'applications:alert';
    protected $description = 'Send an email to users with applications after two weeks since last contact';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // get the date 14 days ago (2 weeks)
        $dateThreshold = Carbon::now()->subDays(14)->toDateString();

        // get users with applications that are older than 14 days and status waiting
        $users = User::whereHas('applications', function($query) use ($dateThreshold) {
            $query->whereDate('last_contact', '=', $dateThreshold)
                  ->where('status', 'waiting'); // Filter by status
        })->get();

        // check and handle if no users found
        if ($users->isEmpty()) {
            $this->info('No users with applications to alert.');
        } else {
            // send email to each user
            foreach ($users as $user) {
                // get relevant applications for the user
                $applications = $user->applications->where('last_contact', '=', $dateThreshold) // filter by date
                    ->where('status', 'waiting'); // filter by status

                // send the email with the applications' data
                Mail::to($user->email)->send(new ApplicationAlert($user, $applications));
                // console log of who received the emails
                $this->info('Email sent to ' . $user->email);
            }
            // log end of event
            $this->info('Application alerts have been sent.');
        }
    }
}
