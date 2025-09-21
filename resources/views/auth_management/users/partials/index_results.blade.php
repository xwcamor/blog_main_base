<table class="table  table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('auth_management.users.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          ID
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('auth_management.users.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          Nombre
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('auth_management.users.index', array_merge(request()->all(), ['sort' => 'email', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          Email
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('auth_management.users.index', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          Estado
        </a>
      </th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{!! $user->state_html !!}</td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('auth_management.users.show', $user) }}" title="Ver">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('auth_management.users.edit', $user) }}" title="Editar">
              <i class="fas fa-pen"></i>
            </a>
            @if(auth()->id() !== $user->id)
                <a class="btn btn-light" href="{{ route('auth_management.users.delete', $user) }}" title="Eliminar">
                    <i class="fas fa-trash"></i>
                </a>
            @endif
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $users->links() }}
</div>
