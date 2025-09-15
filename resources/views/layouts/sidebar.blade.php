<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <!-- =========================
         MÓDULO DE ACCESOS
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
         MÓDULO PAÍSES
    ========================== -->
    <li class="nav-header">{{ __('sidebar.title_setting') }}</li>


    @php
        $localePrefix = app()->getLocale() . '/setting_management/countries';
    @endphp

    <li class="nav-item {{ request()->is($localePrefix . '*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->is($localePrefix . '*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cog"></i>
            <p>
                {{ __('sidebar.menu_settings') }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('setting_management.countries.index') }}"
                class="nav-link {{ request()->is($localePrefix . '*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('countries.plural') }}</p>
                </a>
            </li>
        </ul>
    </li>
    



</ul>
