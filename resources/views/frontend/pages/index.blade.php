@extends('frontend.layouts.master')
@section('title')
{{ App\Models\Setting::first()->site_title }} | home
@endsection
@section('stylesheets')
@endsection
@section('content')
 

<!-- Popular Positions Area -->
 
 
@if(count($sponsors) > 0)
<!-- Footer Section -->
<section class="em_partnar_bg">
    <h2 class="text-center">Our Partnars</h2>
    
    <div class="brand-carousel section-padding owl-carousel">
        
    @foreach($sponsors as $sponsor)
          <div class="single-logo">
              <a href="{{$sponsor->link}}" target="_blank">
                  <img src="{!! asset('images/sponsors/'.$sponsor->image) !!}" alt="{{$sponsor->name}}" class="cus_owl_img">
              </a>
          </div>
    @endforeach

    </div>
</section>
<!-- Footer Section -->
@endif

<section class="trending_job_cetegory" >
	<div class="container">
		<div class="row  wow zoomIn">
			<div class="col-lg-12">
				<h2 class="trending__title">Trending jobs 
				</h2>
				<ul class="trending__tag">
					
				</ul>
			</div> 
		</div> 
		<div class="row custom--section-main pd-t-40">
			<div class="col-lg-6  wow fadeInUp">
				 <img class="img-fluid" src="{{ asset('images/new-img/candidate.png') }}" alt="candidate">
			</div> 
			<div class="col-lg-6 wow fadeInUp">
				 <div class="custom--new-section">
				 	<img src="{{ asset('images/new-img/people.png') }}" alt="people">
					 <h2>Candidate</h2>
					 <h3>Crate a praofessional CV in three steps</h3>
					 <p>The problem of using expensive software to make an eye catching CV is solved. Now leave all these worry, you can crate a 
							professional CV in three steps and share to unlimited recruiters for free.</p>
					<div class="custom--list">
						<span>1. Register</span>
						<span>2. Fill details</span>
						<span>3. Generate pdf file</span>
					</div>
				 </div>
			</div> 
		</div> 
	</div> 
</section>

<section class="personality--aptitude-main" >
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				 <div class="row  wow fadeInUp	">
						<div class="col-lg-6  ">
							<div class="common-div">
								<img src="{{ asset('/images/new-img/personality.png') }}" alt="personality">
								<h2>Personality</h2>
								<p>Take online personality test for free. When you apply for a job , the details will be shared to recruiters for free!!</p>
							</div>
						</div>
						<div class="col-lg-6  ">
							<div class="common-div">
								<img src="{{ asset('/images/new-img/aptitude.png') }}" alt="aptitude">
								<h2>Aptitude</h2>
								<p>Take online aptitude test for free. When you apply for a job , the details will be shared to recruiters for free!!</p>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div> 
</section>
 
<section class="bg-white em_pb_50">
	<div class="container">
	 	<div class="row custom--section-main  wow fadeInUp">
			<div class="col-lg-6 ">
				<img class="img-fluid" src="{{ asset('images/new-img/employer.png') }}" alt="employer">
			</div> 
			<div class="col-lg-6 ">
				<div class="custom--new-section">
					<img src="{{ asset('images/new-img/people-two.png') }}" alt="people two">
					<h2>Employer</h2>
					<h3>The problem of screening hundreds of 
candidates is solved</h3>
					<p>Received PRESCREENED candidate to your ATS dashboard. Our simple process of screening candidate is very effective. Joblrs automatic candidate screening process perform following tests online and provide employer with top candidate.</p>
					<div class="custom--list">
						<span>1. Aptitude test</span>
						<span>2. Personality test</span>
						<span>3. Job skill test</span>
					</div>
				</div>
			</div> 
	</div> 
</div>
</section>

<section class="bg-white py-5 em_bg_home">
	<div class="container">
	 	<div class="row custom--section-main  wow fadeInUp">
			<div class="col-lg-6">
				<img class="img-fluid" src="{{ asset('images/new-img/recruiter.png') }}" alt="recruiter">
			</div> 
			<div class="col-lg-6">
				<div class="custom--new-section">
				    <!--<br><br>-->
					<img src="{{ asset('images/new-img/list.png') }}" alt="list">
					<h2>Recruiter</h2>
					<h3>The problem of managing multiple recruitment 
team at different location is no more a point of 
worry for recruitment agency</h3>
					<p>In Joblrs platform recruiter can add multiple team and monitor their performance.</p>
					
				</div>
			</div> 
	</div> 
</div>
</section>

<section class="em_bg_sec">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <img class="img-fluid em_img" src="{{ asset('images/new-img/chart.png') }}" alt="chart">
            </div>
        </div>
    </div>
</section>


<section class="subscribe">
  <div class="container">
    <div class="section-header">
      <h2>Newsletter</h2>
      <p>Subscribe by your Email to get notification first from Joblrs.</p>
    </div>

    <form>
      <div class="form-row justify-content-center">
        <div class="col-auto">
                
          @csrf
          <input id="email" type="email" name="email" class="form-control" placeholder="Enter your Email" required="required">
          
        </div>
        <div class="col-auto">
          <button id="btnSave">Subscribe</button>
        </div>
      </div>
    </form>

  </div>
</section>

<section class="bg-white py-5 question--answer-area">
		<div class="container">
		 	<div class="row wow fadeInUp">
				<div class="col-lg-12">
					<div class="d-flex flex-column align-items-center question--answer-header">
							<img src="{{ asset('images/new-img/list.png') }}" alt="list">
							<h2>Questions? Look here.</h2>
							<p>Can’t find answer? initiate a quick <a href={{ route('messages') }}>chat</a> or email us <a href="mailto:info@joblrs.com">info@joblrs.com</a>
</p>
					</div>
					<div class="tab--area">
						<ul class="list-unstyled m-0 p-0">
							<li data-tab="tab-1" class="current">General</li>
							<li data-tab="tab-2">Job Posting</li>
							<li data-tab="tab-3">Features</li>
							<li data-tab="tab-4">Carrea Page</li>
						</ul>
					</div>

					<div class="tab-area-main">
						<div class="tab-content current" id="tab-1">
							<div class="accordion-container"> 
								<div class="set">
									<a href="javascript:void(0)">What is Joblrs?<i class="fa fa-plus"></i> </a>
									<div class="content">
										<p>Joblrs is an all-in-one recruitment software where you can post jobs, review applications, shortlist candidates, schedule interviews and hire, all at once place. Joblrs is the most easiest applicant tracking system and professional level CV built up software.</p>
									</div>
								</div> 
								<div class="set">
									<a href="javascript:void(0)">Is my data is safe? <i class="fa fa-plus"></i> </a>
									<div class="content">
										<p>Yes , we have implemented SSL certificate on the site for your data project. However we recommend not to share any sensitive personal information’s with employer or recruiter.</p>
									</div>
								</div> 
								<div class="set">
									<a href="javascript:void(0)">What is an application tracking system? <i class="fa fa-plus"></i> </a>
									<div class="content">
										<p>An Applicant Tracking System or ATS is a cloud-based program whose basic function is to electronically automate the job posting, filtering applications, shortlisting, interview scheduling and hiring process.</p>
									</div>
								</div> 
								<div class="set">
									<a href="javascript:void(0)">Is Joblrs GDMR compliance? <i class="fa fa-plus"></i> </a>
									<div class="content">
										<p>No, we are not GDMR compliance at the movement however we aim to achieve soon.</p>
									</div>
								</div> 
							</div>
						</div>
						<div class="tab-content" id="tab-2">
							<div class="accordion-container"> 
								<div class="set">
									<a href="javascript:void(0)">How to post a Job on Joblrs? <i class="fa fa-plus"></i> </a>
									<div class="content">
										<p>Sign up on Joblrs and once your account is verified, click on “Post Jobs”, enter Job Title, Job Description, Required Skills, and other details. Then click on “Post Job”. Your job will be automatically posted.</p>
									</div>
								</div> 
								<div class="set">
									<a href="javascript:void(0)">Can I share jobs opening on social networks? <i class="fa fa-plus"></i> </a>
									<div class="content">
										<p>Yes, you can share jobs on LinkedIn, Twitter, Facebook, Instagram, and other social networks to get maximum exposure for your open positions.</p>
									</div>
								</div> 
								<div class="set">
									<a href="javascript:void(0)">How will I get notified if someone has applied to my job opening? <i class="fa fa-plus"></i> </a>
									<div class="content">
										<p>When an applicant applies to your job opening, you can check the application on your Joblrs dashboard under “Applications”. </p>
									</div>
								</div>  
							</div>
						</div>
						<div class="tab-content" id="tab-3">
							<div class="accordion-container"> 
								<div class="set">
									<a href="javascript:void(0)">How can I check/track candidates who have applied?<i class="fa fa-plus"></i> </a>
									<div class="content">
										<p>Under “Applications” you’ll see the list of candidates who have applied for your company’s various open positions. To check the information of a candidate, click on “View Detail”, and you’ll see all the information of the candidate including name, experience, and other details with CV.</p>
									</div>
								</div> 
								<div class="set">
									<a href="javascript:void(0)">How can I shortlist applicants? <i class="fa fa-plus"></i> </a>
									<div class="content">
										<p>Once you click on “View Details” of a particular applicant. You can shortlist the applicant from the option and the candidate will automatically be moved to “Shortlisted Candidates” section.</p>
									</div>
								</div> 
								<div class="set">
									<a href="javascript:void(0)">Manage recruiter team? <i class="fa fa-plus"></i> </a>
									<div class="content">
										<p>This is our unit feature on the Joblrs. Employer and recruitment manager can create a team of recruiter for different department or companies to manage job recruitment. Also employer can review their performance on weekly and monthly basis. </p>
									</div>
								</div>  
							</div>
						</div>
						<div class="tab-content" id="tab-4">
							<div class="accordion-container"> 
								<div class="set">
									<a href="javascript:void(0)">What is Branded Careers Page? <i class="fa fa-plus"></i> </a>
									<div class="content">
										<p>Coming soon</p>
									</div>
								</div>  
							</div>
						</div>
					</div>
				</div>
			</div> 
	</div>
</section>
   
@endsection 

@section('scripts') 

 
@endsection