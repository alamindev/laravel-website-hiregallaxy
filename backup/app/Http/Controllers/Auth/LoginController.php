<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\VerifyEmailUser;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{

    /*

    |--------------------------------------------------------------------------

    | Login Controller

    |--------------------------------------------------------------------------

    |

    | This controller handles authenticating users for the application and

    | redirecting them to your home screen. The controller uses a trait

    | to conveniently provide its functionality to your applications.

    |

     */

    use AuthenticatesUsers;

    /**

     * Where to redirect users after login.

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

        $this->middleware('guest')->except('logout');

    }

    public function showLoginForm()
    {

        if (Auth::check()) {

            session()->flash('success', 'You are already logged in');

            return redirect()->route('index');

        }

        return view('auth.login');

    }

    public function login(Request $request)
    {

        //Validate the form data

        $this->validate($request, [

            'username' => 'required',

            'password' => 'required|min:6',

        ]);

        //Attempt to login

        if (Auth::guard('web')->attempt(['email' => $request->username, 'password' => $request->password, 'status' => 1], $request->remember)) {

            // check whether the user is employer or not
            $check = User::where('username', $request->username)->orWhere('email', $request->username)->where('is_company', 1)->first();
            if (!is_null($check)) {
                if ($check->type == 1) {
                    return redirect()->intended(route('team.dashboard', $check->id));
                } else {
                    return redirect()->intended(route('employers.dashboard'));
                }
            } else {
                return redirect()->intended(route('index'));
            }

        } else {

            if (Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password, 'status' => 1], $request->remember)) {

                // check whether the user is employer or not
                $check = User::where('username', $request->username)->orWhere('email', $request->username)->where('is_company', 0)->first();
                if (!is_null($check)) {
                    return redirect()->intended(route('candidates.dashboard'));
                } else {
                    return redirect()->intended(route('index'));
                }

            }

        }

        // Check if has account but status=0

        $user = User::where('username', $request->username)->orWhere('email', $request->username)->first();

        if (!is_null($user)) {

            if ($user->status == 0) {

                // Send him a account activation link and redirect login page

                $user->notify(new VerifyEmailUser($user));

                Session::flash('message', "Your account is not verified yet. Please activate your account. An email has sent to your account. Please verify.");

                return redirect()->route('login');

            }

            if ($user->status == 2) {

                Session::flash('message', "Your account has been suspended. Please contact with administrator");

                return redirect()->route('index');

            }

        }

        //If unsuccessfull, then redirect to the admin login with the data

        Session::flash('login_error', "Username and password combination doesn't match. Please provide correct email and password");

        return redirect()->back()->withInput($request->only('username', 'remember'));

    }

}
