<div>
    <div id="modal" class="w3-modal">
        <div class="w3-modal-content w3-card-2 w3-border w3-round-large w3-border-theme w3-rightbar w3-leftbar">
            <div class="w3-container w3-padding w3-theme-l4">
                <h2>
                    {{ $title ?? '' }}
                </h2>
                <span onclick="toggleModal('modal', false)" class="w3-button w3-display-topright">&times;</span>
            </div>
            <div class="w3-container w3-round-large w3-padding w3-white" id="modalContent">
                @if ($slot->isEmpty())
                ...
                @else
                {{ $slot }}
                @endif
            </div>
            <div class="ww-container w3-padding w3-theme-l4" id="modalFooter">
                {{ $footer ?? '' }}
            </div>
        </div>
    </div>
</div>