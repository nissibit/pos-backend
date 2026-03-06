@extends('layouts.guest')

@section('content')
 <style>
    #password-content {
    position: relative;
    }

    #show-password {
    position: absolute;
    top: 50%;
    right: 4%;
    cursor: pointer;
    color: lightgray;
    }

    #show-password:hover {
    color: gray;
    }
    </style>

    <div class="w3-container w3-card-4 w3-white w3-animate-zoom w3-padding-32 w3-round-large w3-leftbar w3-border-theme w3-rightbar" style="max-width: 500px; margin:50% auto;">

        <div class="w3-row w3-padding">
            <h2>Faça login para ter acesso...</h2>
            <hr />
        </div>
        <div class="w3-row">

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
        </div>

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf
            <div class="w3-row">
                <div class="w3-col">
                    <label><b>Utilizador</b> <x-icon-required /></label>
                    <x-input name="login" id="login" onfocus="this.value=this.value;"
                        value="{{ old('login', old('login'), '') }}" placeholder="Informe o Utilizador"></x-input>
                </div>
                <div class="w3-col">
                    <div id="password-content">
                        <label><b>Senha</b>  <x-icon-required /></label>
                        <x-input type="password" name="password" id="password" class="w3-input w3-border"
                            placeholder="Informe a Senha" name="password" required />
                        <i id="show-password" class="fas fa-eye"></i>
                    </div>
                </div>
                <div class="w3-col w3-section">
                    <x-action-button class="w3-block">
                        <span>entrar <i class="fas fa-sign-in"></i></span>
                    </x-action-button>
                </div>
                <div class="w3-section">
                    <div class="w3-hide">
                        <input name="remember" id="remember" class="w3-check w3-margin-top" type="checkbox"
                            checked="checked"> Lembrar
                    </div>
                </div>
            </div>
        </form>
    </div>
    @push('scripts')
    <script>
        const showPassword = document.querySelector("#show-password");
        const inputPassword = document.querySelector("#password");
        document.querySelector("#login").focus()
        showPassword.addEventListener("click", function() {
            this.classList.toggle("fa-eye-slash");
            let currentType = inputPassword.type;
            inputPassword.type = currentType == "password" ? "text" : "password";
        });
    </script>
    @endpush
    @endsection