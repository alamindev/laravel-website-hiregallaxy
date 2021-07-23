@php

$_id = isset($todo) ? $todo->id : '';

$_title = isset($todo) ? $todo->title : '';

$_status = isset($todo) ? $todo->status : null;

@endphp

<input type="hidden" name="id" value="{{$_id}}">

<div class="form-group">

	<label>Title</label>

	<input class="form-control" type="text" id="todo_title" minlength="5" maxlength="150" name="title" value="{{$_title}}" required>
	<span class="text-muted" style="font-size: 12px" >CHARS MAX 150</span>
</div>



@if($_status !== null)

<div class="form-group">

	<label>Status</label>

	<select class="form-control" name="status">

		<option value="0" {{$_status == 0 ? 'selected' : ''}}>Pending</option>

		<option value="1" {{$_status == 1 ? 'selected' : ''}}>Completed</option>

	</select>

</div>

@endif
