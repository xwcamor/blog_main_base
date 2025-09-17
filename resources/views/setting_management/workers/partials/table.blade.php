<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('setting_management.workers.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          ID
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('setting_management.workers.index', array_merge(request()->all(), ['sort' => 'num_doc', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('workers.num_doc') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('setting_management.workers.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('workers.name') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('setting_management.workers.index', array_merge(request()->all(), ['sort' => 'lastname', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('workers.lastname') }}
        </a>
      </th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($workers as $worker)
      <tr>
        <td>{{ $worker->id }}</td>
        <td>{{ $worker->num_doc }}</td>
        <td>{{ $worker->name }}</td>
        <td>{{ $worker->lastname }}</td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('setting_management.workers.show', $worker) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('setting_management.workers.edit', $worker) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('setting_management.workers.delete', $worker) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $workers->links() }}
</div>
