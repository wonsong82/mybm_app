<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print</title>
</head>
<body>


<ul>
@foreach($applications as $app)

    <li>
        <h6>{{ $app->data['name'] }} <span> | {{$app->data['gender']}}</span></h6>

        <p>{{ $app->data['birthday'] }} | {{ $app->data['age'] }}세<br>
        @if($app->age_preference == 'broad')
            나이대 섞어서
        @elseif($app->age_preference == 'exact')
            나이대 또래끼리
        @else
            나이대 상관없음
        @endif
        </p>

        <p>차있음 {{ $app->need_ride?'X':'O' }} | 라이드가능 {{ $app->can_provide_ride?'O':'X' }} | 집오픈 {{ $app->can_provide_place?'O':'X' }}</p>

        <p>
            {{ $app->data['phone'] }} | {{ $app->data['email'] }} <br>
            {!! $app->data['address'] !!}
        </p>




    </li>

@endforeach
</ul>

<style>
* {
    font: 400 12px/18px 'Nanum';
    margin: 0;
    padding: 0;
    list-style: none;
}
ul {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
}

li {
    width: 33.33333333%;
    box-sizing: border-box;
    padding: 10px;
    border: 1px solid #ddd;
}

h6 {
    font-weight: bold;
    margin-bottom: 5px;
}
p {
    margin-bottom: 5px;
}
h6 span {
    font-weight: 400;
}


</style>

</body>
</html>