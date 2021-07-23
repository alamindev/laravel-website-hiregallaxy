<!-- Sidebar -->
@php
$editor_access = [];
@endphp
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion custom__sidebar_show" id="accordionSidebar">



  <!-- Sidebar - Brand -->

  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.index') }}"> 
    

  </a>
 
  <!-- Divider -->

  <hr class="sidebar-divider my-0">



  <!-- Nav Item - Dashboard -->

  <li class="nav-item active">

    <a class="nav-link" href="{{ route('admin.index') }}">

      <i class="fas fa-fw fa-tachometer-alt"></i>

      <span>Dashboard</span></a>

  </li>

  @if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin')) 


<li

class="nav-item dropdown no-arrow {{ (

  Route::is('admin.category.index') || 

  Route::is('admin.states.index') || 

  Route::is('admin.cities.index') || 

  Route::is('admin.skill.index') || 

  Route::is('admin.experience.index') || 

  Route::is('admin.segment.index') || 

  Route::is('admin.discipline.index') || 

  Route::is('admin.sector.index')) ? 'show' : '' }}"> 
    <a class="nav-link {{ (Route::is('admin.sector.index')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse"

      data-target="#jobs" aria-expanded="true" aria-controls="jobs">
 
      <i class="fas fa-sliders-h"></i>  
      <span>Job Options</span> 
    </a>

    <div id="jobs" class="collapse {{ (Route::is('admin.job.index') ) ? 'show' : '' }}" aria-labelledby="headingTwo"

      data-parent="#accordionSidebar">

      <div class="bg-white py-2 collapse-inner rounded">

        <h6 class="collapse-header">Jobs Options</h6>

        <a class="dropdown-item" href="{{ route('admin.category.index') }}">Positions</a>

        <a class="dropdown-item" href="{{ route('admin.states.index') }}">States</a>
  
        <a class="dropdown-item" href="{{ route('admin.cities.index') }}">Cities</a>
  
        <a class="dropdown-item" href="{{ route('admin.skill.index') }}">Skills</a>
  
        <a class="dropdown-item" href="{{ route('admin.experience.index') }}">Experience</a>
  
        <a class="dropdown-item" href="{{ route('admin.segment.index') }}">Employer</a>
  
        <a class="dropdown-item" href="{{ route('admin.discipline.index') }}">Disciplines</a>
  
        <a class="dropdown-item" href="{{ route('admin.sector.index') }}">Sectors</a> 

      </div>

    </div>

  </li> 
  @endif 

     @if(auth()->user()->hasRole('super-admin'))


<li

class="nav-item dropdown no-arrow {{ (Route::is('admin.job.index')) ? 'show' : '' }}"> 
    <a class="nav-link {{ (Route::is('admin.job.index')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse"

      data-target="#managejobs" aria-expanded="true" aria-controls="managejobs"> 
      <i class="fas fa-users-cog"></i>
      <span>Manage Jobs</span> 
    </a>

    <div id="managejobs" class="collapse {{ (Route::is('admin.job.index') ) ? 'show' : '' }}" aria-labelledby="headingTwo"

      data-parent="#accordionSidebar">

      <div class="bg-white py-2 collapse-inner rounded">

        <h6 class="collapse-header">Jobs Options</h6>

        <a class="dropdown-item" href="{{ route('admin.job.index') }}">All Jobs</a> 

      </div>

    </div>

  </li> 
  @endif 

  @if(!auth()->user()->hasRole('editor'))


<li

class="nav-item dropdown no-arrow {{ (Route::is('admin.users.candidates') || Route::is('admin.users.employers')) ? 'show' : '' }}"> 
    <a class="nav-link {{ (Route::is('admin.users.candidates')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse"

      data-target="#Users" aria-expanded="true" aria-controls="Users"> 
      <i class="fas fa-users-cog"></i>
      <span>Users</span> 
    </a>

    <div id="Users" class="collapse" aria-labelledby="headingTwo"

      data-parent="#accordionSidebar">

      <div class="bg-white py-2 collapse-inner rounded">

        <h6 class="collapse-header">Users</h6>

        @if(auth()->user()->hasRole('super-admin'))

        <a class="dropdown-item" href="{{ route('admin.users.candidates') }}">Candidates</a>

        <a class="dropdown-item" href="{{ route('admin.users.employers') }}">Employers</a>

        @endif

        @if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin'))

        <a class="dropdown-item" href="{{ route('admin.account.index') }}">Admins</a>

        @endif

      </div>

    </div>

  </li> 
  @endif 

  @if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin'))


<li

class="nav-item dropdown no-arrow {{ (Route::is('admin.question.index') || Route::is('admin.personality.index') || Route::is('admin.personality.question.index')) ? 'show' : '' }}"> 
    <a class="nav-link {{ (Route::is('admin.question.index')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse"

      data-target="#Test" aria-expanded="true" aria-controls="Test"> 
      <img width="20" src="{{asset('/public/uploads/icon.png')}}" alt="">
      <span>Test</span> 
    </a>

    <div id="Test" class="collapse" aria-labelledby="headingTwo"

      data-parent="#accordionSidebar">

      <div class="bg-white py-2 collapse-inner rounded">

        <h6 class="collapse-header">Test</h6>

        
        <a class="dropdown-item" href="{{ route('admin.question.index') }}">Questions - job skill</a>

        @if(auth()->user()->hasRole('super-admin'))

          <a class="dropdown-item" href="{{ route('admin.personality.question.index') }}">Questions - personality</a>

          <a class="dropdown-item" href="{{ route('admin.personality.index') }}">Personality Type</a>

        @endif

        <a class="dropdown-item" href="{{ route('admin.aptitude.index') }}">Questions - Aptitude</a>

      </div>

    </div>

  </li> 
  @else

  @if(isset($editor_access))
      @if(count($editor_access) > 0)

      <li

      class="nav-item dropdown no-arrow {{ (Route::is('admin.question.index') || Route::is('admin.personality.index') || Route::is('admin.personality.question.index')) ? 'show' : '' }}"> 
          <a class="nav-link {{ (Route::is('admin.question.index')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
      
            data-target="#Test" aria-expanded="true" aria-controls="Test"> 
            <img width="20" src="{{asset('/public/uploads/icon.png')}}" alt="">
            <span>Test</span> 
          </a>
      
          <div id="Test" class="collapse" aria-labelledby="headingTwo"
      
            data-parent="#accordionSidebar">
      
            <div class="bg-white py-2 collapse-inner rounded">
      
              <h6 class="collapse-header">Test</h6>
      
              
          @foreach($editor_access as $access) 

          @if($access == 'skill')

            <a class="dropdown-item" href="{{ route('admin.question.index') }}">Questions - job skill</a> 

          @endif

          @if($access == 'personality') 

            <a class="dropdown-item" href="{{ route('admin.personality.question.index') }}">Questions - personality</a> 

            <a class="dropdown-item" href="{{ route('admin.personality.index') }}">Personality Type</a> 

          @endif

          @if($access == 'aptitude')

          <a class="dropdown-item" href="{{ route('admin.aptitude.index') }}">Questions - Aptitude</a>

          @endif

        @endforeach
            </div>
      
          </div>
      
        </li> 
      @endif
  @endif 
  @endif 

  @if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin'))
  <li

  class="nav-item dropdown no-arrow {{ (Route::is('admin.templates.index') || Route::is('admin.templates.edit') || Route::is('admin.templates.show') || Route::is('admin.templates.create')) ? 'show' : '' }}"> 
      <a class="nav-link {{ (Route::is('admin.templates.index')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
  
        data-target="#Templates" aria-expanded="true" aria-controls="Templates"> 
        <i class="fas fa-layer-group"></i>
        <span>Job Templates</span> 
      </a>
  
      <div id="Templates" class="collapse" aria-labelledby="headingTwo"
  
        data-parent="#accordionSidebar">
  
        <div class="bg-white py-2 collapse-inner rounded">
  
          <h6 class="collapse-header">Templates</h6>
  
          <a class="dropdown-item" href="{{ route('admin.templates.index') }}">All Templates</a>

          <a class="dropdown-item" href="{{ route('admin.templates.create') }}">Add New Template</a>
        </div>
  
      </div>
  
    </li> 
    @else

    @foreach($editor_access as $access) 

        @if($access == 'template')
        <li

        class="nav-item dropdown no-arrow {{ (Route::is('admin.templates.index') || Route::is('admin.templates.edit') || Route::is('admin.templates.show') || Route::is('admin.templates.create')) ? 'show' : '' }}"> 
            <a class="nav-link {{ (Route::is('admin.templates.index')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
        
              data-target="#Templates" aria-expanded="true" aria-controls="Templates"> 
              <i class="fas fa-layer-group"></i>
              <span>Job Templates</span> 
            </a>
        
            <div id="Templates" class="collapse" aria-labelledby="headingTwo"
        
              data-parent="#accordionSidebar">
        
              <div class="bg-white py-2 collapse-inner rounded">
        
                <h6 class="collapse-header">Templates</h6>
        
                <a class="dropdown-item" href="{{ route('admin.templates.index') }}">All Templates</a>

                <a class="dropdown-item" href="{{ route('admin.templates.create') }}">Add New Template</a>

              </div>
        
            </div>
        
          </li> 
        @endif

        @endforeach
  @endif

  @if(auth()->user()->hasRole('super-admin'))
  <li

        class="nav-item dropdown no-arrow {{ (Route::is('admin.crawlers.index') || Route::is('admin.crawler_sites.index') || Route::is('admin.sites.assign') || Route::is('admin.sites.asignSiteList') || Route::is('admin.crawl.extractLinks') || Route::is('admin.crawl.extractLinks.store')) ? 'show' : '' }}"> 
            <a class="nav-link {{ (Route::is('admin.templates.index')) ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
        
              data-target="#crawlers" aria-expanded="true" aria-controls="crawlers"> 
              <i class="fas fa-layer-group"></i>
              <span>Jobs Crawlers</span> 
            </a>

    <div id="crawlers" class="collapse {{ (Route::is('admin.crawlers.index') ) ? 'show' : '' }}" aria-labelledby="headingTwo"

      data-parent="#accordionSidebar">

      <div class="bg-white py-2 collapse-inner rounded">

        <h6 class="collapse-header">Job Crawler</h6>

       
        <a class="dropdown-item" href="{{ route('admin.crawlers.index') }}">Add URL</a>

        <a class="dropdown-item" href="{{ route('admin.crawler_sites.index') }}">Add Site</a>

        <a class="dropdown-item" href="{{ route('admin.sites.assign') }}">Assign Site</a>

        <a class="dropdown-item" href="{{ route('admin.crawl.extractLinks') }}">Extract Links</a>

      </div>

    </div>

  </li> 
  @endif
  <li class="nav-item  {{ (Route::is('admin.settings.index')) ? 'show' : '' }}" >

    <a class="nav-link" href="{{ route('admin.settings.index') }}">

      <i class="fas fa-fw fa-cog"></i>

      <span>&nbsp;Settings</span></a>

  </li>
</ul>

<!-- End of Sidebar -->