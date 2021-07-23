<?php

namespace App\Http\Controllers\Frontend;

use App\Conversation;
use App\Http\Controllers\Controller;
use App\Message;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
              $this->middleware('auth:web');
    }

    public function messages()
    {
        $conversations = Conversation::with('sender', 'receive')
            ->where('sender_id', auth()->id())
            ->orWhere(function (Builder $query) {
                $query->where('receive_id', auth()->id())->whereNotNull('last_message');
            });
        if ($this->request->search && $this->request->search != '') {
         $term = $this->request->search;
            $conversations->where(function ($query) use ($term) {
                $query->WhereHas('sender', function ($query) use ($term) {
                    $query->where('username', 'LIKE', "%$term%");
                });
                $query->orWhereHas('receive', function ($query) use ($term) {
                    $query->where('username', 'LIKE', "%$term%");
                });
            });

        }

        $conversations = $conversations->orderBy('updated_at', 'DESC')
            ->get()
            ->take(10);
        return view('frontend.pages.messages.all', compact('conversations'));
    }

    public function message($id)
    {
        $conversation = Conversation::with('messages', 'sender', 'receive')->where('id', $id)->where(function (Builder $query) {
            $query->where('sender_id', auth()->id())->orWhere('receive_id', auth()->id());
        })->first();
        if ($conversation) {
            $conversations = Conversation::where('sender_id', auth()->id())->orWhere(function (Builder $query) {
                $query->where('receive_id', auth()->id())->whereNotNull('last_message');
            })->orderBy('updated_at', 'DESC')->get()->take(10);
            if ($this->request->search && $this->request->search != '') {
                return redirect()->route('messages',['search'=> $this->request->search]);
            }
            return view('frontend.pages.messages.all', compact('conversations', 'conversation'));
        }
        return redirect()->route('messages');

    }

    public function startChat($id)
    {
        if (!Auth::check() && Auth::id() != $id) {

            session()->flash('error', 'Sorry   You are not permitted to do this action');

            return redirect()->route('index');

        }
        $conversation = Conversation::where(function (Builder $query) use ($id) {
            $query->where('sender_id', $id)->where('receive_id', auth()->id());
        })->orWhere(function (Builder $query) use ($id) {
            $query->where('sender_id', auth()->id())->where('receive_id', $id);
        })->first();
        if (!$conversation) {
            $conversation = new Conversation();
            $conversation->sender_id = auth()->id();
            $conversation->receive_id = $id;
            $conversation->updated_at = date('Y-m-d H:i:s');
            $conversation->save();
        } else {
            $conversation->last_message = '';
            $conversation->save();
        }
        return redirect()->route('message', ['id' => $conversation->id]);
    }
}