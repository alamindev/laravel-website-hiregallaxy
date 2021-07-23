<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:admin');

    }

    /*

    Sponsor list

     */

    public function index()
    {

        $subscribers = Subscriber::orderBy('id', 'desc')->get();

        return view('backend.pages.subscriber.index', compact('subscribers'));

    }

    /*

    Delete Subscriber and related information

     */

    public function destroy($id)
    {

        $subscriber = Subscriber::find($id);

        if ($subscriber) {

            $subscriber->delete();

            session()->flash('error', 'Subscriber Deleted Sucessfully');
            return redirect()->route('admin.subscriber.index');

        }

    }


}