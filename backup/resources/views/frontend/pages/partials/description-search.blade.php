
	<div class="sidebar-widget">

		<div class="sidebar-list-item">

			<h3>

				Job description by postion

			</h3>

			<hr class="sidebar-border">

			<div class="clearfix"></div>
			<select name="category"  id="categorys" class="selectpicker" data-live-search="true" onchange="submitSearch()">

				<option data-icon="fa fa-navicon" value="all" selected>All Postions</option>

				@foreach (App\Models\Category::orderBy('name', 'asc')->get() as $cat)

				<option value="{{ $cat->slug }}">{{ $cat->name }}</option>

				@endforeach

			</select> 
		 
		</div>

	</div> 

