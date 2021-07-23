<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Auth;

class UsersController extends Controller
{

    /**

     * users dashboard page

     *

     * @return view

     */

    public function dashboard()
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry . You are not an authenticated User. Please login .');

            return redirect()->route('jobs');

        }

        $user = Auth::user();

        if ($user->is_company) {

            return redirect()->route('employers.dashboard');

        }

        return redirect()->route('candidates.dashboard');

    }

}
