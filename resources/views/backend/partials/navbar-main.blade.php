<!-- Topbar -->

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow admin-navbar">



  <!-- Sidebar Toggle (Topbar) -->

  <button id="sidebarToggleTop" class="btn btn-link d-lg-none rounded-circle mr-3">

    <i class="fa fa-bars"></i>

  </button>



  <!-- Topbar Search -->

  {{--   <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">

    <div class="input-group">

      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">

      <div class="input-group-append">

        <button class="btn btn-primary" type="button">

          <i class="fas fa-search fa-sm"></i>

        </button>

      </div>

    </div>

  </form> --}}



  <!-- Topbar Navbar -->

  <ul class="navbar-nav navbar__custom">

    <a class="nav-link" href="{{ route('admin.index') }}" id="alertsDropdown" role="button" aria-expanded="false">

      <img src="{{ asset('images/'.App\Models\Setting::first()->site_logo) }}"

        style="width: 90px;margin-top: 0px;" class="float-left" alt="image" />



      <div class="sidebar-brand-text mx-3 mt-3 float-left" style="Display:none;">{{ App\Models\Setting::first()->site_title }}</div>

      <div class="sidebar-brand-text mx-3 mt-3 float-left" ></div>



      <div class="clearfix"></div>

    </a>



    @if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin'))



    <li

      class="nav-item dropdown no-arrow {{ (

        Route::is('admin.category.index') || 

        Route::is('admin.states.index') || 

        Route::is('admin.cities.index') || 
        Route::is('admin.country.index') || 

        Route::is('admin.skill.index') || 

        Route::is('admin.experience.index') || 

        Route::is('admin.segment.index') || 

        Route::is('admin.discipline.index') || 

        Route::is('admin.sector.index')) ? 'show' : '' }}">

      <a class="nav-link dropdown-toggle" href="#" id="jobs_settings" role="button" data-toggle="dropdown"

        aria-haspopup="true" aria-expanded="false" >

        <i class="fas fa-sliders-h"></i> &nbsp;&nbsp;Job Options

      </a>

      <div class="dropdown-menu shadow animated--grow-in" aria-labelledby="jobs_settings" style="width: 12rem !important">

        <a class="dropdown-item" href="{{ route('admin.sponsor.index') }}">Sponsors</a>

        <a class="dropdown-item" href="{{ route('admin.subscriber.index') }}">Subscribers</a>
        
        <a class="dropdown-item" href="{{ route('admin.category.index') }}">Positions</a>

        <a class="dropdown-item" href="{{ route('admin.states.index') }}">States</a>

        <a class="dropdown-item" href="{{ route('admin.cities.index') }}">Cities</a>
        <a class="dropdown-item" href="{{ route('admin.country.index') }}">Countries</a>

        <a class="dropdown-item" href="{{ route('admin.skill.index') }}">Skills</a>

        <a class="dropdown-item" href="{{ route('admin.experience.index') }}">Experience</a>

        <a class="dropdown-item" href="{{ route('admin.segment.index') }}">Employer</a>

        <a class="dropdown-item" href="{{ route('admin.discipline.index') }}">Disciplines</a>

        <a class="dropdown-item" href="{{ route('admin.sector.index') }}">Sectors</a> 

      </div>

    </li>

@endif 

    @if(auth()->user()->hasRole('super-admin'))

    <li

      class="nav-item dropdown no-arrow {{ (Route::is('admin.job.index')) ? 'show' : '' }}">

      <a class="nav-link dropdown-toggle" href="#" id="candidates" role="button" data-toggle="dropdown"

        aria-haspopup="true" aria-expanded="false" >

        <i class="fas fa-users-cog"></i> &nbsp;&nbsp;Manage Jobs

      </a>

      <div class="dropdown-menu shadow animated--grow-in" aria-labelledby="candidates">

 

        <a class="dropdown-item" href="{{ route('admin.job.index') }}">All Jobs</a> 

   

      </div>

    </li>

    @endif

    @if(!auth()->user()->hasRole('editor'))

    <li

      class="nav-item dropdown no-arrow {{ (Route::is('admin.users.candidates') || Route::is('admin.users.employers')) ? 'show' : '' }}">

      <a class="nav-link dropdown-toggle" href="#" id="candidates" role="button" data-toggle="dropdown"

        aria-haspopup="true" aria-expanded="false" >

        <i class="fas fa-users-cog"></i> &nbsp;&nbsp;Users

      </a>

      <div class="dropdown-menu shadow animated--grow-in" aria-labelledby="candidates">

        @if(auth()->user()->hasRole('super-admin'))

        <a class="dropdown-item" href="{{ route('admin.users.candidates') }}">Candidates</a>

        <a class="dropdown-item" href="{{ route('admin.users.employers') }}">Employers</a>

        @endif

        @if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin'))

        <a class="dropdown-item" href="{{ route('admin.account.index') }}">Admins</a>

        @endif

      </div>

    </li>

  @endif

    @if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin'))

    <li

      class="nav-item dropdown no-arrow {{ (Route::is('admin.question.index') || Route::is('admin.personality.index') || Route::is('admin.personality.question.index')) ? 'show' : '' }}">

      <a class="nav-link dropdown-toggle" href="#" id="test" role="button" data-toggle="dropdown"

        aria-haspopup="true" aria-expanded="false" >

        <img width="20" src="{{asset('/public/uploads/icon.png')}}" alt="image"> &nbsp;&nbsp;Test

      </a>

      <div class="dropdown-menu shadow animated--grow-in" aria-labelledby="test" style="width: 200px">

        <a class="dropdown-item" href="{{ route('admin.question.index') }}">Questions - job skill</a>

        @if(auth()->user()->hasRole('super-admin'))

          <a class="dropdown-item" href="{{ route('admin.personality.question.index') }}">Questions - personality</a>

          <a class="dropdown-item" href="{{ route('admin.personality.index') }}">Personality Type</a>

        @endif

        <a class="dropdown-item" href="{{ route('admin.aptitude.index') }}">Questions - Aptitude</a>

      </div>

    </li>

    @else

      @if(count($editor_access) > 0)

        <li

        class="nav-item dropdown no-arrow {{ (Route::is('admin.question.index') || Route::is('admin.personality.index') || Route::is('admin.personality.question.index')) ? 'show' : '' }}">

        <a class="nav-link dropdown-toggle" href="#" id="test" role="button" data-toggle="dropdown"

          aria-haspopup="true" aria-expanded="false" >

          <img width="20" src="{{asset('/public/uploads/icon.png')}}" alt="image"> &nbsp;&nbsp;Test

        </a>

        <div class="dropdown-menu shadow animated--grow-in" aria-labelledby="test" style="width: 200px">

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

      </li>

      @endif

    @endif

    @if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin'))

    <li

      class="nav-item dropdown no-arrow {{ (Route::is('admin.templates.index') || Route::is('admin.templates.edit') || Route::is('admin.templates.show') || Route::is('admin.templates.create')) ? 'show' : '' }}">

      <a class="nav-link dropdown-toggle" href="#" id="templates" role="button" data-toggle="dropdown"

        aria-haspopup="true" aria-expanded="false" >

        <i class="fas fa-layer-group"></i> &nbsp;&nbsp;Job Templates

      </a>

      <div class="dropdown-menu shadow animated--grow-in" aria-labelledby="templates">

        <a class="dropdown-item" href="{{ route('admin.templates.index') }}">All Templates</a>

        <a class="dropdown-item" href="{{ route('admin.templates.create') }}">Add New Template</a>

      </div>

    </li>

    @else

          @foreach($editor_access as $access) 

              @if($access == 'template')

                  <li

                  class="nav-item dropdown no-arrow {{ (Route::is('admin.templates.index') || Route::is('admin.templates.edit') || Route::is('admin.templates.show') || Route::is('admin.templates.create')) ? 'show' : '' }}">

                  <a class="nav-link dropdown-toggle" href="#" id="templates" role="button" data-toggle="dropdown"

                    aria-haspopup="true" aria-expanded="false" >

                    <i class="fas fa-layer-group"></i> &nbsp;&nbsp;Job Templates

                  </a>

                  <div class="dropdown-menu shadow animated--grow-in" aria-labelledby="templates">

                    <a class="dropdown-item" href="{{ route('admin.templates.index') }}">All Templates</a>

                    <a class="dropdown-item" href="{{ route('admin.templates.create') }}">Add New Template</a>

                  </div>

                </li>

            @endif

        @endforeach

    @endif

    @if(auth()->user()->hasRole('super-admin'))

    <li

      class="nav-item dropdown no-arrow {{ (Route::is('admin.crawlers.index') || Route::is('admin.crawler_sites.index') || Route::is('admin.sites.assign') || Route::is('admin.sites.asignSiteList') || Route::is('admin.crawl.extractLinks') || Route::is('admin.crawl.extractLinks.store')) ? 'show' : '' }}">

      <a class="nav-link dropdown-toggle" href="#" id="crawlers" role="button" data-toggle="dropdown"

        aria-haspopup="true" aria-expanded="false">

        <i class="fas fa-fw fa-tasks"></i> &nbsp;Job Crawler

      </a>

      <div class="dropdown-menu shadow animated--grow-in" aria-labelledby="crawlers">

        <a class="dropdown-item" href="{{ route('admin.crawlers.index') }}">Add URL</a>

        <a class="dropdown-item" href="{{ route('admin.crawler_sites.index') }}">Add Site</a>

        <a class="dropdown-item" href="{{ route('admin.sites.assign') }}">Assign Site</a>

        <a class="dropdown-item" href="{{ route('admin.crawl.extractLinks') }}">Extract Links</a>

      </div>

    </li>



  



      <li class="nav-item  {{ (Route::is('admin.settings.index')) ? 'show' : '' }}" >

        <a class="nav-link" href="{{ route('admin.settings.index') }}">

          <i class="fas fa-fw fa-cog"></i>

          <span>&nbsp;Settings</span></a>

      </li>
     

 

    @endif

  </ul>

  <ul class="navbar-nav ml-auto">



    <li class="nav-item" >

      <a class="nav-link" href="{{ route('index') }}" id="alertsDropdown" role="button" aria-expanded="false"

        target="_blank">

        <i class="fas fa-eye fa-fw"></i><span class="view__site">View Site</span>

      </a>

    </li>   







    <!-- Nav Item - User Information -->

    <li class="nav-item dropdown no-arrow">

      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"

        aria-haspopup="true" aria-expanded="false">

        <!--<span class="mr-2 d-none d-lg-inline text-gray-600 small" style="Display:none;">{{ Auth::guard('admin')->user()->first_name }}</span>-->

        <img class="img-profile rounded-circle" alt="image"

          src="{{ App\Helpers\ReturnPathHelper::getAdminImage(Auth::guard('admin')->user()->id) }}">

      </a>

      <!-- Dropdown - User Information -->

      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

    

      <a class="dropdown-item" href="{{ route('admin.account.view', auth()->user()->id) }}">

          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>

          Profile

        </a>

        <div class="dropdown-divider"></div>

    <a class="dropdown-item" href="#changePasswordModal" data-toggle="modal">

          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>

          Change Email/Password

        </a>

        <a href="{{ route('admin.logout') }}" class="dropdown-item notify-item"

          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout

        </a>



        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">

          @csrf

        </form>



      </div>

    </li>



  </ul>



</nav>

<!-- End of Topbar -->







<!-- Change Password Modal -->

<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"

  aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Change Admin Email/Password</h5>

        <button class="close" type="button" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">×</span>

        </button>

      </div>

      <div class="modal-body">

        <form class="" action="{{ route('admin.password.change') }}" method="post" data-parsley-validate>

          @csrf

          <label>New Email:</label> <br>

          <input type="email" name="email" id="email" placeholder="New Email" class="form-control"

            value="{{ Auth::guard('admin')->user()->email }}" required />
            
          <input hidden="hidden" type="hidden" name="user_id" id="user_id" class="form-control"

            value="{{ Auth::guard('admin')->user()->id }}" required />
            
            

          <br>



          <label>New Password:</label> <br>

          <div class="row">

            <div class="col-md-6">

              <input type="password" name="password" id="password" placeholder="New Password" class="form-control" minlength="8" required />

            </div>

            <div class="col-md-6">

              <input type="password" name="password_confirmation"data-parsley-equalto="#password" id="password_confirmation" placeholder="Confirm New Password" class="form-control"  minlength="8" required />

            </div>

          </div>



          <button type="submit" class="btn btn-success btn-block btn-sm mt-3">

            <i class="fa fa-check"></i> Change Email/Password</button>

        </form>

      </div>

    </div>

  </div>

</div>

<!-- Change Password Modal -->

