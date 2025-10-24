<!DOCTYPE html>
<html>
<head>
    <title>Foro</title>
</head>
<body>
    @auth
        <p>Bienvenido, {{ auth()->user()->name }} | <a href="{{ route('logout') }}">Cerrar sesión</a></p>
    @else
        <p><a href="{{ route('login') }}">Login</a> | <a href="{{ route('register') }}">Registro</a></p>
    @endauth

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    @yield('content')
</body>
</html>
