<div class="w3-flex" style="grid-template-columns: auto 150px;">
    <div class="w3-flex" style="gap: 8px;">
        <x-button>
            <i class="fas fa-plus-circle"></i> nova
        </x-button>
          <div class="w3-dropdown-hover">
            <x-button>
                <i class="fas fa-file"></i>  Facturas
            </x-button>
            <div class="w3-dropdown-content w3-bar-block w3-border">
                <a href="#" onclick="loadingFacturas(false)" class="w3-bar-item w3-button"><i class="fas fa-list"></i> Não pagas</a>
                <a href="#" onclick="loadingFacturas(true)" class="w3-bar-item w3-button"><i class="fas fa-check"></i> Pagas</a>
            </div>
        </div>
    </div>
</div>