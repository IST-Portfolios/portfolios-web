@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Your activities:</h3>
            </div>
            <div class="panel-body">
                <ul class="list-unstyled">
                    @foreach($activities as $a)
                        <li style="cursor:pointer;" data-toggle="modal" data-target="#activityModal"
                            data-id="{{$a->id}}"
                            data-title="{{$a->title}}"
                            data-vacancies="{{$a->vacancies}}"
                            data-objectives="{{$a->objectives}}"
                            data-description="{{$a->description}}"
                        > {{$a->title}} </li>
                        <hr>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="activityModal" tabindex="-1" role="dialog" aria-labelledby="activityModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="modal-body">
                    <form class="form" action="" method="post">

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" type="text" class="form-control" name="title" >
                        </div>

                        @if(Auth::user()->type != 'student')
                            <div class="form-group">
                                <label for="vacancies">Vacancies</label>
                                <input id="vacancies" type="number" class="form-control" name="vacancies" >
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="objectives">Objectives</label>
                            <textarea id="objectives" type="text" class="form-control" name="objectives" ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" type="text" class="form-control" name="description" ></textarea>
                        </div>

                        <div class="form-group text-center">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button  class="btn btn-primary" type="submit">Submit Changes</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


    <script src="{{URL::asset("js/activityManagement.js")}}"></script>


@endsection