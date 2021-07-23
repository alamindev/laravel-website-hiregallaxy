@push('stylesheets_stack')

<style type="text/css">

	.checked{

		text-decoration: line-through!important;

	}

	.btn-add {

	    background-color: #ffc107;

	    color: #fff;

	    border: 2px solid rgba(255, 255, 255, .3);

	    font-size: 19px;

	    display: inline-block;

	    text-align: center;

        border-radius: 5px;

	}

</style>

@endpush



<div id="todo_list_div" class="row">

	<div class="col-md-12">

		<h3>

			Todo List

			<!-- <button class="btn btn-info pull-right">View All</button> -->

		</h3>

	</div>

	<div class="col-md-12">

		<div class="card">

			<div class="card-header text-dark bg-warning">

				Pending Tasks
				<button  id="createTodoBtn" class="btn-add pull-right" data-toggle="tooltip" title="Add new task">
                    <strong >+</strong>
                </button>



			</div>

			<div class="card-body" id="pending_div"></div>

		</div>

		<div class="card mt-4">

			<div class="card-header text-white bg-success">Completed Tasks</div>

			<div class="card-body" id="completed_div">

			</div>



		</div>

	</div>

</div>





<!-- Logout Modal-->

<div class="modal fade" id="todoModal" tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog" role="document">

  	<form id="todosForm" action="{{route('todos.store')}}" method="post" data-parsley-validate>

	    <div class="modal-content">

			<div class="modal-header">

				<h5 class="modal-title">Create Todo</h5>

				<button class="close" type="button" data-dismiss="modal" aria-label="Close">

				  <span aria-hidden="true">×</span>

				</button>

			</div>

			<div class="modal-body">



			</div>

			<div class="modal-footer">

				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

				<button type="submit" class="btn btn-primary">Save</button>

			</div>

	    </div>

  		@csrf

  	</form>

  </div>

</div>



@push('scripts_stack')

<script type="text/javascript">

	let todosIndexRoute = "{{route('todos.index')}}";

	function initTodos() {
		var team_id = $('.todo__team').attr('data-id')
		if(team_id){
			$('#createTodoBtn').remove();
		}
		$.get('{{route('todos.getAll')}}', team_id ? {id: team_id} : '', function(data) {

			if(data.status === 200){

				let todos = data.todos;

				let completed_todos = '';

				let pending_todos = '';

				$.each(todos, function(index, todo) {

					if(todo.status == 1){

						completed_todos += `

										<div class="form-group">

											<label class="checked">

												<input class="todo" type="checkbox" checked name="todo" value="${todo.id}">

												${todo.title}

											</label>

											<span class="pull-right">

												<a id="editTodoBtn" data-id=${todo.id} class="btn btn-edit" data-toggle="tooltip" title="Edit todo"><i class="fa fa-pencil-square-o" ></i></a>

												<a id="deleteTodoBtn" data-id=${todo.id} class="btn btn-edit" title="Delete todo"><i class="fa fa-trash-o"></i></a>

											</span>

										</div>`;


					}else{

						pending_todos += `

										<div class="form-group">

											<label>

												<input class="todo" type="checkbox" name="todo" value="${todo.id}">

												${todo.title}

											</label>

											<span class="pull-right">

												<a id="editTodoBtn" data-id=${todo.id} class="btn btn-edit" title="Edit todo"><i class="fa fa-pencil-square-o" ></i></a>

												<a id="deleteTodoBtn" data-id=${todo.id} class="btn btn-edit" data-toggle="tooltip" title="Delete todo"><i class="fa fa-trash-o"></i></a>

											</span>

										</div>`;



					}

				});



				$('#completed_div').html(completed_todos);

				$('#pending_div').html(pending_todos);
				if(team_id){
					$('#pending_div .todo').remove();
				$('#pending_div .pull-right').remove();
					$('#completed_div .todo').remove();
				$('#completed_div .pull-right').remove();
				}

			}

		});

	}

	$(function(){

		initTodos();

		// $(document).on('change', '#todo_list_div :input', function(e) {

		// 	initTodos();

		// });

		$(document).on('change', '.todo[type="checkbox"]', function(e){

			let id = $(this).val();

			$.post(`${todosIndexRoute}/toggle/${id}`, function(data, textStatus, xhr) {

				if(data.status == 200){

					initTodos();

				}

			});

		});

		$(document).on('click', '#createTodoBtn', function(e){

			e.preventDefault();

			let todoModal = $('#todoModal');

			todoModal.find('.modal-title').text('Create Todo');

			$.get('{{route('todos.create')}}', function(data) {

				todoModal.find('.modal-body').html(data);

			}).then(function(){

				todoModal.modal('show');

			});

		});

		$(document).on('click', '#editTodoBtn', function(e){

			e.preventDefault();



			let id = $(this).data('id');

			let todoModal = $('#todoModal');

			todoModal.find('.modal-title').text('Edit Todo');

			$.get(`${todosIndexRoute}/${id}/edit`, function(data) {

				todoModal.find('.modal-body').html(data);

			}).then(function(){

				todoModal.modal('show');

			});

		});

		$(document).on('click', '#deleteTodoBtn', function(e){

			e.preventDefault();



			let id = $(this).data('id');

			if(confirm('Are you sure?')){

				$.ajax({

					url: `${todosIndexRoute}/${id}`,

					type: 'delete',
					data : { "_token": "{{ csrf_token() }}" }

				})

				.done(function(data) {

					if(data.status == 200){

						initTodos();

					}

				});




			}

		});



		$(document).on('submit', '#todosForm', function(event) {

			event.preventDefault();

			console.log("___");

			$.post('{{route('todos.store')}}', $(this).serialize(), function(data, textStatus, xhr) {

				console.log(data);
				console.log(textStatus);

				if(data.status == 200){
					console.log("___");
					initTodos();

				}

				$('#todoModal').modal('hide');

			});

		});



	});

</script>

@endpush
