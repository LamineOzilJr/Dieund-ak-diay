{{-- @extends('layouts.app')

   @section('content')
       <div class="container mx-auto p-4 max-w-md">
           <h1 class="text-2xl font-bold mb-4">Détails de la photo</h1>
           <div class="bg-white rounded shadow p-4 relative">
               <img src="{{ Storage::url($photo->image_path) }}" alt="Photo" class="w-full h-64 object-cover rounded">
               @if($photo->user->phone_number)
                   <a href="{{ $photo->whatsapp_link }}" target="_blank" class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow hover:bg-green-100 transition" title="Contacter via WhatsApp">
                       <img src="{{ asset('images/whatsapp.png') }}" alt="WhatsApp" class="w-6 h-6">
                   </a>
               @endif
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
           <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-600">Retour à la liste</a>
       </div>
   @section('scripts')
       <script>
           // Optionnel : Ajouter un effet visuel pour la sélection
           document.addEventListener('DOMContentLoaded', () => {
               const photoContainer = document.querySelector('.bg-white');
               photoContainer.classList.add('ring-2', 'ring-blue-500');
           });
       </script>
   @endsection
   @endsection --}}

   @extends('layouts.app')

   @section('content')
       <div class="container mx-auto p-4 max-w-md">
           <h1 class="text-2xl font-bold mb-4">{{ $photo->title }}</h1>
           <div class="bg-white rounded shadow p-4 relative">
               <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->title }}" class="w-full h-64 object-cover rounded">
               @if($photo->user->phone_number)
                   {{-- <a href="{{ $photo->whatsapp_link }}" target="_blank" class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow hover:bg-green-100 transition" title="Contacter via WhatsApp">
                       <img src="{{ asset('storage/images/whatsapp.png') }}" alt="WhatsApp" class="w-6 h-6">
                   </a> --}}
               @endif
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
           <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-600">Retour à la liste</a>
       </div>
       @section('scripts')
           <script>
               document.addEventListener('DOMContentLoaded', () => {
                   const photoContainer = document.querySelector('.bg-white');
                   photoContainer.classList.add('ring-2', 'ring-blue-500');
               });
           </script>
       @endsection
   @endsection