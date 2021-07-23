<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

// use App\Mail\SendMailable;

class SubscriberController extends Controller
{

    /**

     * store

     *

     * @param Request $request

     * @return void

     */

    public function store(Request $request)
    {

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {

            $subscriber = Subscriber::where('email', $request->email)->first();

            if (is_null($subscriber)) {

                $subscriber = new Subscriber();

                $subscriber->email = $request->email;

                $subscriber->status = 1;

                if ($subscriber->save()) {

                    return json_encode(['status' => 'success', 'message' => 'Congratulation . You are now subscribed to our job site .']);

                }

            } else {

                return json_encode(['status' => 'error', 'message' => 'You are already a subscribed user .']);

            }

        }

        return json_encode(['status' => 'error', 'message' => 'Sorry . Invalid email address .']);

    }

    /**

     * unsubscribe

     *

     * @param [type] $email

     * @return void

     */

    public function unsubscribe($email)
    {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $subscriber = Subscriber::where('email', $email)->first();

            if (is_null($subscriber)) {

                session()->flash('error', 'Sorry . No email has been added by this email address .');

                return redirect()->route('index');

            } else {

                $subscriber->delete();

                session()->flash('success', 'Congratulation . Your email address has been removed from our subscription list .');

                return redirect()->route('index');

            }

        }

        return json_encode(['status' => 'error', 'message' => 'Sorry . Invalid email address .']);

    }

    /**

     * sendEmailAsCron()

     *

     * @param string $api_token

     * @return void

     */

    public function sendEmailAsCron($api_token)
    {

        // if (!is_null(Admin::where('api_token', $api_token)->first())) {

        //     //Get all subscribed users

        $subscribed_users = Subscriber::where('status', 1)->get();

        $jobs = Job::where('status', 1)->where('has_mailed', 0)

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

        $to = 'manirujjamanakash@gmail.com'; // note the comma

        // Subject

        $subject = 'Latest Job Posts';

        // Message

        $message = '';

        $message .= '

                <html>

                <head>

                  <title>Latest Job Posts</title>

                </head>

                <body>

                    <div style="max-width: 700px;font-size: 14px; margin: 0px auto; box-shadow: 1px 10px 20px #80808061;">

                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">

                            <tbody>

                                <tr style="background: #ededed;">

                                    <td style="vertical-align: top; padding-bottom:30px;" align="center">

                                        <a href="' . url('/') . '" target="_blank">

                                            <h2>' . config("app.name") . '</h2>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                        <div style="padding: 40px; background: #fff;">

                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">

                                <tbody>

                                    <tr>

                                        <td style="border-bottom:1px solid #f6f6f6;">

                                            <h1 style="font-size:14px; font-family:arial; margin:0px; font-weight:bold;">

                                                Dear User,

                                            </h1>

                                            <p style="margin-top: 5px;color: #000;">

                                                Welcome to ' . config("app.name") . ' | Here are our latest job posts if you missed it.

                                            </p>

                                        </td>

                                    </tr>

                                    ';

        foreach ($jobs as $job) {

            $job_link = route('jobs.show', $job->slug);

            $message .= '

                                        <tr style="margin-top: 40px">

                                            <td style="padding: 20px;background: #f5f5f5;margin-top: 0px;">

                                                <h3>

                                                    ' . $job->title . '

                                                </h3>

                                                <p>

                                                    Location: ' . $job->location . '

                                                </p>

                                                <p>

                                                    Employer: ' . $job->employer_name . '

                                                </p>

                                                <p>

                                                    Link:

                                                    <a href="' . $job_link . '">

                                                        View Job

                                                    </a>

                                                </p>

                                            </td>

                                        </tr>

                                        ';

        }

        $contact_link = route('contacts');

        $message .= '<tr>

                                        <td style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">

                                        If the button above does not

                                        work, try copying and pasting the URL into your browser. If you continue to have problems,

                                        please feel free to contact us at <a href="' . $contact_link . '">contact us</a>

                                        </td>

                                    </tr>



                                </tbody>

                            </table>

                            <p style="text-align: center; margin-top: 40px">

                                <a href="' . route('index') . '">visit our website</a> | get support

                                Copyright © ' . config('app.name') . ', All rights reserved.

                            </p>

                            <p style="text-align: center; margin-top: 10px">

                                Are you willing to unsubscribe from our news letter ?

                                <a href="' . route('users.unsubscribe', $to) . '" style="color: red; font-weight: bold">

                                    Unsubscribe Now

                                </a>

                            </p>

                        </div>

                    </div>

                </body>

                </html>

                ';

        // To send HTML mail, the Content-type header must be set

        $headers[] = 'MIME-Version: 1.0';

        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Additional headers

        $headers[] = "To: User <$to>";

        $headers[] = 'From: Latest Job Posts <support@joblrs.com>';

        $headers[] = 'Cc: support@joblrs.com';

        $headers[] = 'Bcc: support@joblrs.com';

        // Mail it

        mail($to, $subject, $message, implode("\r\n", $headers));

    }

}
