<nav class="navbar navbar-expand-lg navbar-light bg-success mb-2">
    <ul class="nav">
        <li class="nav-item dropdown">
            <?php
            $config = Config::get('languages');
            $locale = App::getLocale();
            ?>
            <a class="nav-link dropdown-toggle"  id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="flag flag-{{ $config[$locale]['flag'] }}"> </span> 
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdown09">
                @foreach($config as $key => $value)
                <a class="dropdown-item" href="{{ route('locale', $key) }}"><span class="flag flag-{{ $value['flag'] }}"> </span>  {{ $value["lang"] }} </a>
                @endforeach
            </div>
        </li>
    </ul>
    <div class="col text-center">
        <strong class="text-uppercase"> {{ $company->name ?? 'N/A'}}</strong>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">

        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
            @endif
            @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                    <a class="dropdown-item" href="{{ route('user.changepwd') }}">
                        <i class="fas fa-lock"> </i> {{ __('Alterar Senha') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('user.profile') }}">
                        <i class="fas fa-user"> </i> {{ __('Perfil') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"> </i> {{ __('Sair') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @endguest
        </ul>
    </div>
</nav>