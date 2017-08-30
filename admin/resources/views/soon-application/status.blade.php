@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>Soon application status for <span>{{ $term }}</span> term</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li><a href="{{ url($crud->route . '?term=' . $term) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
            <li class="active">Status</li>
        </ol>
    </section>
@endsection

@section('content')
    @if ($crud->hasAccess('list'))
        <a href="{{ url($crud->route. '?term=' . $term) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a><br><br>
    @endif


    <div class="row">

        <div class="col-md-4 col-xs-12">
            <div class="info-box bg-aqua">

                <span class="info-box-icon">
                    <i class="ion ion-ios-people-outline"></i>
                </span>

                <div class="info-box-content">
                    <div class="info-box-text">Users</div>
                    <div class="info-box-number">{{ $users->count() }}</div>
                </div>

            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="info-box bg-green">

                <span class="info-box-icon">
                    <i class="ion ion-ios-checkmark-outline"></i>
                </span>

                <div class="info-box-content">
                    <div class="info-box-text">Applied</div>
                    <div class="info-box-number">{{ $appliedUsers->count() }}</div>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ round(($appliedUsers->count() / $users->count())*100) }}%"></div>
                    </div>
                    <span class="progress-description">{{ $appliedUsers->count() }} Users applied ({{ round(($appliedUsers->count() / $users->count())*100) }}% )</span>
                </div>

            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="info-box bg-red">

                <span class="info-box-icon">
                    <i class="ion ion-ios-minus-outline"></i>
                </span>

                <div class="info-box-content">
                    <div class="info-box-text">Not Applied</div>
                    <div class="info-box-number">{{ $notAppliedUsers->count() }}</div>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ round(($notAppliedUsers->count() / $users->count())*100) }}%"></div>
                    </div>
                    <span class="progress-description">{{ $notAppliedUsers->count() }} Users applied ({{ round(($notAppliedUsers->count() / $users->count())*100) }}% )</span>
                </div>

            </div>
        </div>


    </div>


    <div class="row">
        <div class="col col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        USERS NOT YET APPLIED
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Profile Link</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach( $notAppliedUsers as $user )

                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{!! $user->profileButton() !!}</td>
                            </tr>


                        @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>



    </div>




@endsection


@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/show.css') }}">
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/show.js') }}"></script>
@endsection