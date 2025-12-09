<div class="card">
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Nome</dt>
            <dd>{{ $user->name }}</dd>
            <dt>User Name</dt>
            <dd>{{ $user->username }}</dd>            
            <dt>Email</dt>
            <dd>{{ $user->email }}</dd>
        </dl>
        @can('delete_user')
        <form  action="{{ route('user.destroy',$user->id) }}" method="post" class="btn-group-sm">
            {{ csrf_field() }} 
            {{ method_field('DELETE') }}
            <a href="{{ route('user.activity', ['id' => $user->id]) }}" class="btn btn-outline-primary"><i class="fa fa-eye"> actividade</i></a> &nbsp;
            @if($user->id > 1)<a href="{{ route('user.edit', $user->id) }}" class="btn btn-outline-success"><i class="fa fa-edit"> </i></a> &nbsp;
            <button  type="submit" data-toggle="confirmation" data-title="Suprimir utilizador?" class="btn btn-outline-danger"><i class="fa fa-trash"> </i></button>@endif
        </form>
        @endcan
    </div>
</div>