{{-- resources/views/partials/language_selector.blade.php --}}
@php
    $activeLanguages = \App\Models\Language::where('is_active', 1)->get();
    $currentLocale = app()->getLocale();
@endphp

<div class="dropdown-menu dropdown-menu-right">
    @foreach($activeLanguages as $language)
        @php
            $supportedLocales = array_keys(LaravelLocalization::getSupportedLocales());
            $isSupported = in_array($language->locale, $supportedLocales);
        @endphp
        @if($isSupported)
            <a rel="alternate" hreflang="{{ $language->locale }}"
               href="{{ LaravelLocalization::getLocalizedURL($language->locale, null, [], true) }}"
               class="dropdown-item d-flex align-items-center {{ $currentLocale === $language->locale ? 'active font-weight-bold' : '' }}">
                @if($language->flag)
                    <span class="flag-icon flag-icon-{{ $language->flag }} mr-2"></span>
                @endif
                {{ $language->name }}
            </a>
        @else
            <span class="dropdown-item d-flex align-items-center text-muted"
                  title="{{ __('global.locale_not_supported') }}">
                @if($language->flag)
                    <span class="flag-icon flag-icon-{{ $language->flag }} mr-2"></span>
                @endif
                {{ $language->name }} ({{ __('global.not_available') }})
            </span>
        @endif
    @endforeach
</div>