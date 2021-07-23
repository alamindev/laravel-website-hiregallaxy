<option value="">Select a city</option>
 
@foreach ($states as $state)
    @if(count($state->cities) > 0)
    <option value="" disabled style="font-weight: bolder;font-size: 16px;">

        {{ $state->name }}

    </option>

    @foreach ($state->cities as $country)

    <option  value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected':'' }}>

        &nbsp; &nbsp;

        {{ $country->name }}

    </option>

    @endforeach
    @endif

@endforeach