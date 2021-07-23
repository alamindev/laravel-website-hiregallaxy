

<!-- Start Message Section -->

<div class="employer-detail-main message-area">

	

	<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

		<li class="nav-item">

			<a class="nav-link active" id="received-tab" data-toggle="pill" href="#received" role="tab" aria-controls="received" aria-selected="true">Inbox</a>

		</li>

		<li class="nav-item">

			<a class="nav-link" id="sent_messages-tab" data-toggle="pill" href="#sent_messages" role="tab" aria-controls="sent_messages" aria-selected="false">Sent</a>

		</li>

	</ul>

	<div class="tab-content message-tabs" id="pills-tabContent">

		<div class="tab-pane fade show active" id="received" role="tabpanel" aria-labelledby="received-tab">

			@if (count($received_messages) > 0)

			<div class="table-responsive">

				<table class="table table-hover table-striped" id="dataTable">

					<thead>

						<th width="5%">No</th>

						<th width="20%">From</th>

						<th width="40%">Message</th>

						<th width="15%">Reply</th>

					</thead>

					<tbody>



						@foreach ($received_messages as $message)

						<tr>

							<td>{{ $loop->index+1 }}</td>

							<td>

								{{ $message->name }}

								<br>

								<a href="mailto:{{ $message->email }}">

									{{ '<'.$message->email.'>' }}

								</a>

								<span class="text-muted">{{ $message->created_at->diffForHumans() }}</span>

							</td>

							<td>

								{!! $message->message !!}

							</td>

							<td>

								@if ($message->is_replied)

								<span class="text-success">

									<i class="fa fa-check"></i> Replied

								</span>

								<br>

								@endif



								<a href="#replyModal{{ $message->id }}" class="btn btn-outline-success" data-toggle="modal"><i class="fa fa-reply"></i></a>

							</td>

						</tr>

						@endforeach

					</tbody>

				</table>

			</div>

			@else

			<div class="alert alert-danger">

				<strong>Sorry !!</strong>

				There is no messages for you !!

			</div>

			@endif

		</div>



		@foreach ($received_messages as $message)

			<div class="modal animated fadeIn" id="replyModal{{ $message->id }}">

				<div class="modal-dialog modal-lg">

					<div class="modal-content">



						<!-- Modal Header -->

						<div class="modal-header">

							<h4 class="modal-title text-theme font22 bold">Reply Message to - <mark>{{ $message->name }}</mark></h4>

							<button type="button" class="close ml-2" data-dismiss="modal">&times;</button>

						</div>



						<!-- Modal body -->

						<div class="modal-body">

							<form action="{{ route('messages.store') }}" method="post" data-parsley-validate>

								@csrf

								<input type="hidden" name="is_admin" value="0" ?>

								<input type="hidden" name="subject" value="Reply Message">

								<input type="hidden" name="to_user_id" value="{{ $message->from_user_id }}">

								<input type="hidden" name="is_replied" value="{{ $message->id }}">

								<div class="row form-group">

									<div class="col-md-12">

										<label for="message">Your Reply Message</label>

										<textarea name="message" id="message" rows="4" class="form-control" placeholder="Write your message here" required></textarea>

									</div>

								</div>





								<div class="row justify-content-center form-group text-center">

									<div class="col-6">

										<input type="submit" value="Give Reply" class="btn btn-block apply-now-button pt-2 pb-2 font16 ">

									</div>

								</div>



							</form>

						</div>



					</div>

				</div>

			</div>

		@endforeach



		<div class="tab-pane fade" id="sent_messages" role="tabpanel" aria-labelledby="sent_messages-tab">

			@if (count($sent_messages) > 0)

			<div class="table-responsive">

				<table class="table table-hover table-striped" id="dataTable1">

					<thead>

						<th width="5%">No</th>

						<th width="20%">To</th>

						<th width="40%">Message</th>

						<th width="15%">Reply</th>

					</thead>

					<tbody>



						@foreach ($sent_messages as $message)

						<tr>

							<td>{{ $loop->index+1 }}</td>

							<td>

								@if ($message->sent_user != null)

								{{ $message->sent_user->name }}

								<br>

								<a href="mailto:{{ $message->sent_user->email }}">

									{{ '<'.$message->sent_user->email.'>' }}

								</a>

								<span class="text-muted">{{ $message->created_at->diffForHumans() }}</span>

								@else

								--

								@endif

								

							</td>

							<td>

								{!! $message->message !!}

							</td>

							<td>

								<a href="#deleteModal{{ $message->id }}" onclick="if(!confirm('Do you really want to delete this message ?')){return false;}else{event.preventDefault();document.getElementById('delete-message-form').submit();}" class="btn btn-outline-danger" data-toggle="modal" title="Delete Message"><i class="fa fa-trash"></i></a>



								{{-- <form id="delete-message-form" action="{{ route('contacts.delete', $message->id) }}" method="POST" style="display: none;">

									@csrf

								</form> --}}

							</td>

						</tr>

						@endforeach

					</tbody>

				</table>

			</div>

			@else

				<div class="alert alert-danger">

					<strong>Sorry !!</strong>

					There is no message has been sent from you

				</div>

			@endif

			

		</div>

	</div>

</div>

<!-- End Message Section -->