<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <!-- =========================
         ACCESSES
    ========================== -->
    <li class="nav-header">{{ __('sidebar.title_access') }}</li>

    <li class="nav-item {{ menuOpenClass(['auth_management/users*']) }}">
        <a href="#" class="nav-link {{ activeClass(['auth_management/users*']) }}">
            <i class="nav-icon fas fa-user"></i>
            <p>
                {{ __('sidebar.menu_accesses') }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('auth_management.users.index') }}" 
                   class="nav-link {{ activeClass(['auth_management/users*']) }}">
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

    <li class="nav-item {{ menuOpenClass(['system_management/languages*','system_management/system_modules*']) }}">
        <a href="#" class="nav-link {{ activeClass(['system_management/languages*','system_management/system_modules*']) }}">
            <i class="nav-icon fas fa-cog"></i>
            <p>
                {{ __('sidebar.menu_settings') }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('system_management.system_modules.index') }}"
                   class="nav-link {{ activeClass(['system_management/system_modules*']) }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('system_modules.plural') }}</p>
                </a>
            </li>
                        
            <li class="nav-item">
                <a href="{{ route('system_management.languages.index') }}"
                   class="nav-link {{ activeClass(['system_management/languages*']) }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('languages.plural') }}</p>
                </a>
            </li>


        </ul>
    </li>
</ul>
