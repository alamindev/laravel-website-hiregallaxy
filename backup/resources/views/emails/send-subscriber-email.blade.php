<div style="max-width: 700px;font-size: 14px; margin: 0px auto; box-shadow: 1px 10px 20px #80808061;">

    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">

        <tbody>

            <tr style="background: #ededed;">

                <td style="vertical-align: top; padding-bottom:30px;" align="center">

                    <a href="https://joblrs.com" target="_blank">

                        <h2>Joblrs</h2>

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

                            Welcome to Joblrs | Here are our latest job posts if you missed it.

                        </p>

                    </td>

                </tr>



                @foreach ($jobs as $job)

                <tr style="margin-top: 40px">

                    <td style="padding: 20px;background: #f5f5f5;margin-top: 0px;">

                        <h3>

                            {{ $job->title }}

                        </h3>

                        <p>

                            Location: {{  $job->location }}

                        </p>

                        <p>

                            Employer: {{  $job->employer_name }}

                        </p>

                        <p>

                            Link:

                            <a href="https://joblrs.com/jobs/view/{{  $job->slug }}">

                                View Job

                            </a>

                        </p>

                    </td>

                </tr>

                @endforeach



                <tr>

                    <td style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">If the button above does not

                        work, try copying and pasting the URL into your browser. If you continue to have problems,

                        please feel free to contact us at <a href="https://joblrs.com/contact-us">Contact us</a></td>

                </tr>



            </tbody>

        </table>

        <p style="text-align: center; margin-top: 40px">

            <a href="https://joblrs.com">visit our website</a> | get support

            Copyright © Joblrs, All rights reserved.

        </p>

        <p style="text-align: center; margin-top: 10px">

            Are you willing to unsubscribe from our news letter ?

            <a href="https://joblrs.com/unsubscribe/" style="color: red; font-weight: bold">

                Unsubscribe Now

            </a>

        </p>

    </div>

</div>