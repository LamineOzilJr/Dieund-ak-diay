{{-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dieund ak diaay</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold">Dieund ak Diaay</a>
            <div class="flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-2">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Photo de profil" class="w-10 h-10 rounded-full object-cover">
                        <span class="text-gray-700">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                    </div>
                    <a href="{{ route('photos.create') }}" class="text-blue-600">Publier</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-blue-600">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mr-4 text-blue-600">Se Connecter</a>
                    <a href="{{ route('register') }}" class="text-blue-600">Vendre un article</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-8">
        @yield('content')
    </main>
</body>
</html> --}}



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dieund ak diaay</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold">Dieund ak diaay</a>
            <div class="flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-2">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Photo de profil" class="w-10 h-10 rounded-full object-cover">
                        <span class="text-gray-700">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                    </div>
                    {{-- <a href="{{ route('profile.edit') }}" class="text-blue-600">Profil</a> --}}
                    <a href="{{ route('photos.create') }}" class="text-blue-600">Publier</a>
                    {{-- <a href="{{ route('categories.index') }}" class="text-blue-600">Catégories</a> --}}
                    @if (Auth::check() && Auth::user()->isAdmin())
                        <a href="{{ route('categories.index') }}" class="text-blue-600">Catégories</a>
                        <a href="{{ route('validations') }}" class="text-blue-600">Validations</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-blue-600">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mr-4 text-blue-600">Connexion</a>
                    <a href="{{ route('register') }}" class="text-blue-600">Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-8">
        @yield('content')
    </main>
     <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    @yield('scripts')
</body>
</html>