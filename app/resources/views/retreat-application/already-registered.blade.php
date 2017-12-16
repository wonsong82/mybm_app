@extends ( 'layouts.app' )

@section ( 'content' )

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">수련회 신청서 </div>
                    <div class="panel-body">
                        <h4>수련회 신청서가 이미 접수되었습니다.</h4>


                        <a href="{{ url('home') }}" class="btn btn-primary">홈으로 돌아가기</a>
                    </div>
                </div>

            </div>
        </div>
    </div>




@endsection

