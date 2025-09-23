<form id="form-save" action="{{ route('system_management.companies.store') }}" method="POST" data-parsley-validate>
    @csrf
    <div class="form-group">
        <label for="ruc">{{ __('companies.ruc') }} <span class="text-danger">(*)</span></label>
        <input type="text" name="ruc" id="ruc" class="form-control" required data-parsley-minlength="11" data-parsley-maxlength="11" maxlength="11" placeholder="20123456789" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
    </div>
    <div class="form-group">
        <label for="name">{{ __('companies.name') }} <span class="text-danger">(*)</span></label>
        <input type="text" name="name" id="name" class="form-control" required data-parsley-minlength="3" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('companies.name')]) }}">
    </div>
</form>
@push('scripts')
    @include('setting_management.workers.partials.scripts')
@endpush