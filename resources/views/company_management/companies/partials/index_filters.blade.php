<form id="form-save" action="{{ route('company_management.companies.index') }}" method="GET">
    <div class="row">
        <div class="col-md-6">
            <label for="name" class="form-label">{{ __('companies.name') }}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
        </div>

        <div class="col-md-6">
            <label for="num_doc" class="form-label">{{ __('companies.num_doc') }}</label>
            <input type="text" name="num_doc" id="num_doc" class="form-control" value="{{ request('num_doc') }}">
        </div>
      
    </div>
</form>
