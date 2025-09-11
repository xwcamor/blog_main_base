<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <!-- =========================
         MÓDULO DE ACCESOS
    ========================== -->
    <li class="nav-header">Accesos del Sistema</li>

    <li class="nav-item {{ request()->is('auth_management/users*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->is('auth_management/users*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>
                Permisos de Acceso
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('auth_management.users.index') }}" 
                   class="nav-link {{ request()->is('auth_management/users*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Usuarios</p>
                </a>
            </li>
        </ul>
    </li>


    <!-- =========================
         MÓDULO PAÍSES
    ========================== -->
    <li class="nav-header">Ajustes del Sistema</li>

    <li class="nav-item {{ request()->is('setting_management/countries*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->is('setting_management/countries*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cog"></i>
            <p>
                Ajustes
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('setting_management.countries.index') }}" 
                   class="nav-link {{ request()->is('setting_management/countries*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Paises</p>
                </a>
            </li>
        </ul>
    </li>

</ul>
