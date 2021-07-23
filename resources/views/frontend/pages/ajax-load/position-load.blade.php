<div class="my-4">	
    <select name="category" onchange="submitSearch()"  id="category" class="selectpicker" data-live-search="true" >

        <option data-icon="fa fa-navicon" value="all">All Positions</option> 
        @foreach ($categories as $cat) 
            <option  value="{{ $cat->slug }}" {{ isset($_GET['category']) && ($_GET['category'] == $cat->slug) ? 'checked' : '' }}>	 	{{ $cat->name }}</option>
        @endforeach

    </select> 
</div>

<script>
 
    $('.selectpicker').selectpicker('refresh'); 
    
</script>