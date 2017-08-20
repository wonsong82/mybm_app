@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">


                    <div class="links">
                        <a href="{{ url('soon-application/2018/create') }}">2017 - 2018 순 신청하기</a>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
