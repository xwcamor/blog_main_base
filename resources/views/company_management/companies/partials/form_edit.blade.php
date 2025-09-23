<form id="form-save" action="{{ route('company_management.companies.update', $company) }}" method="POST" data-parsley-validate>
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="ruc">{{ __('companies.num_doc') }} <span class="text-danger">(*)</span></label>
        <input type="text" name="num_doc" id="num_doc" value="{{ old('num_doc', $company->num_doc) }}"
               class="form-control" required data-parsley-minlength="11" maxlength="11"
               placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('companies.ruc')]) }}">
    </div>
    <div class="form-group">
        <label for="name">{{ __('companies.name') }} <span class="text-danger">(*)</span></label>
        <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}"
               class="form-control" required data-parsley-minlength="3"
               placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('companies.name')]) }}">
    </div>
</form>
