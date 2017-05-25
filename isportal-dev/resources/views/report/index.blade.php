@extends('layouts.app')

@section('content')
    <div class="clearfix">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Submit Report</h3>
                </div>

                @if(Auth::user()->report == null )
                <div class="panel-body">
                    <h4>You have no report submited</h4>
                    <a href=__DIR__."/reports/ruben.jpg" download>download not open it</a>
                </div>
                @else
                <div class="panel-body">
                    <h4>You already have a report, submitting again will eliminate the previous report</h4>
                </div>
                @endif
                <hr>
                <div class="panel-body">
                  <form action="{{url('/submitReport')}}" method="post" enctype="multipart/form-data">
                      <h4>Select file to upload:</h4>
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="file" name="fileToUpload" id="fileToUpload">
                      <br/>
                      <button class="btn btn-primary" type="submit">Submit Report</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
@endsection
