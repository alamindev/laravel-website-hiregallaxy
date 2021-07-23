@extends('frontend.layouts.master-two')



@section('title')

Messages | {{ App\Models\Setting::first()->site_title }}

@endsection

@section('styles')

Messages | {{ App\Models\Setting::first()->site_title }}

@endsection

@section('content')
<section class="employer-page sec-pad pt-0">
  <div class="conversations clearfix main-contents container">
    <div class="page-title text-capitalize m-0">
        <h2 class="m-0">All Conversations</h2>
    </div>
      <div class="main-content__message py-5">
        <div class="float-left list-conversations">
            <div class="search-conversation">
                <form action="">
                    <input type="text" placeholder="Search" name="search">
                     <button type="submit" class="border-0 bg-transparent"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <ul class="list-unstyled mb-0">
                @if($conversations->count())
                    @foreach($conversations as $key=>$conv)
                        @include('frontend.pages.messages.item')
                    @endforeach
                    @else <div class="text-center mt-5"><i class="fas fa-frown frown"></i><h6>Bummer!</h6>Looks like you have no messages yet!</div>
                @endif
            </ul>
        </div>
        <?php
            if(!isset($conversation)){
                $conversation = $conversations->first();
            }
        ?>
        <div class="float-left message-box hidden-xs message__main_body  @if(!$conversation) d-flex align-items-center justify-content-center @endif">

            @if($conversation)
                @include('frontend.pages.messages.conversation')
            @else  <h5 class="text-muted text-center pt-5 no_conversiation">No conversation Start yet!</h5>
            @endif

        </div>
      </div>
  </div>
  </section>
@endsection
