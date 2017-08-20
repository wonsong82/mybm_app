@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-3 control-label">E-Mail Address</label>

                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  autofocus placeholder="Email Address / Login ID">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-3 control-label">Password</label>

                            <div class="col-md-9">
                                <input id="password" type="password" class="form-control" name="password"  placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-3 control-label">Confirm Password</label>

                            <div class="col-md-9">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  placeholder="Confirm Your Password">
                            </div>
                        </div>


                        <hr>

                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="col-md-3 control-label">성별</label>

                            <div class="col-md-9">
                                <label for="gender_male" class="radio-inline">남자</label>
                                <input id="gender_male" type="radio" name="gender" value="male"{{ old('gender')=='male'?' checked':'' }}>
                                <label for="gender_female" class="radio-inline">여자</label>
                                <input id="gender_female" type="radio" name="gender" value="female"{{ old('gender')=='female'?' checked':'' }}>

                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-3 control-label">이름</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"  placeholder="Your Name">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <label for="birthday" class="col-md-3 control-label">생년월일</label>

                            <div class="col-md-9">
                                <input id="birthday" type="date" class="form-control" name="birthday" value="{{ old('birthday') }}" >

                                @if ($errors->has('birthday'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('area_code') || $errors->has('exchange') || $errors->has('line_number') ? ' has-error' : '' }}">                            
                            <label for="name" class="col-md-3 col-xs-12 control-label">전화번호</label>

                            <div class="col-md-3 col-xs-4">
                                <input id="area_code" type="text" class="form-control" name="area_code" value="{{ old('area_code') }}"  placeholder="Area Code">

                                @if ($errors->has('area_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('area_code') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 col-xs-4">
                                <input id="exchange" type="text" class="form-control" name="exchange" value="{{ old('exchange') }}"  placeholder="Prefix">

                                @if ($errors->has('exchange'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('exchange') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 col-xs-4">
                                <input id="line_number" type="text" class="form-control" name="line_number" value="{{ old('line_number') }}"  placeholder="Number">

                                @if ($errors->has('line_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('line_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('line1') || $errors->has('line2') || $errors->has('city')  || $errors->has('state')  || $errors->has('zip') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-3 col-xs-12 control-label">주소</label>

                            <div class="col-md-9 col-xs-12">
                                <input id="line1" type="text" class="form-control" name="line1" value="{{ old('line1') }}"  placeholder="Street Address" style="margin-bottom:15px;">

                                @if ($errors->has('line1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('line1') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 col-xs-12"></div>
                            <div class="col-md-9 col-xs-12">
                                <input id="line2" type="text" class="form-control" name="line2" value="{{ old('line2') }}"  placeholder="Apt # / Suite # etc" style="margin-bottom:15px;">

                                @if ($errors->has('line2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('line2') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="col-md-3 col-xs-12"></div>
                            <div class="col-md-3 col-xs-4">
                                <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}"  placeholder="City" style="margin-bottom:15px;">

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 col-xs-4">
                                <select name="state" id="state" class="form-control" style="margin-bottom:15px;">
                                    @foreach(App\Helper\Address::states(App\Helper\Address::ASSOC) as $key=>$value)
                                        <option value="{{ $key }}"{{ old('state')==$key?' selected':''}}>{{ $value }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('state'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="col-md-3 col-xs-4">
                                <input id="zip" type="text" class="form-control" name="zip" value="{{ old('zip') }}"  placeholder="Zip" style="margin-bottom:15px;">

                                @if ($errors->has('zip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('zip') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>


                        <input type="hidden" name="country_code" value="1">
                        <input type="hidden" name="country" value="US">

                        {{--<hr>

                        <div class="form-group{{ $errors->has('need_ride') ? ' has-error' : '' }}">
                            <label for="need_ride" class="col-md-3 control-label">라이드 필요여부</label>
                            <div class="col-md-9">주일예배 / 순모임 라이드 필요합니까?</div>

                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <label for="need_ride_yes" class="radio-inline">필요합니다</label>
                                <input id="need_ride_yes" type="radio" name="need_ride" value="1"{{ old('need_ride')===true?' checked':'' }}>
                                <label for="need_ride_no" class="radio-inline">라이드있습니다</label>
                                <input id="need_ride_no" type="radio" name="need_ride" value="0"{{ old('need_ride')===false?' checked':'' }}>

                                @if ($errors->has('need_ride'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('need_ride') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="form-group{{ $errors->has('can_provide_place') ? ' has-error' : '' }}">
                            <label for="can_provide_ride" class="col-md-3 control-label">라이드 가능여부</label>
                            <div class="col-md-9">(라이드가 있으시다면) 다른사람 라이드 가능합니까?</div>

                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <label for="can_provide_ride_yes" class="radio-inline">가능합니다</label>
                                <input id="can_provide_ride_yes" type="radio" name="can_provide_ride" value="1"{{ old('can_provide_ride')===true?' checked':'' }}>
                                <label for="can_provide_ride_no" class="radio-inline">힘들듯합니다</label>
                                <input id="can_provide_ride_no" type="radio" name="can_provide_ride" value="0"{{ old('can_provide_ride')===false?' checked':'' }}>

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

                        <hr>--}}




                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
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
