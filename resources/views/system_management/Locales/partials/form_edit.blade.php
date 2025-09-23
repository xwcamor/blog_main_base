@php
    use App\Models\Language;
    $languages = Language::orderBy('name')->get();
@endphp

<form method="POST" action="{{ route('system_management.locales.update', $locale) }}" id="form-save" data-parsley-validate>
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">{{ __('locales.name') }} *</label>
        <input type="text" name="name" id="name" 
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $locale->name) }}" required autofocus>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="language_id">{{ __('languages.singular') }} *</label>
        <select name="language_id" id="language_id" 
                class="form-control @error('language_id') is-invalid @enderror" required>
            @foreach($languages as $language)
                <option value="{{ $language->id }}"
                    {{ (old('language_id', $locale->language_id) == $language->id) ? 'selected' : '' }}>
                    {{ $language->name }}
                </option>
            @endforeach
        </select>
        @error('language_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</form>
