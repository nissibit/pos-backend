<div class="w3-flex" style="grid-template-columns: auto 150px;">
    <div class="w3-flex" style="gap: 8px;">
        <div class="w3-dropdown-hover">
            <x-link-button href="{{route('products.index')}}" >
                <i class="fas fa-list"></i> listar
            </x-link-button>
            <x-link-button href="{{route('products.create')}}" class="w3-hide">
                <i class="fas fa-plus"></i> registar
            </x-link-button>
        </div>
    </div>
</div>