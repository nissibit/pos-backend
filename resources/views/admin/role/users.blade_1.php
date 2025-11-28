<div class="card">
    <div class="card-header">
        {{ "#".$role->user()->count().' Utilizador(es)' }}
    </div>
    <div class="card-body">
        <table id="example" class="table table-striped table-bordered table-sm table-responsive-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Alias</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                @forelse($role->user()->latest()->get() as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->label }}</td>
                    <td>{{ $role->description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">
                        Sem registos ...
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>