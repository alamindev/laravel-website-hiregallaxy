<div id="message-box-{!! $conversation->id !!}" class="h-100">
    <div class="title-conversation clearfix">
        <span style="float:left;" class="d-flex d-md-block align-items-center">
            <a href="{{url('/messages')}}"  class="meanmenu-reveal meanicon-bar d-md-none d-lg-none" >
                <i class="fa fa-arrow-left"></i>
            </a>
            <h5 style="font-weight:700 !important;" class="m-0 p-0 text-muted">
                @ {!! auth()->id() === $conversation->sender_id ?  $conversation->receive->username : $conversation->sender->username!!}
            </h5>
        </span>
        <div class="dropdown float-right">
            <a class="dropdown-toggle p-3" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v text-muted"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                <a  target="_blank" class="dropdown-item"  href="{{ auth()->id() === $conversation->sender_id  ? route( $conversation->receive->is_company == 0 ?  'candidates.show' : 'employers.show',   $conversation->receive->username) :  route( $conversation->sender->is_company == 0 ? 'candidates.show' : 'employers.show', $conversation->sender->username) }}">  Profile</a>
                <a data-receive="{!! auth()->id() === $conversation->sender_id ? $conversation->receive_id : $conversation->sender_id !!}" href="javascript:void(0)" class="dropdown-item text-danger delete_conversation" data-id="{!! $conversation->id !!}">Delete</a>
            </div>
        </div>
    </div>
    <div class="list-messages">
        <ul class="list-unstyled mb-0">

            @if($conversation->messages()->count())
                @if($conversation->messages()->count() > 20)
                    <li class="load_more_message" data-id="{!! $conversation->id !!}" data-page="1"><span>Load more</span></li>
                @endif
                @foreach(collect($conversation->messages()->get()->take(20))->reverse() as $message)
                    {!! $message->seen() !!}
                    @include('frontend.pages.messages.message')
                @endforeach
             @else
             <h5 class="text-muted text-center pt-5 no_conversiation">No conversation Start yet!</h5>
            @endif

        </ul>
        <div class="position-relative write-message{!! auth()->id() == $conversation->sender_id && $conversation->waiting == 1 && !empty($conversation->last_message)?' waiting':'' !!}">

            <input  data-sendername="{!! auth()->user()->username !!}" data-sender="{!! auth()->id() !!}" data-receive="{!! auth()->id() === $conversation->sender_id ? $conversation->receive_id : $conversation->sender_id !!}" data-id="{!! $conversation->id !!}" placeholder="Type your message..." class="message-input">
            <div class="icon__sending">
                <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                <p>Send</p>
            </div>
        </div>
    </div>
</div>
