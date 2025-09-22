<ul class="navbar-nav ml-auto d-flex align-items-center" style="gap: 0px;">



  {{-- Messages --}}
  <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" title="{{ __('global.messages') }}">
      <i class="far fa-comments"></i>
      <span class="badge badge-danger navbar-badge">3</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      {{-- Mensajes aquí --}}
      <a href="#" class="dropdown-item">
        <div class="media">
          <div class="media-body">
            <h3 class="dropdown-item-title">Brad Diesel <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span></h3>
            <p class="text-sm">Call me whenever you can...</p>
            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
          </div>
        </div>
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">...</a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
    </div>
  </li>

  {{-- Notifications --}}
  <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" title="{{ __('global.notifications') }}">
      <i class="far fa-bell"></i>
      <span class="badge badge-warning navbar-badge">15</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <span class="dropdown-item dropdown-header">15 Notifications</span>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">...</a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
  </li>

  {{-- Tools (cuadro) --}}
  <li class="nav-item">
    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" title="{{ __('global.tools') }}">
      <i class="fas fa-th-large"></i>
    </a>
  </li>

  {{-- Languages --}}
  <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" title="{{ __('global.change_language') }}">
      <i class="fas fa-language"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
      @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        @php
          $flag = match($localeCode) {
              'es' => 'es',
              'en' => 'us',
              'pt' => 'br',
              default => $localeCode
          };
        @endphp
        <a rel="alternate" hreflang="{{ $localeCode }}"
           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
           class="dropdown-item d-flex align-items-center {{ app()->getLocale() === $localeCode ? 'active font-weight-bold' : '' }}">
          <span class="flag-icon flag-icon-{{ $flag }} mr-2"></span>
          {{ $properties['native'] }}
        </a>
      @endforeach
    </div>
  </li>

  
 
{{-- Perfil de usuario con menú de configuración --}}
<li class="nav-item dropdown user-menu" >
  {{-- Ícono redondo con inicial --}}
  <a href="#" class="nav-link dropdown-toggle d-flex align-items-center justify-content-center rounded-circle bg-dark text-white"
     data-toggle="dropdown" aria-expanded="false" title="{{ __('global.profile') }}"
     style="width: 35px; height: 35px; font-weight: bold;">
    {{ strtoupper(auth()->user()->name[0] ?? 'U') }}
  </a>

  {{-- Dropdown --}}
  <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

    {{-- Header con nombre --}}
    <li class="dropdown-header text-center">
      <i class="fas fa-user-circle fa-2x mb-1"></i><br>
      {{ auth()->user()->name ?? 'Usuario' }}
    </li>

    <li class="dropdown-divider my-1"></li>

    {{-- Botón Cambiar Estilo (full clickable) --}}
    <li>
      <a href="#" class="dropdown-item w-100 d-flex align-items-center theme-switch" id="toggle-darkmode" title="{{ __('global.change_theme') }}" data-theme="dark">
        <i id="theme-icon" class="fas fa-moon mr-2"></i> {{ __('global.change_theme') }}
      </a>
    </li>

    <li class="dropdown-divider my-1"></li>

    {{-- Botón Cerrar Sesión (full clickable sin borde) --}}
    <li>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" onsubmit="return confirm('¿Estás seguro que deseas cerrar sesión?')" style="margin: 0;">
        @csrf
        <button type="submit" class="dropdown-item w-100 d-flex align-items-center" title="{{ __('global.logout') }}">
          <i class="fas fa-sign-out-alt mr-2"></i > {{ __('global.logout') }}
        </button>
      </form>
    </li>

  </ul>
</li>



</ul>
