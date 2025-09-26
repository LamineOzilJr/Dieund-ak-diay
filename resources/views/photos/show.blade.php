@extends('layouts.app')

@section('meta')
    <!-- Métadonnées Open Graph pour WhatsApp -->
    <meta property="og:title" content="{{ $photo->title }}">
    <meta property="og:description" content="{{ $photo->description ?: 'Découvrez cette photo' }}">
    <meta property="og:image" content="{{ url(Storage::url($photo->image_path)) }}">
    <meta property="og:url" content="{{ route('photos.show', $photo) }}">
    <meta property="og:type" content="website">
    
    <!-- Métadonnées Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $photo->title }}">
    <meta name="twitter:description" content="{{ $photo->description ?: 'Découvrez cette photo' }}">
    <meta name="twitter:image" content="{{ url(Storage::url($photo->image_path)) }}">
    
    <!-- Autres métadonnées -->
    <meta name="description" content="{{ $photo->description ?: $photo->title }}">
@endsection

@section('content')
    <div class="container mx-auto p-4 max-w-md">
        <h1 class="text-2xl font-bold mb-4">{{ $photo->title }}</h1>
        <div class="bg-white rounded shadow p-4 relative">
            <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->title }}" class="w-full h-64 object-cover rounded">
            
            <p class="mt-2">{{ $photo->description }}</p>
            <p class="text-sm text-gray-600">Prix: {{ number_format($photo->prix, 0, ',', ' ') }} FCFA</p>
            <p class="text-sm text-gray-600">Catégorie: {{ $photo->category ? $photo->category->name : 'Aucune' }}</p>
            <p class="text-sm text-gray-600">
                Publié par: 
                <img src="{{ $photo->user->profile_photo_url }}" alt="Profil" class="inline-block w-6 h-6 rounded-full mr-2">
                {{ $photo->user->first_name }} {{ $photo->user->last_name }} 
            </p>
            <p>Telephone: {{ $photo->user->phone_number }}</p>
            <p class="text-sm text-gray-600">Le: {{ $photo->published_at->format('d/m/Y H:i') }}</p>

            @if($photo->user->phone_number)
                <div class="mt-4">
                    <a href="{{ $photo->whatsapp_link }}" 
                       target="_blank" 
                       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center justify-center transition duration-300">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Contacter via WhatsApp
                    </a>
                </div>
            @endif
            
            @auth
                @if (Auth::check() && (Auth::user()->isAdmin() || $photo->user_id === Auth::id()))
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('photos.edit', $photo) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Modifier</a>
                        <form action="{{ route('photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette photo ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Supprimer</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
        <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-600">Retour à la liste</a>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const photoContainer = document.querySelector('.bg-white');
            photoContainer.classList.add('ring-2', 'ring-blue-500');
        });
    </script>
@endsection