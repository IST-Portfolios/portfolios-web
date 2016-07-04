
@extends('layouts.app')

@section('content')
    <script src="{{ URL::asset("js/activityList.js")}}"></script>
    <div class="container">
        <div class="clearfix">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>Activity Title</th>
                        <th>Vacancies</th>
                        <th>Creator</th>
                    </tr>
                    </thead>
                    <tbody>

                    @if( $enrolled)
                        @foreach($enrolled as $e)
                            <tr class="warning already" style="cursor:pointer;" data-toggle="modal" data-target="#myModal" data-title="{{ $e->title  }}"
                                data-id="{{ $e->id  }}"
                                data-objectives="{{ $e->objectives  }}"
                                data-vacancies="{{ $e->vacancies  }}"
                                data-description=" {{ $e->description }}"
                                data-creator=" {{ $e->creator->name }}">
                                <td> {{ $e->title }} </td>

                                <td class="text-center"> {{ $e->vacancies }} </td>

                                <td>{{ $e->creator->name }}</td>
                            </tr>
                        @endforeach
                    @endif

                    @foreach ($activities as $activity)
                        <tr style="cursor:pointer;" data-toggle="modal" data-target="#myModal" data-title="{{ $activity->title  }}"
                            data-id="{{ $activity->id  }}"
                            data-objectives="{{ $activity->objectives  }}"
                            data-vacancies="{{ $activity->vacancies  }}"
                            data-description=" {{ $activity->description }}"
                            data-creator=" {{ $activity->creator->name }}"
                        >

                            <td> {{ $activity->title }} </td>

                            <td class="text-center"> {{ $activity->vacancies }} </td>

                            <td>{{ $activity->creator->name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                    <h4 class="modal-title" id="creator"></h4>
                </div>
                <div class="modal-body">
                    <h4 id="vacancies"></h4>
                    <hr>
                    <h4>Objectives</h4>
                    <p id="objectives"></p>
                    <hr>
                    <h4>Description</h4>
                    <p id="description"></p>
                    <hr>
                    <div class="clearfix">
                        <div class="col-md-12 col-xs-12">
                            <div class="col-xs-6 col-md-6 text-left">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            <div class=" col-xs-6 col-md-6 text-right">
                                <button id="submitBtn" type="submit" class="btn btn-primary">Enroll</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection