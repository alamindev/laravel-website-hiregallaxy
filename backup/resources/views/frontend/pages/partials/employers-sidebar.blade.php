<!-- New -->
<div class="user-sidebar">		
	<div class="list-group">    
		<div id="wrapper" class="active">       
		    <ul  id="sidebar-wrapper">          
		    	<li class="sidebar-brand">           	
		    		<a id="menu-toggle" href="{{ route('employers.dashboard') }}" class="list-group-item list-group-item-action {{ Route::is('employers.dashboard') ? 'active' : '' }}">
		    			<i class="fa fa-dashboard"></i> Dashboard
		    		</a>                      
		    	</li>          
		    	<li>
		    		<a href="{{ route('employers.jobs.posted') }}" class="list-group-item list-group-item-action {{ Route::is('employers.jobs.posted') ? 'active' : '' }}">				
		    			<i class="fa fa-bell"></i> My Posted Jobs			
		    		</a>		
		    	</li>        
		    	<li>        	
		    		<a href="{{ route('employers.search.candidates') }}" class="list-group-item list-group-item-action {{ Route::is('employers.search.candidates') ? 'active' : '' }}">				
		    			<i class="fa fa-search"></i> Search Cadidates			
		    		</a>		
		    	</li>        
		    	<li>         
		    		<a href="{{ route('employers.messages') }}" class="list-group-item list-group-item-action {{ Route::is('employers.messages') ? 'active' : '' }}">				
		    			<i class="fa fa-envelope"></i> Messages			
		    		</a>        
		    	</li>        
		    	<li>        	
		    		<a href="{{ route('employers.show', $user->username) }}" class="list-group-item list-group-item-action">				
		    			<i class="fa fa-edit"></i> Edit My Profile			
		    		</a>        
		    	</li>        
		    </ul>           
		</div>	    
	</div> 
</div>