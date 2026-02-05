<div>
    <div class="w3-container w3-padding">
        <div class="w3-card-2 w3-border w3-round-large w3-border-theme">
            <div class="w3-row w3-round-large w3-padding w3-theme-l4">
                <h2 class="w3-text-theme">
                    {{ $title }}
                </h2>
                <div class="">
                    {{ $menu }}
                </div>
            </div>
            <div class="w3-row w3-round-large w3-padding w3-white">
                @if ($slot->isEmpty())
                    ...
                @else
                    {{ $slot }}
                @endif
            </div>
        </div>
    </div>
</div>