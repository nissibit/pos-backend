@extends("admin.user.indexUser")
@section("content-user")
<table id="example" class="table table-striped table-bordered table-sm table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>User Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @forelse($users as $user)
        <tr>
            <td><a href="{{ route('user.show', $user->id) }}">{{ $user->id }}</a></td>
            <td><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></td>
            <td><a href="{{ route('user.show', $user->id) }}">{{ $user->username }}</a></td>
            <td><a href="{{ route('user.show', $user->id) }}">{{ $user->email }}</a></td>
        </tr>     
        @empty
        <tr>
            <td colspan="5" class="text-center"> Sem registos ...</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-center"> 
                {{ $users->appends(request()->input())->links() }}
            </td>
        </tr>
    </tfoot>
</table> 
@endsection