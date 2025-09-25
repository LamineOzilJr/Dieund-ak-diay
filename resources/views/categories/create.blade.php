@extends('layouts.app')

     @section('content')
         <div class="max-w-md mx-auto bg-white p-8 rounded shadow">
             <h2 class="text-2xl font-bold mb-6 text-center">Ajouter une catégorie</h2>
             <form method="POST" action="{{ route('categories.store') }}">
                 @csrf
                 <div class="mb-4">
                     <label for="name" class="block text-sm font-medium">Nom de la catégorie</label>
                     <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border p-2 rounded @error('name') border-red-500 @enderror" required>
                     @error('name')
                         <p class="text-red-500 text-sm">{{ $message }}</p>
                     @enderror
                 </div>
                 <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Créer</button>
             </form>
         </div>
     @endsection