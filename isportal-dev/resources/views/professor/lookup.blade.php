@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Welcome to professors Lookup</h1>

        <div class="panel panel-default">
            <div class="panel-heading">
                <form class="form-inline">
                    <div class="form-group">
                        <label for="search">Search</label>
                        <select id="model" class="form-control input-sm">
                            <option value="activity">Activity</option>
                            <option value="enrollment">Enrollment</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="by">by:</label>
                        <select id="filter" class="form-control input-sm">
                            <option value='id'>ID</option>
                            <option value='title'>Title</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control input-sm" id="search" onkeyup="updateQuery()">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-default btn-sm" id="searchBtn">Search</button>
                    </div>
                </form>

            </div>
            <div class="panel-body">
                <table class="table table-hover table-responsive table-bordered">
                    <thead id="tableHeading">

                    </thead>
                    <tbody id="tableBody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{URL::asset('js/professorLookup.js')}}"></script>
@endsection