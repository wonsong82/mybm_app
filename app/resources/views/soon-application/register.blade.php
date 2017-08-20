@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">순 신청서</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ url("soon-application/{$term}") }}">
                            {{ csrf_field() }}


                            <div class="form-group{{ $errors->has('need_ride') ? ' has-error' : '' }}">
                                <label for="need_ride" class="col-md-3 control-label">라이드 필요여부</label>
                                <div class="col-md-9">주일예배 / 순모임 라이드 필요합니까?</div>

                                <div class="col-md-3"></div>
                                <div class="col-md-9">
                                    <label for="need_ride_yes" class="radio-inline">필요합니다</label>
                                    <input id="need_ride_yes" type="radio" name="need_ride" value="1"{{ old('need_ride')=="1"?' checked':'' }}>
                                    <label for="need_ride_no" class="radio-inline">라이드있습니다</label>
                                    <input id="need_ride_no" type="radio" name="need_ride" value="0"{{ old('need_ride')=="0"?' checked':'' }}>

                                    @if ($errors->has('need_ride'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('need_ride') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <div class="form-group{{ $errors->has('can_provide_ride') ? ' has-error' : '' }}">
                                <label for="can_provide_ride" class="col-md-3 control-label">라이드 가능여부</label>
                                <div class="col-md-9">(라이드가 있으시다면) 다른사람 라이드 가능합니까?</div>

                                <div class="col-md-3"></div>
                                <div class="col-md-9">
                                    <label for="can_provide_ride_yes" class="radio-inline">가능합니다</label>
                                    <input id="can_provide_ride_yes" type="radio" name="can_provide_ride" value="1"{{ old('can_provide_ride')=="1"?' checked':'' }}>
                                    <label for="can_provide_ride_no" class="radio-inline">힘들듯합니다</label>
                                    <input id="can_provide_ride_no" type="radio" name="can_provide_ride" value="0"{{ old('can_provide_ride')=="0"?' checked':'' }}>

                                    @if ($errors->has('can_provide_ride'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('can_provide_ride') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <div class="form-group{{ $errors->has('can_provide_place') ? ' has-error' : '' }}">
                                <label for="can_provide_place" class="col-md-3 control-label">순모임장소 제공</label>
                                <div class="col-md-9">순모임을 위해 집/장소 오픈 가능합니까?</div>

                                <div class="col-md-3"></div>
                                <div class="col-md-9">
                                    <label for="can_provide_place_yes" class="radio-inline">가능합니다</label>
                                    <input id="can_provide_place_yes" type="radio" name="can_provide_place" value="1"{{ old('can_provide_place')===true?' checked':'' }}>
                                    <label for="can_provide_place_no" class="radio-inline">힘들듯합니다</label>
                                    <input id="can_provide_place_no" type="radio" name="can_provide_place" value="0"{{ old('can_provide_place')===false?' checked':'' }}>

                                    @if ($errors->has('can_provide_place'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('can_provide_place') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <div class="form-group{{ $errors->has('age_preference') ? ' has-error' : '' }}">
                                <label for="age_preference" class="col-md-3 control-label">순 나이대</label>
                                <div class="col-md-9">희망하는 순모임 나이대를 골라주세요</div>

                                <div class="col-md-3"></div>
                                <div class="col-md-9">
                                    <label for="age_preference_broad" class="radio-inline">섞어서</label>
                                    <input id="age_preference_broad" type="radio" name="age_preference" value="broad"{{ old('age_preference')=='broad?'? ' checked':'' }}>
                                    <label for="age_preference_exact" class="radio-inline">또래끼리</label>
                                    <input id="age_preference_exact" type="radio" name="age_preference" value="exact"{{ old('age_preference')=='exact'?' checked':'' }}>
                                    <label for="age_preference_both" class="radio-inline">상관없다</label>
                                    <input id="age_preference_both" type="radio" name="age_preference" value="both"{{ old('age_preference')=='both'?' checked':'' }}>

                                    @if ($errors->has('age_preference'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('age_preference') }}</strong>
                                        </span>
                                    @endif
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