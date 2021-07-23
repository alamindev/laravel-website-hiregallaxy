@foreach($top_job_cate as $data)
<li><a href="{{ route('jobs.search', ['job' => '', 'category'=> $data->slug]) }}">{{ $data->name }}</a></li> 
@endforeach