<?php

namespace App\Console;

use App\Models\Job;
use App\Models\Subscriber;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{

    /**

     * The Artisan commands provided by your application.

     *

     * @var array

     */

    protected $commands = [

        //

    ];

    /**

     * Define the application's command schedule.

     *

     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule

     * @return void

     */

    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {

            $subscribed_users = Subscriber::where('status', 1)->get();

            // Jobs which has_mailed = 0 are the jobs need to send to the subscriber

            $jobs = Job::where('status', 1)

                ->where('has_mailed', 0)

                ->leftJoin('users', 'users.id', '=', 'jobs.user_id')

                ->select(

                    'jobs.id',

                    'jobs.title',

                    'jobs.location',

                    'jobs.slug',

                    'jobs.has_mailed',

                    'users.name as employer_name'

                )

                ->get();

            foreach ($subscribed_users as $user) {

                if (count($jobs) > 0) {

                    echo $user;

                    $to = $user->email;

                    $subject = 'Latest Job Posts From Joblrs';

                    // $message = 'This mail is sent using the PHP mail function Test';

                    // $headers = 'From: support@joblrs.com';

                    // mail($to, $subject, $message, $headers);

                    $headers[] = 'MIME-Version: 1.0';

                    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

                    $headers[] = "To: User <$to>";

                    $headers[] = 'From: Latest Job Posts | joblrs <support@joblrs.com>';

                    $headers[] = 'Cc: support@joblrs.com';

                    $headers[] = 'Bcc: support@joblrs.com';

                    $message = "";

                    $message .= '

                <div style="max-width: 700px;font-size: 14px; margin: 0px auto; box-shadow: 1px 10px 20px #80808061;">

                <div border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">

                    <div>

                        <div style="background: #FFF;">

                            <div style="vertical-align: top;padding-bottom: 7px;margin-top: 0px;padding-top: 2px;" align="center">

                                <a href="https://joblrs.com" target="_blank" style="text-decoration: none;font-weight: bold;font-family: monospace;font-size: 24px;">

                                    <img src="https://joblrs.com/public/images/1568510871.png" style="max-width: 200px"/>

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <div style="padding: 10px;background: #fff;margin-top: -50px;">

                <h3 style="color: #5e59c9;font-size: 25px;font-family: sans-serif;display: inline-block;">Our Latest Jobs</h3>

                    ';

                    foreach ($jobs as $job) {

                        $message .= '

                                  <div style="padding: 10px;margin-top: 10px;box-shadow: 3px 7px 17px 2px #3f51b51f;background: #cccccc2b;">

                                      <h3 style="font-size: 20px;font-weight: bold;font-family: sans-serif;color: #5e59c9;">' . $job->title

                        . '</h3>

                                      <p>

                                          Location: ' . $job->location .

                        '</p>

                                      <p>

                                          Employer: ' . $job->employer_name .

                        '</p>

                                      <p>

                                          <a href="https://joblrs.com/jobs/view/' . $job->slug . '" style="background: #5e59c9!important;padding: 5px 20px;color: #FFF;text-decoration: none;border-radius: 10px;font-weight: bold;">

                                              View Job

                                          </a>

                                      </p>

                                  </div>

                              ';

                    }

                    $message .= '

                      <div style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">

                      If the button above does not

                          work, try copying and pasting the URL into your browser. If you continue to have problems,

                          please feel free to contact us at <a href="https://joblrs.com/contact-us">Contact us</a>

                      </div>



                    <p style="text-align: center; margin-top: 40px">

                        <a href="https://joblrs.com">Visit our website</a> | Get Support

                        Copyright © Joblrs, All rights reserved.

                    </p>

                    <p style="text-align: center; margin-top: 10px">

                        Are you willing to unsubscribe from our news letter ?

                        <a href="https://joblrs.com/unsubscribe/' . $to . '" style="color: red; font-weight: bold">

                            Unsubscribe Now

                        </a>

                    </p>

                </div>

              </div>

            ';

                    mail($to, $subject, $message, implode("\r\n", $headers));

                }

            }

            // Marked jobs as mailed, update in jobs table which hailed = 0 previously 0 to 1

            foreach ($jobs as $job) {

                $job->has_mailed = 1;

                $job->save();

            }

        })->everyMinute();

        // $schedule->command('inspire')

        //          ->hourly();

        // Testing Cron Features

        // DB::table('tags')->insert([

        //     'name'  => 'Test',

        //     'slug'  => 'test'

        // ]);

        //Get all subscribed users

    }

    /**

     * Register the commands for the application.

     *

     * @return void

     */

    protected function commands()
    {

        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');

    }

}
