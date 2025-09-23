<form method="POST" action="{{ route('system_management.locales.deleteSave', $locale) }}" id="form-save" data-parsley-validate>
    @csrf
    @method('DELETE')

    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        {{ __('locales.confirm_delete') }}
    </div>

    <div class="form-group">
        <label for="deleted_description">{{ __('global.deleted_reason') }} *</label>
        <textarea name="deleted_description" id="deleted_description" 
                  class="form-control @error('deleted_description') is-invalid @enderror" 
                  rows="3" required>{{ old('deleted_description') }}</textarea>
        @error('deleted_description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    
</form>
