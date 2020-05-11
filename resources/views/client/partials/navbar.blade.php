<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="text-center">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
					aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{url('/')}}">
				<img alt="SHerna logo" src="{{asset('assets_client/img/logo.jpg')}}" style="height: 100%">
			</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
                @foreach(\App\Models\Navigation\Page::where('public', true)->orderBy('order')->get() as $nav)
                    @if(isset($nav->special_code))
                        @if($nav->special_code == 'blog')
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                                   aria-expanded="false">
                                    {{$nav->name}}
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($nav->subpages()->public()->get() as $sub_nav)
                                        <li class="{{isset($page) && $page->nav_subpage_id == $sub_nav->id ? 'active' : ''}}">
                                            <a href="{{url('/blog/'. $sub_nav->url)}}">{{$sub_nav->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @elseif($nav->special_code != 'home')
                            <li class="{{isset($page) && $page->nav_page_id == $nav->id ? 'active' : ''}}">
                                <a href="{{url('/pages/' . $nav->url)}}">{{$nav->name}}</a>
                            </li>
                        @endif
                    @elseif($nav->dropdown)
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false">
                                {{$nav->name}}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($nav->subpages()->public()->get() as $sub_nav)
                                    <li class="{{isset($page) && $page->nav_subpage_id == $sub_nav->id ? 'active' : ''}}">
                                        <a href="{{url('/pages/' . $nav->url . '/' . $sub_nav->url)}}">{{$sub_nav->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="{{isset($page) && $page->nav_page_id == $nav->id ? 'active' : ''}}">
                            <a href="{{url('/pages/' . $nav->url)}}">{{$nav->name}}</a>
                        </li>
                    @endif
                @endforeach
                <li>
                    <a href="{{ route('contact.show') }}" class="{{ url()->current() == route('contact.show') ? 'active' : ''}}">
                     {{ trans('general.navbar.contact') }}</a>
                </li>
				<li>
					<a href="https://www.facebook.com/pg/SHernaSiliconHill/photos" target="_blank"
					   rel="noopener">{{trans('general.navbar.foto')}}</a>
				</li>

				@auth
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false">{{Auth::user()->name}} {{Auth::user()->surname}}</a>
                            <ul class="dropdown-menu">
                                <li class="{{url()->current() == route('contact.show') ? 'active' : ''}}">
                                    <a href="{{ route('user.reservations') }}">{{trans('navbar.my_reservations')}}</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout')  }}">{{trans('navbar.logout')}}</a>
                                </li>


                                @if(Auth::user()->isAdmin())
                                    <li class="divider" role="separator"></li>
                                    <li><a href="{{ route('admin.index') }}">Admin</a></li>
                                @endif
                            </ul>
                        </li>
				@else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false">Login</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('login', ['type' => 'admin']) }}">{{trans('general.navbar.login')}} as Admin</a>
                                </li>
                                <li>
                                    <a href="{{ route('login', ['type' => 'user']) }}">{{trans('general.navbar.login')}} as User</a>
                                </li>
                            </ul>
                        </li>
				@endauth

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false">
						<span class="flag-icon flag-icon-{{Session::get('lang') =='en' ? 'gb':Session::get('lang')}}"></span>
					</a>
					<ul class="dropdown-menu">
                        @foreach(\App\Models\Language\Language::all() as $lang)
                            <li>
                                <a  href="{{route('language', [$lang->code])}}">
                                    <span class="flag-icon flag-icon-{{$lang->code == 'en' ? 'gb' : $lang->code}}"></span>{{$lang->name}}</a>
                            </li>
                        @endforeach

					</ul>
				</li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>
