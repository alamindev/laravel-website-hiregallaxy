<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Auth;

class ContactController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:admin');

    }

    public function index()
    {
        $contacts = Contact::orderby('created_at', 'desc')->get();
        return view('backend.pages.contact.index', compact('contacts'));

    }

    public function view($id)
    {
        $contact = Contact::find($id);
        return view('backend.pages.contact.show', compact('contact'));

    }

    public function destroy($id)
    {

        if (Auth::check()) {

            $contact = Contact::find($id);

            $contact->delete();

        }
        session()->flash('error', 'Message Deleted  ');

        return back();

    }

}
