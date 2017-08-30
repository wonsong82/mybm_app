<div class="row" style="margin-top:20px;">
    <div class="col col-md-6 col-md-offset-1">


        <div class="box">

            <div class="box-header">
                <div class="box-title">
                    {{ $data['이름'] }} 상세정보
                </div>
            </div>


            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    @foreach($data as $key => $value)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{!! $value !!}</td>
                        </tr>
                    @endforeach
                </table>
            </div>


        </div>


    </div>
</div>
