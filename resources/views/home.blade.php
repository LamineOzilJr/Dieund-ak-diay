{{-- @extends('layouts.app')

@section('content')
    <div class="mb-8">
        <form method="GET" class="flex flex-wrap gap-4">
            <input type="text" name="author" value="{{ request('author') }}" placeholder="Filtrer par auteur" class="border p-2 rounded">
            <input type="date" name="date" value="{{ request('date') }}" class="border p-2 rounded">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filtrer</button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($photos as $photo)
            <div class="bg-white rounded shadow p-4">
                <img src="{{ Storage::url($photo->image_path) }}" alt="Photo" class="w-full h-64 object-cover rounded">
                <p class="mt-2">{{ $photo->description }}</p>
                <p class="text-sm text-gray-600">Prix: {{ number_format($photo->prix, 0, ',', ' ') }} FCFA</p>
                <p class="text-sm text-gray-600">
                    Publié par: {{ $photo->user->first_name }} {{ $photo->user->last_name }} 
                </p>
                <p>
                    Telephone: {{ $photo->user->phone_number }}
                </p>
                <p class="text-sm text-gray-600">Le: {{ $photo->published_at->format('d/m/Y H:i') }}</p>
                    @auth
                    @if ($photo->user_id === Auth::id())
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
        @endforeach
    </div>

    <div class="mt-8">
        {{ $photos->links() }}
    </div>
@endsection --}}



{{-- @extends('layouts.app')

@section('content')
    <div class="mb-8">
        <form method="GET" class="flex flex-wrap gap-4">
            <input type="text" name="author" value="{{ request('author') }}" placeholder="Filtrer par auteur" class="border p-2 rounded">
            <input type="date" name="date" value="{{ request('date') }}" class="border p-2 rounded">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filtrer</button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($photos as $photo)
            <div class="bg-white rounded shadow p-4 relative">
                <div class="relative">
                    <img src="{{ Storage::url($photo->image_path) }}" alt="Photo" class="w-full h-64 object-cover rounded">
                    @if($photo->user->phone_number)
                        <a href="{{ $photo->whatsapp_link }}" target="_blank" class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow hover:bg-green-100 transition" title="Contacter via WhatsApp">
                            <img src="{{ asset('/storage/images/whatsapp.png') }}" alt="WhatsApp" class="w-6 h-6">
                        </a>
                    @endif
                </div>
                <p class="mt-2">{{ $photo->description }}</p>
                <p class="text-sm text-gray-600">Prix: {{ number_format($photo->prix, 0, ',', ' ') }} FCFA</p>
                <p class="text-sm text-gray-600">
                    Publié par: 
                    <img src="{{ $photo->user->profile_photo_url }}" alt="Profil" class="inline-block w-6 h-6 rounded-full mr-2">
                    {{ $photo->user->first_name }} {{ $photo->user->last_name }} 
                </p>
                <p>Telephone: {{ $photo->user->phone_number }}</p>
                <p class="text-sm text-gray-600">Le: {{ $photo->published_at->format('d/m/Y H:i') }}</p>
                @auth
                    @if ($photo->user_id === Auth::id())
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
        @endforeach
    </div>

    <div class="mt-8">
        {{ $photos->links() }}
    </div>
@endsection --}}

@extends('layouts.app')

   @section('content')
       <div class="mb-8">
           <form method="GET" class="flex flex-wrap gap-4">
               <input type="text" name="author" value="{{ request('author') }}" placeholder="Rechercher vendeur(se)" class="border p-2 rounded">
               <input type="text" name="title" value="{{ request('title') }}" placeholder="Rechercher article" class="border p-2 rounded">
               <select name="category" class="border p-2 rounded">
                   <option value="">Toutes les catégories</option>
                   @foreach ($categories as $category)
                       <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                   @endforeach
               </select>
               <input type="date" name="date" value="{{ request('date') }}" class="border p-2 rounded">
               <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filtrer</button>
           </form>
       </div>

       <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
           @foreach ($photos as $photo)
               <div class="bg-white rounded shadow p-4 relative {{ request('photo_id') == $photo->id ? 'ring-2 ring-blue-500' : '' }}" data-photo-id="{{ $photo->id }}">
                   <div class="relative">
                       <a href="{{ route('photos.show', $photo) }}">
                           <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->title }}" class="w-full h-64 object-cover rounded">
                       </a>
                       @if($photo->user->phone_number)
                           <a href="{{ $photo->whatsapp_link }}" target="_blank" class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow hover:bg-green-100 transition" title="Contacter via WhatsApp">
                               <img src="{{ asset('storage/images/whatsapp.png') }}" alt="WhatsApp" class="w-6 h-6">
                           </a>
                       @endif
                   </div>
                   <h3 class="mt-2 font-bold">{{ $photo->title }}</h3>
                   <p class="mt-1">{{ $photo->description }}</p>
                   <p class="text-sm text-gray-600">Prix: {{ number_format($photo->prix, 0, ',', ' ') }} FCFA</p>
                   <p class="text-sm text-gray-600">Catégorie: {{ $photo->category ? $photo->category->name : 'Aucune' }}</p>
                   <p class="text-sm text-gray-600">
                       Vendeur(se): 
                       <img src="{{ $photo->user->profile_photo_url }}" alt="Profil" class="inline-block w-6 h-6 rounded-full mr-2">
                       {{ $photo->user->first_name }} {{ $photo->user->last_name }} 
                   </p>
                   <p>Telephone: {{ $photo->user->phone_number }}</p>
                   <p class="text-sm text-gray-600">Le: {{ $photo->published_at->format('d/m/Y H:i') }}</p>
                   @auth
                       {{-- @if ($photo->user_id === Auth::id()) --}}
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
           @endforeach
       </div>

       <div class="mt-8">
           {{ $photos->links() }}
       </div>

       @section('scripts')
           <script>
               document.addEventListener('DOMContentLoaded', () => {
                   const photoId = {{ request('photo_id') ?? 'null' }};
                   if (photoId) {
                       const photoElement = document.querySelector(`[data-photo-id="${photoId}"]`);
                       if (photoElement) {
                           photoElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                       }
                   }
               });
           </script>
       @endsection
   @endsection