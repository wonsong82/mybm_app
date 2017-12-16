@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">


                    <div class="links">
                        <ul>
                            <li>
                                <a href="{{ url('retreat-application/17_W/create') }}">2017 겨울 수련회 신청하기</a>
                            </li>
                            <li>
                                <a href="{{ url('soon-application/2018/create') }}">2017 - 2018 순 신청하기</a>
                            </li>
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
