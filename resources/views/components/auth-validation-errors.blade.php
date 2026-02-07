@props(['errors'])

@if ($errors->any())
    <div class="w3-panel w3-padding w3-round w3-light-gray w3-text-red">
        <div class="w3-cell-row">
          <div class="w3-cell w3-cell-middle w3-center" style="width: 5%">
            <i class="fas fa-exclamation-circle fa-2x"></i>
          </div>
          <div class="w3-cell w3-cell-middle">
              <ul class="w3-ul w3-bordered" style="list-style: none;">
                  @foreach ($errors->all() as $error)
                      <li style=":before=''; padding:0.3em " >{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        </div>
    </div>
@endif
