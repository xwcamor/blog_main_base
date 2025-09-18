<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <!-- =========================
         ACCESSES
    ========================== -->
    <li class="nav-header">{{ __('sidebar.title_access') }}</li>

    <li class="nav-item {{ request()->is('auth_management/users*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->is('auth_management/users*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>
                {{ __('sidebar.menu_accesses') }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('auth_management.users.index') }}" 
                   class="nav-link {{ request()->is('auth_management/users*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('sidebar.users') }}</p>
                </a>
            </li>
        </ul>
    </li>

 

    <!-- =========================
         SETTINGS
    ========================== -->
    <li class="nav-header">{{ __('sidebar.title_setting') }}</li>


    @php
        $localePrefixCountries = app()->getLocale() . '/setting_management/countries';
        $localePrefixLanguages = app()->getLocale() . '/setting_management/languages';
        $isSettingsActive = request()->is($localePrefixCountries . '*') || request()->is($localePrefixLanguages . '*');
    @endphp

    <li class="nav-item {{ $isSettingsActive ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ $isSettingsActive ? 'active' : '' }}">
            <i class="nav-icon fas fa-cog"></i>
            <p>
                {{ __('sidebar.menu_settings') }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('setting_management.countries.index') }}"
                class="nav-link {{ request()->is($localePrefixCountries . '*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('countries.plural') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('setting_management.languages.index') }}"
                class="nav-link {{ request()->is($localePrefixLanguages . '*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('languages.plural') }}</p>
                </a>
            </li>
        </ul>
    </li>
    



</ul>
