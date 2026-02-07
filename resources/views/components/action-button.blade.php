<div>
    <button {{ $attributes->merge(['type' => 'submit', 'class' => 'w3-button w3-theme-action w3-border w3-border-theme w3-round-large']) }}>
        {{ $slot }}
    </button>

</div>