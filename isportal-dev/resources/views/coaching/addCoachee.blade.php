@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="clearfix">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h1>Add Coachee to Team - {{$coachingTeam->name}}</h1>
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>Coachee Name</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($coacheesWithoutTeam as $ac)
                        <tr style="cursor:pointer;">
                            <td> {{ $ac->name }} </td>
                            <td><button type="button" class="btn btn-default" onclick="window.location.href='/submitCoacheeToTeam/{{$coachingTeam->id}}/{{$ac->id}}'">Add To Team</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

@endsection