<div>
    <button {{ $attributes->merge(['type' => 'button', 'class' => 'w3-button w3-theme-l4 w3-border w3-border-theme w3-round w3-padding']) }} style="cursor: pointer;">
        {{ $slot }}
    </button>

</div>