<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\User;
use Auth;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
   
    
    public function index()
    {

        return view('frontend.pages.contacts.index');

    }

    public function store(Request $request)
    {

        // if (!Auth::check()) {

        //        session()->flash('error', 'Sorry   You are not permitted to apply job  ');

        //        return back();

        //    }

        $this->validate($request, [

            'to_user_id' => 'nullable|numeric',

            'name' => 'nullable|max:100',

            'email' => 'nullable|email|max:100',

            'message' => 'required',

        ]);

        $contact = new Contact();

        if (Auth::check() && Auth::id() == $request->to_user_id) {

            session()->flash('error', 'Sorry   can not send message to yourself  ');

            return back();

        }

        $contact->to_user_id = $request->to_user_id;

        if (empty($request->to_user_id)) {

            $user = User::where('email', $request->email)->first();

            if (!is_null($user)) {

                $contact->to_user_id = $user->id;

            }

        }

        $contact->name = $request->name;

        $contact->email = $request->email;

        if (Auth::check()) {

            $contact->name = Auth::user()->name;

            $contact->email = Auth::user()->email;

        }

        $contact->message = $request->message;

        $contact->subject = $request->subject;

        $contact->is_admin = $request->is_admin;

        if ($request->is_replied) {

            $this->validate($request, [

                'is_replied' => 'required|numeric',

            ]);

            $contactReplied = Contact::find($request->is_replied);

            if (!is_null($contactReplied)) {

                $contactReplied->is_replied = 1;

                $contactReplied->save();

            }

        }

        if (Auth::check()) {

            $contact->from_user_id = Auth::id();

        }

        $contact->save();

        $message = "Success   Message has been sent successfully  ";

        if ($request->is_admin == 1) {

            $message = "Your Message has been sent successfully to the Joblrs Support Panel   <br />Please wait before support team's interaction";

        }

        session()->flash('success', $message);

        return back();

    }

}
