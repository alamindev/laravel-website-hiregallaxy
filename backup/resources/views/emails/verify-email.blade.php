<div style="max-width: 700px;font-size: 14px; margin: 0px auto; box-shadow: 1px 10px 20px #80808061;">

    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">

        <tbody>

            <tr>

                <td style="vertical-align: top; padding-bottom:30px;" align="center"><a href="{{ route('index') }}" target="_blank">

                    <img src="https://joblrs.com/images/job-email.png" alt="Joblrs" /> 

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

                            Dear Users,

                        </h1>

                        <p style="margin-top: 5px;color: #000;">

                            Welcome to joblrs | You are now a member of us. You can now see jobs, apply jobs, post jobs and many more...

                        </p>

                    </td>

                </tr>

                <tr>

                    <td style="padding:10px 0 30px 0;">

                        <p>Please click the link to verify your email address.</p>

                        <center>

                            <a href="{{ route('user.verify', $token) }}" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #4fc3f7; border-radius: 60px; text-decoration:none;">Verify Email</a>

                        </center>

                        <b>- Thanks (Joblrs Support Team)</b> </td>

                    </tr>

                    <tr>

                        <td style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">If the button above does not work, try copying and pasting the URL into your browser. If you continue to have problems, please feel free to contact us at <a href="{{ route('contacts') }}">contact us</a></td>

                    </tr>

                    

                </tbody>

            </table>

            <p style="text-align: center; margin-top: 40px">

                <a href="{{ route('index') }}">visit our website</a> | get support 

                Copyright © Joblrs, All rights reserved.

            </p>

        </div>

    </div>