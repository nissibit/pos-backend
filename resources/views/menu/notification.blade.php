<?php
    $utilNotif = Auth::user();
     $i = 1;
?>
<li role="presentation" class="dropdown">
    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-envelope-o"></i>
        <span class="badge bg-green">{{ $utilNotif->notifications()->count() }}</span>
    </a>
    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
        @foreach($utilNotif->notifications as $notification)
        @if($i <= 4)
        <li>
            <?php
               $arrayTipo = explode("\\", $notification->type);
               $tipo = $arrayTipo[count($arrayTipo)-1];
            ?>
            <a>
                <span>
                    <span>{{ $tipo }}</span>
                    <span class="time">{{ $notification->created_at }}</span>
                </span>
                <span class="message">
                    @foreach($notification->data as $data)
                    {{ $data }} 
                    @endforeach
                </span>
            </a>
        </li>
        @endif
        <?php $i++ ?>
        @endforeach
        
        <li>
            <div class="text-center">
                <a href="">
                    <strong>Ver todas notificações</strong>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </li>
    </ul>
</li>