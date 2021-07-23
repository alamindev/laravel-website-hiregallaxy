 <li id="conversation-{!! $conv->id !!}" data-id="{!! $conv->id !!}" class="conversation-item {!! ( Illuminate\Support\Facades\Route::is('message') && request()->id ==  $conv->id) || (!request()->id && $key == 0) ? ' active':''!!}" >
    <div class="media">
        @if(!isset($html_receive) && auth()->id() === $conv->sender_id)
            <img alt="image" class="mr-2 border rounded-circle" src="{{ App\Helpers\ReturnPathHelper::getUserImage($conv->receive['id']) }}">
        @else
            <img alt="image" class="mr-2 border rounded-circle" src="{{ App\Helpers\ReturnPathHelper::getUserImage($conv->sender['id']) }}">
        @endif
        <div class="media-body">
            @if(auth()->id() === $conv->sender_id)
                <strong>{!! $conv->receive['username'] !!}</strong>
            @else
                <strong>{!! $conv->sender['username'] !!}</strong>
            @endif
            
        </div>
    </div>
</li> 
