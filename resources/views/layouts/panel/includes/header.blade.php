<header class="header p-3 mb-3 border-bottom">
    <div class="container">
        <div class="header-inner d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center mb-2 me-lg-3 mb-lg-0 text-dark text-decoration-none">
                <img src="{{ asset('images/logo.png') }}" alt="" width="100">
            </a>

            <ul class="main-nav nav col-12 col-lg-auto me-lg-auto mb-lg-0 mb-2 justify-content-center">
                <li><a href="{{ route('dashboard') }}" class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('orders') }}" class="nav-link {{ Request::routeIs('orders.*') ? 'active' : '' }} {{ Request::is('order*') ? 'active' : '' }}">Orders</a></li>

                <li><a href="{{ route('upsellfunnels') }}" class="nav-link {{ Request::routeIs('upsellfunnels.*') ? 'active' : '' }}{{ Request::is('upsellfunnel*') ? 'active' : '' }} ">Upsell Funnels</a></li>
               <li><a href="{{ route('builder.listing') }}" class="nav-link {{ Request::routeIs('builder.listing') ? 'active' : '' }}{{ Request::is('builder.listing') ? 'active' : '' }}">Pages</a></li>


            </ul>

            <!-- <div class="quick-link text-center text-lg-start col-12 col-lg-auto mb-2 mb-lg-0 me-lg-3">
            <button type="button" class="btn btn-outline-primary">Knowledge Base</button>
        </div> -->

            <div class="setting-dropdown dropdown text-end">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle {{ Request::routeIs('checkout.settings') || Request::routeIs('global.codes') || Request::routeIs('payment.settings') || Request::routeIs('password.change.view') ? 'active' : '' }} rounded-2" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    Settings
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="{{ route('config.settings') }}">Config Settings</a></li>
                    <li><a class="dropdown-item" href="{{ route('checkout.settings') }}">Checkout Settings</a></li>
                    <li><a class="dropdown-item" href="{{ route('global.codes') }}">Global Codes</a></li>
                    <li><a class="dropdown-item" href="{{ route('payment.settings') }}">Payment Providers</a></li>
                    <li><a class="dropdown-item" href="{{ route('password.change.view') }}">Change Password</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a><form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form></li>
                </ul>
            </div>
        </div>
    </div>
</header>
