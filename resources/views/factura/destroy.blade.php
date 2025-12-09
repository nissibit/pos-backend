<div class="col mt-4">
    <div class="collapse" id="collapseExample">
        <form  action="{{ route('factura.ask.destroy',$factura->id) }}" method="post">
            {{ csrf_field() }}
            <div class="form-group d-none">
                <input id="destroy_username" type="text" class="form-control @error('destroy_username') is-invalid @enderror" name="destroy_username" value="{{ auth()->user()->name }}" >
                @error('destroy_username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>               

            <div class="form-group">
                <label class="form-label-left">Motivo de remoção <i class="fa fa-asterisk text-danger"></i></label>
                <textarea id="destroy_reason" rows="7"  name="destroy_reason" class="form-control @error('destroy_reason') is-invalid @enderror" required="required">{{ old('destroy_reason', $category->destroy_reason ?? '') }}</textarea>
                @error('destroy_reason')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success form-group">
                    <i class="fas fa-send-o"> confirmar</i>
                </button>
            </div>
        </form>
    </div>
</div>