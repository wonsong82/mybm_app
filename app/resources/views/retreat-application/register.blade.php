@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">수련회 신청서</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ url("retreat-application/{$term}") }}">
                            {{ csrf_field() }}


                            <div class="form-group">
                                <label class="col-md-3 control-label">수련회비</label>

                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>{{ $price['msg'] }}</p>
                                            <p>현재 가격은 <b>${{ $price['price'] }}</b> 입니다.</p>
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" name="price" value="{{ $price['price'] }}">
                            </div>

                            <hr>


                            <div class="form-group{{ $errors->has('uniform_size') ? ' has-error' : '' }}">
                                <label for="uniform_size" class="col-md-3 control-label">유니폼 사이즈</label>

                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>수련회용 유니폼이 지급됩니다. 사이즈를 선택하세요.</p>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="uniform_size" id="uniform_size" class="form-control">
                                                @foreach($sizes as $size)
                                                    <option value="{{$size}}">{{$size}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('uniform_size'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('uniform_size') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <input type="hidden" name="term" value="{{$term}}">

                            <hr>





                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        신청하기
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection