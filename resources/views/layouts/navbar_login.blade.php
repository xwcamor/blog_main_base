{{-- resources/views/layouts/navbar_login.blade.php --}}
<nav class="navbar navbar-expand-lg navbar-light bg-transparent">
    <div class="container-fluid">
        <div class="ml-auto">
            <ul class="navbar-nav">
                {{-- Idiomas --}}
                <li class="nav-item dropdown">
                    <a class="nav-link text-dark" data-toggle="dropdown" href="#" title="{{ __('global.select_language') }}">
                        <i class="fas fa-language"></i>
                    </a>
                    @include('partials.language_selector')
                </li>
            </ul>
        </div>
    </div>
</nav>