
@extends('layouts.app')

@section('content')
    <div class="clearfix">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4> Enrolling in Activity: "{{ $activity->title }}" </h4>
                </div>
                <div class="panel-body">
                    <div class="clearfix">
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-group" action="{{ url('/submitEnroll/'.$activity->id) }}" method="post">
                            {!! csrf_field() !!}
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for="priority">Priority:</label>
                                    <select id="prioritySel" name="priority">
                                        @foreach( $priorities as $p)
                                            <option value="{{$p}}" name="priority">{{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="motivation">Motivation</label>
                                    <textarea id="motivation" class="form-control" type="text" name="motivation"></textarea>
                                </div>

                            </div>
                            <div class="clearfix">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="cancelEnrollment" type="button" class="btn btn-default">Cancel</button>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button id="confirmEnrollment"  type="submit" class="btn btn-primary">
                                        Confirm
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>
                <div class="panel-footer text-center">

                </div>
            </div>
        </div>
    </div>


    <script src="{{ URL::asset('js/enrollment.js') }}"></script>

@endsection