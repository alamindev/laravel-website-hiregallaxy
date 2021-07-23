<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Country;
use App\Models\Location;
use App\Models\UserCategory;
use App\Notifications\VerifyEmailUser;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    /*

    |--------------------------------------------------------------------------

    | Register Controller

    |--------------------------------------------------------------------------

    |

    | This controller handles the registration of new users as well as their

    | validation and creation. By default this controller uses a trait to

    | provide this functionality without requiring any additional code.

    |

     */

    use RegistersUsers;

    /**

     * Where to redirect users after registration.

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

        $this->middleware('guest');

    }

    /**

     * Get a validator for an incoming registration request.

     *

     * @param  array  $data

     * @return \Illuminate\Contracts\Validation\Validator

     */

    protected function validator(array $data)
    {

        return Validator::make($data, [

            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            'password' => ['required', 'string', 'min:6', 'confirmed'],

        ]);

    }

    public function showRegistrationForm()
    {

        $categories = Category::orderBy('name', 'asc')->get();

        $countries = Country::orderBy('name', 'asc')->get();

        return view('auth.register', compact('categories', 'countries'));

    }

    /**

     * Create a new user instance after a valid registration.

     *

     * @param  array  $data

     * @return \App\User

     */

    // protected function create(array $data)

    // {

    //     return User::create([

    //         'name' => $data['name'],

    //         'email' => $data['email'],

    //         'password' => Hash::make($data['password']),

    //     ]);

    // }

    //

    public function register(Request $request)
    {
        
        $validator = \Validator::make($request->all(), [

            'username' => 'required|alpha_num|max:30|unique:users',

            'email' => 'required|email|unique:users',

            'street_address' => 'required',

            'country' => 'required',

            'name' => 'required|max:30',

            'password' => 'required|min:8|confirmed',

        ],

            [

                'username.required' => 'Please give your username',

                'username.alpha_num' => 'Please give your username using alphabet and numbers',

                'username.max' => 'Please give your username between 30 characters',

                'username.unique' => 'Sorry A username is already exists',

                'street_address.required' => 'Please give your street address',

                'country.required' => 'Please choose your country',

                'email.required' => 'Please give an email address',

                'email.email' => 'Please give a valid email address',

                'email.unique' => 'Sorry An email is already exists',

                'name.required' => 'Please give your name',

                'name.max' => 'Please give your name between 30 characters',

                'password.min' => 'Please give your password more than 8 characters',

                'password.confirmed' => 'Please confirm your password',

            ]

        );

        if ($validator->fails()) {

            if ($request->is_company == 1) {

                return redirect('/register?type=employer#registration')->withInput()->withErrors($validator);

            } else {

                return redirect('/register?type=candidate#registration')->withInput()->withErrors($validator);

            }

        }

        // Create location and add location ID

        $location = new Location();

        $location->street_address = $request->street_address;

        $location->country_id = $request->country;

        $location->save();

        $user = new User();

        $user->name = $request->name;

        $user->username = $request->username;

        $user->email = $request->email;

        $user->location_id = $location->id;

        $user->password = Hash::make($request->password);

        $user->verify_token = str_random(50);

        $user->api_token = bin2hex(openssl_random_pseudo_bytes(30));

        $user->save();

        // If User is a company

        if ($request->is_company == 1) {

            $user->is_company = 1;

            // $user->website = $request->website;

            $user->save();

            // Add Company Profile

            $company = new CompanyProfile();

            $company->user_id = $user->id;

            $company->country_id = $request->city;

            $company->sector_id = implode(',', $request->sector);
            $company->category_id = $request->category_id;

            $company->save();

            $message = "An Employer Profile has been created successfully Please check your email and confirm";

        } else {

            $user->is_company = 0;

            $user->save();

            $candidate = new CandidateProfile();

            $candidate->career_level_id = 1; // Beginner

            $candidate->user_id = $user->id;

            $candidate->country_id = $request->city;

            $candidate->sector = $request->sector;

            $candidate->save();

            $userCategory = new UserCategory();

            $userCategory->user_id = $user->id;

            $userCategory->category_id = $request->sector;

            $userCategory->save();

            $message = "A Candidate Profile has been created successfully Please check your email and confirm";

        }

        session()->flash('success', $message);

        $user->notify(new VerifyEmailUser($user));

        if ($request->is_company == 1) {

            return redirect('/login');

        } else {

            return redirect('/login');

        }

    }

}
