<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{

    /*

    |--------------------------------------------------------------------------

    | Email Verification Controller

    |--------------------------------------------------------------------------

    |

    | This controller is responsible for handling email verification for any

    | user that recently registered with the application. Emails may also

    | be re-sent if the user didn't receive the original email message.

    |

     */

    use VerifiesEmails;

    /**

     * Where to redirect users after verification.

     *

     * @var string

     */

    protected $redirectTo = '/';

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {

        // $this->middleware('auth');

        // $this->middleware('signed')->only('verify');

        // $this->middleware('throttle:6,1')->only('verify', 'resend');

    }

    /**

     * verify function

     *

     * When User hit verify email link they will come to this place

     *

     * @param  Request $request

     * @return response

     */

    public function verify(Request $request)
    {

        $token = $request->verify_token;

        $user = User::where('verify_token', $token)->first();

        if (!is_null($user)) {

            $user->status = 1;

            $user->email_verified_at = date('Y-m-d h:i:s');

            $user->verify_token = null;

            $user->save();

            session()->flash('success', 'Your account has successfully verified . Please login');

            return redirect()->route('login');

        } else {

            session()->flash('error', 'Sorry . The token is invalid and may have expired .');

            return redirect()->route('login');

        }

    }

}
