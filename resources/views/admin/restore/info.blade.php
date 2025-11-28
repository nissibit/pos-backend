<ul class="list-group">
    @foreach($audit->old_values as $attribute => $value)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span><b>{{ strtoupper($attribute).'  '}}</b></span>
        <!--<span><strike>a</strike></span>-->
        <span class="badge badge-pill">{{ strtoupper($value) }}</span>
    </li>
    @endforeach
    
    <form action="{{ route('restore.entity') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="audit" value="{{ $audit }}"  />
        <button type="submit" class="form-control btn btn-outline-primary text-center">
            <i class="fa fa-check-circle"> Restaurar</i>
        </button>
    </form>  
</ul>