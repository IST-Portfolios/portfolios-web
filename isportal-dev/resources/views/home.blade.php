@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <p>Welcome {{ Auth::user()->name }}</p>
                        <hr>
                        @if(Auth::user()->type == 'professor')
                            <h4>Students</h4>
                            <p>There are {{\App\User::where('type','student')->get()->count()}} registered students this semester.</p>
                            <hr>
                            <h4>Activities</h4>
                            <p>You have created {{Auth::user()->activities()->count()}} Activities</p>
                            <p>There are currently {{\App\Activity::where('type','regular')->get()->count()}} activities available for enrollment</p>
                            <p>There are {{ \App\Activity::where('type', 'self-proposal')->where('state','pending')->get()->count()}}
                                self-proposed activities waiting evaluation.</p>

                        @elseif(Auth::user()->type == 'student')
                            <h4>Activities:</h4>
                            <p>There are currently {{\App\Activity::where('type','regular')->get()->count()}} available for Enrollment</p>
                            <hr>
                            <h4>Enrollments:</h4>
                            <p>You are currently enrolled in {{Auth::user()->enrollments()->count()}} activities</p>
                            @if(Auth::user()->enrollments()->count() < 3)
                                <p style="color: red">Warning:</p>
                                <p style="color: red"> Your enrollment process is not complete yet. You should enroll in a total of 3 activities <a href="/activity">Enroll Here</a></p>
                            @else
                                <p style="color: green">Your enrollment process is complete. You will be engaged by the entities responsible for the activities, you've chosen</p>

                            @endif
                        @else
                            <h4>Candidates:</h4>
                            <p>So far
                                @if($candidates > 0)
                                    <a href="/manageCandidates">{{ $candidates }}</a>
                                @else
                                    {{$candidates}}
                                @endif
                                candidates have enrolled in your activity(ies).
                            </p>

                        @endif
                    </div>
                </div>

                <div class="btn-group">
                    @if($type == 'professor')
                        <a href="{{ url('/lookup') }}" >
                            <button class="btn btn-default">Search</button>
                        </a>
                    @endif
                    @if($type == 'student')
                        <a href="{{ url('activity') }}">
                            <button class="btn btn-default">Activities</button>
                        </a>
                        <a href="{{ url('enrollments') }}">
                            <button class="btn btn-default">Enrollments</button>
                        </a>
                    @elseif($type != 'student' )
                        <a href="{{ url('manageCandidates') }}">
                            <button class="btn btn-default">Manage Candidates</button>
                        </a>
                        <a href="{{ url('manageActivities') }}">
                            <button class="btn btn-default">Manage Activities</button>
                        </a>
                    @endif
                    <a href="{{ url('createActivity') }}">
                        <button class="btn btn-default">Create Activity</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
