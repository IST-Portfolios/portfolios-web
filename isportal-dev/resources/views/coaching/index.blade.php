@extends('layouts.app')

@section('content')
	<script src="{{ URL::asset("js/coachingList.js")}}"></script>
	<div class="container">
		 <div class="row">
            <div class="col-md-10 col-md-offset-1">
            <h1>Coaching</h1>
			@if($implicitType == 'professor')
				<h1>Management of Coaching Teams</h1>
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Coachers</th>
                        <th>Coachees</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($teams as $team)
                        <tr style="cursor:pointer;" data-toggle="modal" data-target="#coachingTeamModal" data-name="{{ $team->name }}"
                        data-email="{{ $team->email }}"
                        data-teamid="{{ $team->id }}">
                            <td> {{ $team->name }} </td>
                            <td>{{ $team->email }}</td>
                            <td>
                                @foreach ($team->coachers() as $enrr)
                                    {{$enrr->name}},
                                @endforeach
                            </td>
                            <td>
                                @foreach ($team->coachees() as $enrr)
                                    {{$enrr->name}},
                                @endforeach
                            </td>
                            <td><button type="button" class="btn btn-default addCoacherButton" data-teamid="{{ $team->id }}">Add Coacher</button>
                            <button type="button" class="btn btn-default addCoacheeButton" data-teamid="{{ $team->id }}">Add Coachee</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

				<a href="{{ url('/createCoachingTeam') }}" >
				    <button class="btn btn-default">Create Coaching Team</button>
				</a>
			@elseif($implicitType == 'coacher')
				<!-- list his coachers and team mates here-->
			@elseif($implicitType == 'coachee')

			@endif
			</div>
		</div>
	<div class="container">

	 <!-- Modal -->
    <div class="modal fade" id="coachingTeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Coaching Team - <span id="coachingTeamModalTitle"></span></h4>
                </div>
                <div class="modal-body">
                    <h4>Email: <span id="email"></span></h4>
                    <h4>Coachers</h4>
                    <table class="table table-hover table-bordered" id="coacherTableModal">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Filled Dynamically -->
                        </tbody>
                    </table>

                    <h4>Coachees</h4>
                    <table class="table table-hover table-bordered" id="coacheesTableModal">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Filled Dynamically -->
                        </tbody>
                    </table>

                    <div class="clearfix">
                        <div class="col-md-12 col-xs-12">
                            <div class="col-xs-6 col-md-6 text-left">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection