@php
    use App\Models\Language;
    $languages = Language::orderBy('name')->get();
@endphp

<form method="POST" action="{{ route('system_management.locales.store') }}" id="form-save" data-parsley-validate>
    @csrf
    @method('POST')

    <div class="form-group">
        <label for="name">{{ __('global.name') }} *</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name') }}" required autofocus>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="code">{{ __('locales.code') }} *</label>
        <input type="text" name="code" id="code"
               class="form-control @error('code') is-invalid @enderror"
               value="{{ old('code') }}" placeholder="ej: es_PE" required>
        @error('code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="language_id">{{ __('languages.singular') }} *</label>
        <select name="language_id" id="language_id" class="form-control @error('language_id') is-invalid @enderror" required>
            @foreach($languages as $language)
                <option value="{{ $language->id }}"
                    {{ (old('language_id') == $language->id) ? 'selected' : '' }}>
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

    <div class="form-group text-right">
        <a href="{{ route('system_management.locales.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('global.cancel') }}
        </a>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> {{ __('global.save') }}
        </button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación del formulario
        document.getElementById('form-save').addEventListener('submit', function(e) {
            let isValid = true;
            const name = document.getElementById('name');
            const code = document.getElementById('code');
            const languageId = document.getElementById('language_id');

            // Validar nombre
            if (!name.value.trim()) {
                name.classList.add('is-invalid');
                isValid = false;
            }

            // Validar código
            if (!code.value.trim()) {
                code.classList.add('is-invalid');
                isValid = false;
            }

            // Validar idioma
            if (!languageId.value) {
                languageId.classList.add('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Remover clase de error al escribir/seleccionar
        document.getElementById('name').addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });

        document.getElementById('code').addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });

        document.getElementById('language_id').addEventListener('change', function() {
            this.classList.remove('is-invalid');
        });
    });
</script>
@endpush
