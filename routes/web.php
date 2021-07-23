<?php

/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

 */

/*

|--------------------------------------------------------------------------

| Frontend Routes

|--------------------------------------------------------------------------

|

 */

Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    echo 'Done';
});

Route::post('ajax', 'Frontend\AjaxController@main')->name('ajax');

Route::get('/', 'Frontend\PagesController@index')->name('index');
Route::get('/terms-and-service', 'Frontend\PagesController@termsAndService')->name('terms');

Route::get('/privacy-policy', 'Frontend\PagesController@privacyPolicy')->name('privacy');
Route::get('/about-us', 'Frontend\PagesController@about_us')->name('about_us');
Route::get('/search', 'HomeController@searches')->name('searches');
Route::get('/candidates/personality/{id}', 'Frontend\EmployersController@Personality')->name('public.personality');

Route::get('/job-description', 'Frontend\JobsController@Description')->name('description');
Route::get('/job-description/view/{id}', 'Frontend\JobsController@JobDescription')->name('jobDescription');
Route::get('job-description/search', 'Frontend\JobsController@searchJobDescription')->name('description.search');
Route::get('testimonials', 'HomeController@Testimonial')->name('testimonial');
/*** Employers **/

Route::group(['prefix' => 'employers'], function () {
    Route::get('/search', 'Frontend\EmployersController@search')->name('employers.search');
    Route::get('', 'Frontend\EmployersController@index')->name('employers');
    Route::get('/view/{username}', 'Frontend\EmployersController@show')->name('employers.show');

    Route::group(['middleware' => ['checkTeam', 'checkEmployer']], function () {
        // todos routes

        Route::get('todos/get', 'Frontend\TodosController@getAll')->name('todos.getAll');

        Route::post('todos/toggle/{id}', 'Frontend\TodosController@toggleTodo')->name('todos.toogle');

        Route::resource('todos', 'Frontend\TodosController');

        // About

        Route::post('/about/update/{id}', 'Frontend\EmployersController@updateAbout')->name('employers.about.update');

        Route::post('/profile/update/{id}', 'Frontend\EmployersController@updateProfile')->name('employers.profile.update');

        Route::post('/applicants/update/{id}', 'Frontend\EmployersController@applicantUpdate')->name('employers.applicants.update');

        Route::get('/dashboard', 'Frontend\EmployersController@dashboard')->name('employers.dashboard');

        // Change password
        
        Route::post('/employer-password-change', 'Frontend\EmployersController@passwordChangeUpdate')->name('employers.password-change');
        Route::get('/employer-change-password', 'Frontend\EmployersController@changePassword')->name('employers.change-password');
        

        Route::get('/applicants', 'Frontend\EmployersController@applicants')->name('employers.applicants');

        Route::get('/edit/{id}', 'Frontend\EmployersController@applicantEdit')->name('employers.applicants.edit');

        Route::get('/search-candidates', 'Frontend\EmployersController@searchCadidates')->name('employers.search.candidates');

        Route::get('/posted-jobs', 'Frontend\EmployersController@postedJobs')->name('employers.jobs.posted');

        Route::get('/listed-jobs/{status}', 'Frontend\EmployersController@listedJobs')->name('employers.jobs.listed');

        Route::post('/posted-jobs/delete/{slug}', 'Frontend\EmployersController@deleteJob')->name('employers.jobs.delete');

        Route::get('{slug}/applications', 'Frontend\EmployersController@jobApplications')->name('employers.jobs.applications');

        Route::get('/{status}/listed-applicants/{slug}', 'Frontend\EmployersController@applicantList')->name('employers.listed');

        Route::get('/candidate/{status}', 'Frontend\EmployersController@candidatesDisplay')->name('employers.candidate');

        Route::get('/total', 'Frontend\EmployersController@totalApplications')->name('employers.total');

        // Route::get('/messages', 'Frontend\EmployersController@messages')->name('employers.messages');

        Route::group(['prefix' => 'teams'], function () {
            Route::get('', 'Frontend\TeamController@index')->name('teams');
            Route::get('/create', 'Frontend\TeamController@create')->name('team.create');
            Route::post('/store', 'Frontend\TeamController@store')->name('team.store');
            Route::get('/delete/{id}/{status}', 'Frontend\TeamController@destroy')->name('team.delete');
        });
        Route::group(['prefix' => 'companies'], function () {
            Route::get('', 'Frontend\CompanyController@index')->name('companies');
            Route::get('/create', 'Frontend\CompanyController@create')->name('company.create');
            Route::post('/store', 'Frontend\CompanyController@store')->name('company.store');
            Route::get('/show/{id}', 'Frontend\CompanyController@show')->name('company.show');
            Route::get('/edit/{id}', 'Frontend\CompanyController@edit')->name('company.edit');
            Route::post('/update/{id}', 'Frontend\CompanyController@update')->name('company.update');
            Route::get('/delete/{id}', 'Frontend\CompanyController@destroy')->name('company.delete');
        });
    });
});

Route::group(['prefix' => 'team'], function () {
    Route::get('{id?}/dashboard/', 'Frontend\TeamController@dashboard')->name('team.dashboard');
    Route::get('/view/{username}', 'Frontend\TeamController@showProfile')->name('team.show');
    Route::post('/profile/update/{id}', 'Frontend\TeamController@updateProfile')->name('team.profile.update');
    // todos routes
    Route::get('todos/get', 'Frontend\TodosController@getAll')->name('todos.getAll');
    Route::post('todos/toggle/{id}', 'Frontend\TodosController@toggleTodo')->name('todos.toogle');
    Route::resource('todos', 'Frontend\TodosController');

    Route::get('{id}/posted-jobs', 'Frontend\TeamController@postedJobs')->name('team.jobs.posted');
    Route::get('{id}/applications/{slug}', 'Frontend\TeamController@jobApplications')->name('team.jobs.applications');
    Route::get('{id}/total', 'Frontend\TeamController@totalApplications')->name('team.total');
    Route::get('{id}/candidate/{status}', 'Frontend\TeamController@candidatesDisplay')->name('team.candidate');
    Route::get('/messages', 'Frontend\TeamController@messages')->name('team.messages');
    Route::get('/search-candidates', 'Frontend\TeamController@searchCadidates')->name('team.search.candidates');
    Route::get('{id}/companies', 'Frontend\TeamController@Companies')->name('team.companies');
    Route::get('/company/{id}/show', 'Frontend\TeamController@CompanyShow')->name('team.company.show');
});

/*** candidates **/

Route::group(['prefix' => 'candidates'], function () {

    Route::get('', 'Frontend\CandidatesController@index')->name('candidates');

    Route::get('/view/{username}', 'Frontend\CandidatesController@show')->name('candidates.show');

    Route::get('/view-resume/{username}', 'Frontend\CandidatesController@showResume')->name('candidates.showResume');

    Route::get('/search', 'Frontend\CandidatesController@search')->name('candidates.search');

    Route::group(['middleware' => ['checkCandidate']], function () {
        
        // Change password
        
        Route::post('/password-change', 'Frontend\CandidatesController@passwordChangeUpdate')->name('candidates.password-change');
        
        Route::get('/change-password', 'Frontend\CandidatesController@changePassword')->name('candidates.change-password');
        
        // Experience

        Route::post('/add-experience', 'Frontend\ExperiencesController@store')->name('candidates.experience.store');

        Route::post('/update-experience/{id}', 'Frontend\ExperiencesController@update')->name('candidates.experience.update');

        Route::post('/delete-experience/{id}', 'Frontend\ExperiencesController@destroy')->name('candidates.experience.delete');

        // Education

        Route::post('/add-education', 'Frontend\EducationsController@store')->name('candidates.education.store');

        Route::post('/update-education/{id}', 'Frontend\EducationsController@update')->name('candidates.education.update');

        Route::post('/delete-education/{id}', 'Frontend\EducationsController@destroy')->name('candidates.education.delete');

        // Awards

        Route::post('/add-award', 'Frontend\AwardsController@store')->name('candidates.award.store');

        Route::post('/update-award/{id}', 'Frontend\AwardsController@update')->name('candidates.award.update');

        Route::post('/delete-award/{id}', 'Frontend\AwardsController@destroy')->name('candidates.award.delete');

        // Skills

        Route::post('/add-skill', 'Frontend\SkillsController@store')->name('candidates.skill.store');

        Route::post('/update-skill/{id}', 'Frontend\SkillsController@update')->name('candidates.skill.update');

        Route::post('/delete-skill/{id}', 'Frontend\SkillsController@destroy')->name('candidates.skill.delete');

        // Portfolio

        Route::post('/addportfolio', 'Frontend\PortfoliosController@store')->name('candidates.portfolio.store');

        Route::post('/update-portfolio/{id}', 'Frontend\PortfoliosController@update')->name('candidates.portfolio.update');

        Route::post('/delete-portfolio/{id}', 'Frontend\PortfoliosController@destroy')->name('candidates.portfolio.delete');

        // About

        Route::post('/about/update/{id}', 'Frontend\CandidatesController@updateAbout')->name('candidates.about.update');

        Route::post('/profile/update/{id}', 'Frontend\CandidatesController@updateProfile')->name('candidates.profile.update');

        Route::get('/dashboard', 'Frontend\CandidatesController@dashboard')->name('candidates.dashboard');

        Route::get('/personality', 'Frontend\CandidatesController@Personality')->name('candidates.personality');

        Route::group(['prefix' => 'personality'], function () {

            Route::get('/test/{id}', 'Frontend\PersonalityController@index')->name('personality');

            Route::get('/questions/{id}', 'Frontend\PersonalityController@questions');

            Route::post('/result', 'Frontend\PersonalityController@Results');

            Route::get('/check-status', 'Frontend\PersonalityController@examStatus');

        });

        Route::group(['prefix' => 'aptitude'], function () {

            Route::get('/test/{id}', 'Frontend\AptitudeResultController@index')->name('aptitude');

            Route::get('/questions/{id}', 'Frontend\AptitudeResultController@questions');

            Route::post('/questions/results', 'Frontend\AptitudeResultController@Results');

            Route::get('/check-status', 'Frontend\AptitudeResultController@examStatus');

        });

        // Route::get('/messages', 'Frontend\CandidatesController@messages')->name('candidates.messages');

        Route::get('/favorite-jobs', 'Frontend\CandidatesController@favoriteJobs')->name('candidates.jobs.favorite');

        Route::get('/applied-jobs', 'Frontend\CandidatesController@appliedJobs')->name('candidates.jobs.applied');
        
    });

});

/*** contacts **/

Route::get('/contact-us', 'Frontend\ContactsController@index')->name('contacts');

Route::post('/contact-us', 'Frontend\ContactsController@store')->name('contacts.store');

/*** jobs **/

Route::group(['prefix' => 'jobs'], function () {

    Route::get('', 'Frontend\JobsController@index')->name('jobs');

    Route::get('/view/{slug}', 'Frontend\JobsController@show')->name('jobs.show');

    Route::get('/positions/{slug}', 'Frontend\JobsController@category')->name('jobs.categories.show');

    Route::get('/skills/{slug}', 'Frontend\JobsController@category')->name('jobs.skills.show');

    Route::get('/experiences/{slug}', 'Frontend\JobsController@category')->name('jobs.experiences.show');

    Route::get('/post', 'Frontend\JobsController@post')->name('jobs.post');

    Route::get('/update/{slug}', 'Frontend\JobsController@edit')->name('jobs.edit');

    Route::post('/update-job/{slug}', 'Frontend\JobsController@update')->name('jobs.update');

    Route::post('/post/add', 'Frontend\JobsController@store')->name('jobs.store');

    Route::post('/apply', 'Frontend\JobsController@apply')->name('jobs.apply');

    Route::post('/apply-update', 'Frontend\JobsController@applyUpdate')->name('jobs.apply.update');

    Route::get('/search', 'Frontend\JobsController@searchJob')->name('jobs.search');

    /*

     * start route quiz or online exam

     */

    Route::group(['prefix' => 'exam'], function () {

        Route::get('/home/{id}', 'Frontend\ExamController@index')->name('exam');

        Route::get('/questions/{id}', 'Frontend\ExamController@questions');

        Route::get('/check-skill', 'Frontend\ExamController@checkSkill');

        Route::post('/questions/results/final', 'Frontend\ExamController@Results');

        Route::get('/check-exam-status', 'Frontend\ExamController@examStatus');

    });

});

Route::group(['prefix' => 'messages'], function () {

    Route::get('', 'Frontend\ContactsController@getMessages')->name('messages');

    Route::post('/store', 'Frontend\ContactsController@store')->name('messages.store');

    Route::post('/view/{id}', 'Frontend\ContactsController@viewMessage')->name('messages.show');

});

Route::group(['prefix' => 'users'], function () {

    Route::get('/dashboard', 'Frontend\UsersController@dashboard')->name('users.dashboard');

    Route::group(['prefix' => 'messages'], function () {

        Route::get('/', 'Frontend\UsersController@getMessages')->name('users.messages');

        Route::get('/{id}', 'Frontend\UsersController@showMessage')->name('users.messages.show');

    });

});

/** Subscription Routes **/

Route::post('/get-subscribed', 'Frontend\SubscriberController@store')->name('users.subscribe');
Route::post('/store-subscribe', 'Frontend\SubscriberController@store2')->name('users.subscribe2');

Route::get('/unsubscribe/{email}', 'Frontend\SubscriberController@unsubscribe')->name('users.unsubscribe');

// Route::get('/send-email-all-subscriber/{token}', 'Frontend\SubscriberController@sendEmailAsCron')->name('users.subscribe.send-email');

/** Authentication Routes **/
Route::post('/register/employee', 'Auth\LoginController@registerEmployee')->name('register.employee');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/verify/{verify_token}', 'Auth\VerificationController@verify')->name('user.verify');

/*

|--------------------------------------------------------------------------

| Backend Routes

|--------------------------------------------------------------------------

|

| All the routes which is related to backend/admin panel of the site will be placed here

|

 */

// Route::get('admin', 'Backend\PagesController@index')->name('index');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    // HomePage

    Route::get('', function () {

        return redirect()->route('admin.index');

    });

    Route::get('/dashboard', 'Backend\PagesController@index')->name('index');

    // Admin Login Routes

    Route::get('/login', 'Auth\Admin\LoginController@showLoginForm')->name('login');

    Route::post('/login/submit', 'Auth\Admin\LoginController@login')->name('login.submit');

    Route::post('/logout/submit', 'Auth\Admin\LoginController@logout')->name('logout');

    // Password Email Send

    Route::get('/password/reset', 'Auth\Admin\ForgotPasswordController@showLinkRequestForm')->name('password.request');

    Route::post('/password/resetPost', 'Auth\Admin\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

    // Password Reset

    Route::get('/password/reset/{token}', 'Auth\Admin\ResetPasswordController@showResetForm')->name('password.reset');

    Route::post('/password/reset', 'Auth\Admin\ResetPasswordController@reset')->name('password.reset.post');

    Route::get('/change-password', 'Backend\PagesController@changePasswordForm')->name('password.changeForm');
    Route::post('/change-password', 'Backend\PagesController@changePassword')->name('password.change');

    /**

     * Job Routes

     */

    Route::group(['prefix' => 'job'], function () {

        Route::get('/', 'Backend\JobsController@index')->name('job.index')->middleware('role:super-admin');

        Route::get('/trash', 'Backend\JobsController@trash')->name('job.trash')->middleware('role:super-admin');

        Route::post('/add', 'Backend\JobsController@store')->name('job.submit')->middleware('role:super-admin');

        Route::post('/edit/{id}', 'Backend\JobsController@update')->name('job.update')->middleware('role:super-admin');

        Route::post('/delete/{id}', 'Backend\JobsController@destroy')->name('job.delete')->middleware('role:super-admin');

        Route::post('/active/{id}', 'Backend\JobsController@active')->name('job.active')->middleware('role:super-admin');

    });

    /**

     * Admin Account Routes

     */

    Route::post('/list/access', 'Backend\AdminController@access')->name('account.access')->middleware('role:super-admin');

    Route::get('/list', 'Backend\AdminController@index')->name('account.index')->middleware('role:super-admin,admin');

    Route::get('/create', 'Backend\AdminController@create')->name('account.create')->middleware('role:super-admin');

    Route::post('/create/store', 'Backend\AdminController@store')->name('account.store')->middleware('role:super-admin');

    Route::get('/view/{id}', 'Backend\AdminController@show')->name('account.view')->middleware('role:super-admin,admin');

    Route::get('/edit/{id}', 'Backend\AdminController@edit')->name('account.edit')->middleware('role:super-admin');

    Route::post('/upldate/{id}', 'Backend\AdminController@update')->name('account.update')->middleware('role:super-admin');

    Route::get('/activate/{verify_token}', 'Backend\AdminController@activateAccount')->name('account.active')->middleware('role:super-admin');

    Route::get('/delete/{id}', 'Backend\AdminController@destroy')->name('account.delete')->middleware('role:super-admin');

    /**

     * Category Routes

     */

    Route::group(['prefix' => 'positions'], function () {

        Route::get('/', 'Backend\CategoryController@index')->name('category.index')->middleware('role:super-admin,admin');

        Route::get('/trash', 'Backend\CategoryController@trash')->name('category.trash')->middleware('role:super-admin,admin');

        Route::post('/add', 'Backend\CategoryController@store')->name('category.submit')->middleware('role:super-admin,admin');

        Route::post('/edit/{id}', 'Backend\CategoryController@update')->name('category.update')->middleware('role:super-admin,admin');

        Route::post('/delete/{id}', 'Backend\CategoryController@destroy')->name('category.delete')->middleware('role:super-admin,admin');

        Route::post('/active/{id}', 'Backend\CategoryController@active')->name('category.active')->middleware('role:super-admin,admin');

    });
    
    
    /**

     * Sponsor Routes

     */

    Route::group(['prefix' => 'sponsors'], function () {

        Route::get('/', 'Backend\SponsorController@index')->name('sponsor.index')->middleware('role:super-admin,admin');

        Route::get('/trash', 'Backend\SponsorController@trash')->name('sponsor.trash')->middleware('role:super-admin,admin');

        Route::post('/add', 'Backend\SponsorController@store')->name('sponsor.submit')->middleware('role:super-admin,admin');

        Route::post('/edit/{id}', 'Backend\SponsorController@update')->name('sponsor.update')->middleware('role:super-admin,admin');

        Route::post('/delete/{id}', 'Backend\SponsorController@destroy')->name('sponsor.delete')->middleware('role:super-admin,admin');


    });
    
    
    /**

     * Subscriber

     */
    Route::group(['prefix' => 'subscriber'], function () {

        Route::get('/', 'Backend\SubscriberController@index')->name('subscriber.index')->middleware('role:super-admin,admin');

        Route::post('/delete/{id}', 'Backend\SubscriberController@destroy')->name('subscriber.delete')->middleware('role:super-admin,admin');


    });

    /**

     * Skill Routes

     */

    Route::group(['prefix' => 'skill'], function () {

        Route::get('/', 'Backend\SkillsController@index')->name('skill.index')->middleware('role:super-admin,admin');

        Route::get('/trash', 'Backend\SkillsController@trash')->name('skill.trash')->middleware('role:super-admin,admin');

        Route::post('/add', 'Backend\SkillsController@store')->name('skill.submit')->middleware('role:super-admin,admin');

        Route::post('/edit/{id}', 'Backend\SkillsController@update')->name('skill.update')->middleware('role:super-admin,admin');

        Route::post('/delete/{id}', 'Backend\SkillsController@destroy')->name('skill.delete')->middleware('role:super-admin,admin');

        Route::post('/active/{id}', 'Backend\SkillsController@active')->name('skill.active')->middleware('role:super-admin,admin');

    });

    /**

     * Discipline Routes

     */

    Route::group(['prefix' => 'discipline'], function () {

        Route::get('/', 'Backend\DisciplinesController@index')->name('discipline.index')->middleware('role:super-admin,admin');

        Route::get('/trash', 'Backend\DisciplinesController@trash')->name('discipline.trash')->middleware('role:super-admin,admin');

        Route::post('/add', 'Backend\DisciplinesController@store')->name('discipline.submit')->middleware('role:super-admin,admin');

        Route::post('/edit/{id}', 'Backend\DisciplinesController@update')->name('discipline.update')->middleware('role:super-admin,admin');

        Route::post('/delete/{id}', 'Backend\DisciplinesController@destroy')->name('discipline.delete')->middleware('role:super-admin,admin');

        Route::post('/active/{id}', 'Backend\DisciplinesController@active')->name('discipline.active')->middleware('role:super-admin,admin');

    });

    /**

     * Segment Routes

     */

    Route::group(['prefix' => 'segment'], function () {

        Route::get('/', 'Backend\SegmentsController@index')->name('segment.index')->middleware('role:super-admin,admin');

        Route::get('/trash', 'Backend\SegmentsController@trash')->name('segment.trash')->middleware('role:super-admin,admin');

        Route::post('/add', 'Backend\SegmentsController@store')->name('segment.submit')->middleware('role:super-admin,admin');

        Route::post('/edit/{id}', 'Backend\SegmentsController@update')->name('segment.update')->middleware('role:super-admin,admin');

        Route::post('/delete/{id}', 'Backend\SegmentsController@destroy')->name('segment.delete')->middleware('role:super-admin,admin');

        Route::post('/active/{id}', 'Backend\SegmentsController@active')->name('segment.active')->middleware('role:super-admin,admin');

    });

    /**

     * Sector Routes

     */

    Route::group(['prefix' => 'sector'], function () {

        Route::get('/', 'Backend\SectorsController@index')->name('sector.index')->middleware('role:super-admin,admin');

        Route::get('/trash', 'Backend\SectorsController@trash')->name('sector.trash')->middleware('role:super-admin,admin');

        Route::post('/add', 'Backend\SectorsController@store')->name('sector.submit')->middleware('role:super-admin,admin');

        Route::post('/edit/{id}', 'Backend\SectorsController@update')->name('sector.update')->middleware('role:super-admin,admin');

        Route::post('/delete/{id}', 'Backend\SectorsController@destroy')->name('sector.delete')->middleware('role:super-admin,admin');

        Route::post('/active/{id}', 'Backend\SectorsController@active')->name('sector.active')->middleware('role:super-admin,admin');

    });

    /**

     * Experience Routes

     */

    Route::group(['prefix' => 'experience'], function () {

        Route::get('/', 'Backend\ExperiencesController@index')->name('experience.index')->middleware('role:super-admin,admin');

        Route::get('/trash', 'Backend\ExperiencesController@trash')->name('experience.trash')->middleware('role:super-admin,admin');

        Route::post('/add', 'Backend\ExperiencesController@store')->name('experience.submit')->middleware('role:super-admin,admin');

        Route::post('/edit/{id}', 'Backend\ExperiencesController@update')->name('experience.update')->middleware('role:super-admin,admin');

        Route::post('/delete/{id}', 'Backend\ExperiencesController@destroy')->name('experience.delete')->middleware('role:super-admin,admin');

        Route::post('/active/{id}', 'Backend\ExperiencesController@active')->name('experience.active')->middleware('role:super-admin,admin');

    });

    /**

     * User Routes

     */

    Route::group(['prefix' => 'users'], function () {

        Route::get('/candidates', 'Backend\UsersController@candidates')->name('users.candidates')->middleware('role:super-admin');

        Route::get('/employers', 'Backend\UsersController@employers')->name('users.employers')->middleware('role:super-admin');

        Route::post('/bann/{id}', 'Backend\UsersController@ban')->name('users.change_status')->middleware('role:super-admin');

    });

    /**

     * Tag Routes

     */

    Route::group(['prefix' => 'tag'], function () {

        Route::get('/', 'Backend\TagController@index')->name('tag.index')->middleware('role:super-admin,admin');

        Route::get('/add', 'Backend\TagController@create')->name('tag.add')->middleware('role:super-admin,admin');

        Route::post('/add', 'Backend\TagController@store')->name('tag.submit')->middleware('role:super-admin,admin');

        Route::get('/edit/{id}', 'Backend\TagController@edit')->name('tag.edit')->middleware('role:super-admin,admin');

        Route::post('/edit/{id}', 'Backend\TagController@update')->name('tag.update')->middleware('role:super-admin,admin');

        Route::post('/delete/{id}', 'Backend\TagController@destroy')->name('tag.delete')->middleware('role:super-admin,admin');

    });

    //Route::get('/','QuestionController@index');

    Route::post('question/{id}', 'Backend\QuestionController@update')->name('que.update')->middleware('role:super-admin,admin,editor');

    Route::get('delete_question/{question_id}', 'Backend\QuestionController@delete_question')->middleware('role:super-admin,admin,editor');

    Route::post('/questions/uploads', "Backend\QuestionController@upload")->middleware('role:super-admin,admin,editor');

    Route::get('question/file_browser', "Backend\QuestionController@fileBrowser")->middleware('role:super-admin,admin,editor');

    Route::get('question/view/{id}', 'Backend\QuestionController@show')->name('question.show')->middleware('role:super-admin,admin,editor');

    Route::resource('question', 'Backend\QuestionController')->middleware('role:super-admin,admin,editor');

    Route::post('aptitude/{id}', 'Backend\AptitudeController@update')->name('aptitude.update')->middleware('role:super-admin,admin,editor');

    Route::get('delete_aptitude/{question_id}', 'Backend\AptitudeController@delete_aptitude')->middleware('role:super-admin,admin,editor');

    Route::post('/aptitudes/uploads', "Backend\AptitudeController@upload")->middleware('role:super-admin,admin,editor');

    Route::get('/aptitude/file_browser', "Backend\AptitudeController@fileBrowser")->middleware('role:super-admin,admin,editor');

    Route::resource('aptitude', 'Backend\AptitudeController')->middleware('role:super-admin,admin,editor');

    /**

     * coding for personality route

     */

    Route::group(['prefix' => 'personality'], function () {

        Route::get('/', 'Backend\PersonalityController@index')->name('personality.index')->middleware('role:super-admin,admin,editor');

        Route::get('/add', 'Backend\PersonalityController@create')->name('personality.create')->middleware('role:super-admin,admin,editor');

        Route::post('/add', 'Backend\PersonalityController@store')->name('personality.submit')->middleware('role:super-admin,admin,editor');

        Route::get('/view/{id}', 'Backend\PersonalityController@show')->name('personality.view')->middleware('role:super-admin,admin,editor');

        Route::get('/edit/{id}', 'Backend\PersonalityController@edit')->name('personality.edit')->middleware('role:super-admin,admin,editor');

        Route::post('/update/{id}', 'Backend\PersonalityController@update')->name('personality.update')->middleware('role:super-admin,admin,editor');

        Route::get('/delete/{id}', 'Backend\PersonalityController@destroy')->name('personality.delete')->middleware('role:super-admin,admin,editor');

        // for question

        Route::get('question', 'Backend\PersonalityQuestionController@index')->name('personality.question.index')->middleware('role:super-admin,admin,editor');

        Route::get('question/add', 'Backend\PersonalityQuestionController@create')->name('personality.question.create')->middleware('role:super-admin,admin,editor');

        Route::post('question/add', 'Backend\PersonalityQuestionController@store')->name('personality.question.submit')->middleware('role:super-admin,admin,editor');

        Route::get('question/view/{id}', 'Backend\PersonalityQuestionController@show')->name('personality.question.view')->middleware('role:super-admin,admin,editor');

        Route::get('question/edit/{id}', 'Backend\PersonalityQuestionController@edit')->name('personality.question.edit')->middleware('role:super-admin,admin,editor');

        Route::post('question/update/{id}', 'Backend\PersonalityQuestionController@update')->name('personality.question.update')->middleware('role:super-admin,admin,editor');

        Route::get('question/delete/{id}', 'Backend\PersonalityQuestionController@destroy')->name('personality.question.delete')->middleware('role:super-admin,admin,editor');

        Route::post('question/upload', "Backend\PersonalityQuestionController@upload")->middleware('role:super-admin,admin,editor');

        Route::get('question/file_browser', "Backend\PersonalityQuestionController@fileBrowser")->middleware('role:super-admin,admin,editor');

    });

    Route::get('/contacts', 'Backend\ContactController@index')->name('contact.index');
    Route::get('/contacts/view/{id}', 'Backend\ContactController@view')->name('contact.view');
    Route::get('/contacts/delete/{id}', 'Backend\ContactController@destroy')->name('contact.destroy');

    /**

     * Template Routes

     * Job Posting Template Routes

     */

    Route::group(['as' => ''], function () {

        Route::resource('templates', 'Backend\TemplatesController')->middleware('role:super-admin,admin');

    });

    // City/Country Manage

    Route::resource('cities', 'Backend\CitiesController')->middleware('role:super-admin,admin');

    // State Manage

    Route::resource('states', 'Backend\StatesController')->middleware('role:super-admin,admin');
    Route::resource('country', 'Backend\CountryController')->middleware('role:super-admin,admin');

    // Job Crawlers

    Route::resource('crawlers', 'Backend\JobCrawlersController')->middleware('role:super-admin,admin');

    // Crawler Sites

    Route::resource('crawler_sites', 'Backend\CrawlerSitesController')->middleware('role:super-admin,admin');

    // Assign Url to Site

    Route::get('assign-site', 'Backend\JobCrawlersController@asignSite')->name('sites.assign')->middleware('role:super-admin');

    Route::get('assign-site-list', 'Backend\JobCrawlersController@asignSiteList')->name('sites.asignSiteList')->middleware('role:super-admin');

    Route::post('assign-site', 'Backend\JobCrawlersController@asignSiteStore')->name('sites.assign.store')->middleware('role:super-admin');

    Route::delete('assign-site/{id}', 'Backend\JobCrawlersController@asignSiteDelete')->name('sites.assign.delete')->middleware('role:super-admin');

    Route::get('extract-links', 'Backend\JobCrawlersController@extractLinks')->name('crawl.extractLinks')->middleware('role:super-admin');

    Route::post('extract-links', 'Backend\JobCrawlersController@extractLinksStore')->name('crawl.extractLinks.store')->middleware('role:super-admin');

    Route::group(['prefix' => 'settings'], function () {

        Route::get('', 'Backend\SettingsController@index')->name('settings.index')->middleware('role:super-admin');

        Route::put('', 'Backend\SettingsController@update')->name('settings.update')->middleware('role:super-admin');

    });

});

Route::get('messages', 'Frontend\MessageController@messages')->name('messages');
Route::get('message/{id}', 'Frontend\MessageController@message')->name('message');
Route::get('chat/{id}', 'Frontend\MessageController@startChat')->name('chat');