<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="{{ route('admin.index') }}" class="site_title">
            <small class="small-icon-head">
                <img src="{{asset('favicon/ms-icon-310x310.png')}}" alt="SHerna logo"
                     style="height: 100%; padding-bottom: 10px">
            </small>
            <span class="big-icon-head">
                <img src="{{asset('assets_admin/img/logo.png')}}" alt="SHerna logo"
                     style="height: 100%; padding-bottom: 10px">
            </span>
        </a>
    </div>

    <div class="clearfix"></div>
    <br/>

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>Administration</h3>
            <ul class="nav side-menu">
                <li><a href="{{ route('navigation.index') }}"><i class="fa fa-fw fa-navicon"></i>
                        Navigation</a></li>
                <li><a><i class="fa fa-fw fa-file-text-o"></i>Pages <span class="fa fa-chevron-down"</a>
                    <ul class="nav child_menu">
                        <li>
                            <a href="{{ route('page.standalone') }}"><i class="fa fa-fw fa-file-text-o"></i>
                                Standalone Pages</a>
                        </li>
                        <li>
                            <a href="{{ route('page.navigation') }}"><i class="fa fa-fw fa-reorder"></i>
                                Navigation Pages</a>
                        </li>
                        <li>
                            <a href="{{ route('page.subnavigation') }}"><i class="fa fa-fw fa-clone"></i>
                                Subnavigation Pages</a>
                        </li>
                    </ul>
                </li>
                <li><a><i class="fa fa-fw fa-newspaper-o"></i> Blog <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('article.index') }}"><i class="fa fa-fw fa-users"></i>
                                Articles</a></li>
                        <li><a href="{{ route('category.index') }}"><i
                                    class="fa fa-fw fa-list"></i> Categories</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('document.index') }}"><i class="fa fa-fw fa-file"></i> Documents</a>
                </li>
                <li><a href="{{ route('admin.reservation.index') }}"><i class="fa fa-fw fa-calendar"></i>
                        Reservations</a></li>
                							<li><a href="{{ route('user.index') }}"><i class="fa fa-fw fa-users"></i>
                									Users</a></li>
                </li>
                <li><a href="{{ route('location.index') }}"><i class="fa fa-fw fa-map-marker"></i>
                        Locations</a></li>
                <li><a href="{{ route('role.index') }}"><i class="fa fa-fw fa-drivers-license-o"></i>
                        Roles</a></li>
                @if(Auth::user()->isSuperAdmin())
                    <li><a href="{{ route('permission.index') }}"><i class="fa fa-fw fa-low-vision"></i>
                            Permissions</a></li>
                @endif
                <li><a><i class="fa fa-fw fa-cubes"></i> Inventory <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        						<li>
                        							<a href="{{ route('inventory.category.index') }}"><i class="fa fa-fw fa-cubes"></i>
                        								Inventory categories</a>
                        						</li>
                        						<li>
                        							<a href="{{ route('inventory.index') }}"><i class="fa fa-fw fa-cubes"></i>
                        								Inventory items</a>
                        						</li>
                        {{--						--}}
                        <li><a href="{{ route('game.index') }}"><i class="fa fa-fw fa-desktop"></i>
                                Games</a></li>
                        						<li><a href="{{ route('console.index') }}"><i class="fa fa-fw fa-gamepad"></i>
                        								Consoles</a></li>
                    </ul>
                </li>
                {{--<li><a href="{{action('Admin\ContestController@index')}}"><i class="fa fa-fw fa-sitemap"></i>--}}
                {{--Contests</a></li>--}}

{{--                @if(Auth::user()->isSuperAdmin())--}}
                    <li><a href="{{ route('settings.index') }}"><i class="fa fa-fw fa-cogs"></i> Settings</a>
                    </li>
{{--                @endif--}}


                @if(Auth::user()->isSuperAdmin())
                <li>
                    						<a href="{{route('log-viewer::logs.list')}}"><i
                    									class="fa fa-fw fa-history"></i> Logs</a>
                </li>
                @endif
            </ul>
        </div>

    </div>
    <!-- /sidebar menu -->
</div>
