<?php

use Illuminate\Http\Request;

/*

|--------------------------------------------------------------------------

| API Routes

|--------------------------------------------------------------------------

|

| Here is where you can register API routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| is assigned the "api" middleware group. Enjoy building your API!

|

 */

// Route::middleware('auth:api')->get('/user', function (Request $request) {

//     return $request->user();

// });

Route::get('/job-activity/get/{job_id}/{user_id}', 'API\APIController@getJobActivity')->name('job_activity.show');

Route::post('/jobs/favorite', 'API\JobAPIController@addFavorite')->name('api.job.favorite');

Route::get('/jobs/check-favorite/{job_id}/{api_token}', 'API\JobAPIController@checkFavorite')->name('api.job.checkFavorite');

Route::post('template', 'API\JobAPIController@getTemplate')->name('api.getTemplate');

Route::get('templates/{search}', 'API\JobAPIController@templates')->name('api.templates');

Route::get('templates', 'API\JobAPIController@AllTemplates')->name('api.AllTemplates');

// Review

Route::post('/reviews/add', 'API\APIController@addReview')->name('api.reviews.add');

Route::get('/employer/datas', 'API\APIController@EmployerData')->name('api.employer.data');
Route::get('/employer/datas/weekly', 'API\APIController@weeklyData')->name('api.weekly.data');
Route::get('/employer/datas/yearly', 'API\APIController@YearlyData')->name('api.yearly.data');
Route::get('/employer/datas/monthly', 'API\APIController@MonthlyData')->name('api.monthly.data');
