<form id="form-save" action="{{ route('system_management.system_modules.deleteSave', $system_module) }}" method="POST" data-parsley-validate>
  @csrf
  @method('DELETE')

  <div class="form-group">
    <label for="name">{{ __('system_modules.name') }}</label>
    <input type="text" id="name" class="form-control" value="{{ $system_module->name }}" disabled>
  </div>

  <div class="form-group">
    <label for="deleted_description"> {{ __('global.delete_description') }} <span class="text-danger">(*)</span></label>
    <textarea name="deleted_description" id="deleted_description" rows="4" class="form-control"
              data-parsley-minlength="3" required>{{ old('deleted_description') }}</textarea>

      @error('deleted_description')
        <small class="text-danger">{{ $message }}</small>
      @enderror
  </div>
</form>