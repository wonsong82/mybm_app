@extends ( 'layouts.app' )

@section ( 'content' )

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">순 신청서 <span>status: {{ $application->status }}</span></div>
                    <div class="panel-body">
                        <h4>순 신청서가 이미 접수되었습니다.</h4>

                        @if($application->status == 'pending')
                            <p>순신청이 완료 되었고 곧 순배정 될 것입니다. 감사합니다.</p>
                        @elseif($application->status == 'accepted')
                            <p>{{ auth()->user()->name }}님은 이미 순에 배정 되었습니다. 감사합니다.</p>
                        @elseif($application->status == 'canceled')
                            <p>순신청서가 취소 되었습니다.</p>
                        @endif

                        <a href="{{ url('home') }}" class="btn btn-primary">Back to Dashboard</a>
                    </div>
                </div>

            </div>
        </div>
    </div>




@endsection

