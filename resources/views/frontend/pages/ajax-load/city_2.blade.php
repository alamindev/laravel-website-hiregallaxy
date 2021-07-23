
    <select name="cities" onchange="submitSearch()" id="cities" class="selectpicker city__showing" data-live-search="true">

        <option data-icon="fa fa-map-marker" value="all">All Locations</option>

        @foreach ($states as $state)
        @if(count($state->cities) > 0)
        <option value="" disabled style="font-weight: bolder;font-size: 16px;">

            {{ $state->name }}

        </option>

        @foreach ($state->cities as $countrySingle)

        <option value="{{ $countrySingle->name }}"

            {{ isset($urlName) && ($urlName == $countrySingle->name) ? 'selected' : '' }}>

			&nbsp;&nbsp; {{ $countrySingle->name }}

			({{ count(App\Models\Job::where('status_id', 1)->where('country_id', $countrySingle->id)->get()) }})
			
        </option>

        @endforeach
        @endif
        @endforeach

    </select>

    
<script>
 
    $('.selectpicker').selectpicker('refresh'); 
    
</script>