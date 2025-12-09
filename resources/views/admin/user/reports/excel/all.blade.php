
    <div class="alert alert-danger">
        <div class="alert-title">Mostrando o relatório em Excel</div>
        Todos os utilizadores.
    </div>
    <div class="container">
        <div class="card card-primary">
            <div class="card-heading">
                <i class="fa fa-user-alt"> Listar utilizadores </i>
                <a href="{{ route("home") }}" class="btn btn-sm btn-default pull-right">
                    <i class="fa fa-arrow-left"> voltar</i>
                </a>
            </div>
            <div class="card-body">
               <div class="table-responsive" id="tbody">
                   <table class="table table-stripped table-bordered" id="example">
                        <thead>                            
                           <tr>
                              <th>#</th>
                              <th>Nome</th>
                              <th>User Name</th>
                              <th>Email</th>
                              <th>Criado a</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                            </tr> 
                            <?php $i++; ?>                            
                            @endforeach
                        </tbody>
                    </table>  
                </div>
            </div>
        </div>
    </div>