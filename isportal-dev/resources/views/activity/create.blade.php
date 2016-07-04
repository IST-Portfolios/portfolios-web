@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h3 class="panel-title">Activity Creation</h3>
                </div>
                <div class="panel-body">
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="form" action="{{url('/submitActivity')}}" method="post">

                        {!! csrf_field() !!}

                        <div class="form-group col-md-8 col-md-offset-2">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" >
                        </div>

                        @if(Auth::user()->type != 'student')
                            <div class="form-group col-md-8 col-md-offset-2">
                                <label for="vacancies">Vacancies</label>
                                <input type="number" class="form-control" name="vacancies" >
                            </div>

                        @else

                            <div class="form-group col-md-8 col-md-offset-2">
                                <label for="motivation">Motivation</label>
                                <textarea type="text" class="form-control" name="motivation" ></textarea>
                            </div>

                        @endif

                        <div class="form-group col-md-8 col-md-offset-2">
                            <label for="objectives">Objectives</label>
                            <textarea type="text" class="form-control" name="objectives" ></textarea>
                        </div>


                        <div class="form-group col-md-8 col-md-offset-2">
                            <label for="description">Description</label>
                            <textarea type="text" class="form-control" name="description" ></textarea>
                        </div>

                        <div class="form-group col-md-8 col-md-offset-2 text-center">
                                <button type="button" class="btn btn-default" onclick="window.location.href='/home'">Cancel</button>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button class="btn btn-primary" type="submit">Submit</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection