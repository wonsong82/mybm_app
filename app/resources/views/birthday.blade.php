@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @foreach($birthdays as $bd)
        <div class="col-md-6 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $bd['title'] }}
                    <span>{{ date('n/j (D)', $bd['from']) }} ~ {{ date('n/j (D)', $bd['to']) }}</span>
                </div>

                <div class="panel-body">
                    <ul>
                        @foreach($bd['users'] as $user)
                        <li>{{ date('n/j (D)', strtotime($user->birthdayThisYear)) }} {{ $user->profile->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection
