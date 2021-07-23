<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:admin');

    }

    /**

     * candidate page

     * @return view Return the candidate page

     */

    public function candidates()
    {

        $users = User::orderBy('id', 'desc')->where('is_company', 0)->get();

        return view('backend.pages.users.candidates', compact('users'));

    }

    /**

     * employers page

     * @return view Returns the employer with the datas

     */

    public function employers()
    {

        $users = User::orderBy('id', 'desc')->where('is_company', 1)->get();

        return view('backend.pages.users.employers', compact('users'));

    }

    /**

     * ban

     * @param  response $id Return the View after making ban or active any user

     * @return view

     */

    public function ban($id)
    {

        $user = User::find($id);

        if ($user->status == 0 || $user->status == 2) {

            $user->status = 1;

        } else {

            $user->status = 2;

        }

        $user->save();

        session()->flash('success', 'User status has been changed .');

        return back();

    }

}
