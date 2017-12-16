@if (Auth::check())
    @php( $adm = config('backpack.base.route_prefix', 'admin') )

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="https://placehold.it/160x160/00a65a/ffffff/&text={{ mb_substr(Auth::user()->name, 0, 1) }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">GENERAL</li>
          <li><a href="{{ url($adm.'/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
          <li><a href="{{ url($adm. '/elfinder') }}"><i class="fa fa-files-o"></i> <span>File manager</span></a></li>


          {{-- #### Content management #### --}}
          @if(auth()->user()->can('manage admin'))
            <li class="header">CONTENT MANAGE</li>
            <li><a href="{{ url($adm. '/soon-application?term=2018') }}"><i class="fa fa-files-o"></i> <span>순 신청서</span></a></li>
            <li><a href="{{ url($adm. '/retreat-application?term=17_W') }}"><i class="fa fa-files-o"></i> <span>수련회 신청서</span></a></li>
          @endif




          {{-- #### Adminisatation #### --}}
          @if(auth()->user()->can('manage admin'))
            <li class="header">{{ trans('backpack::base.administration') }}</li>

            <li><a href="{{ url($adm . '/user') }}"><i class="fa fa-user"></i> <span>BM멤버</span></a></li>

            {{--Users--}}
            <li class="treeview">
              <a href="#"><i class="fa fa-group"></i> <span>권한관리</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url($adm . '/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
                <li><a href="{{ url($adm . '/permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
              </ul>
            </li>

        @endif








          {{-- #### User #### --}}
          <li class="header">{{ trans('backpack::base.user') }}</li>

          {{--Logout--}}
          <li><a href="{{ url($adm.'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>


        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
