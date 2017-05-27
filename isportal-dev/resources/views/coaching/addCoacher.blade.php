@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="clearfix">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h1>Add Coacher to Team Nº {{$teamId}}</h1>
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>Student Name</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                         @foreach ($availableCoachers as $ac)
                        <tr style="cursor:pointer;">

                            <td> {{ $ac->name }} </td>
                            <td><button type="button" class="btn btn-default" onclick="window.location.href='/submitCoacherToTeam/{{$teamId}}/{{$ac->id}}'">Add To Team</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

@endsection