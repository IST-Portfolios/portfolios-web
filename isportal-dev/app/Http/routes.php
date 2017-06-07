<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
 */

/*
    General endpoints
*/
Route::group(['middleware' => 'web'], function () {
    Route::auth();

    //Home
    Route::get('/home', 'HomeController@index');

    //Activities
    Route::get('/activity', 'ActivityController@activityList');
    Route::get('/createActivity', 'ActivityController@createActivity_index');

    Route::post('/activity/{id}', ['as' => 'setActivityID', 'uses' => 'ActivityController@setId']);
    Route::post('/submitActivity', 'ActivityController@submitActivity');
    Route::get('/coachingActivityExist', 'ActivityController@coachingActivityExist');

    //Enrollments

    Route::get('/enrollments', 'EnrollmentsController@index');
    Route::get('/enrollIn/{id}' , 'EnrollmentsController@enrollIn');

    Route::post('/prepareEnrollment', 'EnrollmentsController@prepareEnrollment');
    Route::post('/submitEnroll/{id}', 'EnrollmentsController@submitEnroll');
    Route::post('/deleteEnrollment' , 'EnrollmentsController@deleteEnrollment');
    Route::post('/changePriorities', 'EnrollmentsController@changePriorities');
    Route::post('/acceptEnrollment', 'EnrollmentsController@acceptEnrollment');
    Route::post('/rejectEnrollment', 'EnrollmentsController@rejectEnrollment');

    Route::get('/manageCandidates', ['middleware' => 'role:professor', 'uses' => 'EnrollmentsController@manageCandidates']);

    Route::get('/manageActivities' ,'ActivityController@manageActivities');
    Route::post('/changeActivity/{id}' , 'ActivityController@changeActivity');

    //Coaching
    Route::get('/coaching', ['middleware' => 'role:professor,student','uses' => 'CoachingController@index']);
});

/*
    Professor only endpoints
*/
Route::group(['middleware' => ['web', 'role:professor']], function () {
    Route::get('/lookup', 'ProfController@lookup');
    Route::get('/getAll', 'ProfController@getAll');

    //Coaching Team Management Endpoints (Professor only)

    Route::get('/createCoachingTeam', 'CoachingController@createCoachingTeam');
    Route::post('/submitCoachingTeam', 'CoachingController@submitCoachingTeam');

    Route::get('/addCoacherToTeam/{teamId}', 'CoachingController@addCoacherToTeam');
    Route::get('/submitCoacherToTeam/{teamId}/{coacherId}', 'CoachingController@submitCoacherToTeam');
    Route::get('/getCoachers/{teamId}', 'CoachingController@getCoachers');
    Route::get('/removeCoacher/{coacherId}', 'CoachingController@removeCoacher');

    Route::get('/addCoacheeToTeam/{teamId}', 'CoachingController@addCoacheeToTeam');
    Route::get('/submitCoacheeToTeam/{teamId}/{coacheeId}', 'CoachingController@submitCoacheeToTeam');
    Route::get('/getCoachees/{teamId}', 'CoachingController@getCoachees');
    Route::get('/removeCoachee/{coacheeId}', 'CoachingController@removeCoachee');
});

