{{-- @extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Publier un article</h2>
        <form method="POST" action="{{ route('photos.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium">Photo</label>
                <input type="file" name="image" id="image" class="w-full border p-2 rounded @error('image') border-red-500 @enderror" required>
                @error('image')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium">Description</label>
                <textarea name="description" id="description" class="w-full border p-2 rounded @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="prix" class="block text-sm font-medium">Prix (FCFA)</label>
                <input type="number" name="prix" id="prix" value="{{ old('prix') }}" class="w-full border p-2 rounded @error('prix') border-red-500 @enderror" min="0" step="1" required>
                @error('prix')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Publier</button>
        </form>
    </div>
@endsection --}}

@extends('layouts.app')

   @section('content')
       <div class="max-w-md mx-auto bg-white p-8 rounded shadow">
           <h2 class="text-2xl font-bold mb-6 text-center">Publier une photo</h2>
           <form method="POST" action="{{ route('photos.store') }}" enctype="multipart/form-data">
               @csrf
               <div class="mb-4">
                   <label for="title" class="block text-sm font-medium">Titre</label>
                   <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full border p-2 rounded @error('title') border-red-500 @enderror" required>
                   @error('title')
                       <p class="text-red-500 text-sm">{{ $message }}</p>
                   @enderror
               </div>
               <div class="mb-4">
                   <label for="image" class="block text-sm font-medium">Image</label>
                   <input type="file" name="image" id="image" class="w-full border p-2 rounded @error('image') border-red-500 @enderror" accept="image/*" required>
                   @error('image')
                       <p class="text-red-500 text-sm">{{ $message }}</p>
                   @enderror
               </div>
               <div class="mb-4">
                   <label for="description" class="block text-sm font-medium">Description (facultatif)</label>
                   <textarea name="description" id="description" class="w-full border p-2 rounded @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                   @error('description')
                       <p class="text-red-500 text-sm">{{ $message }}</p>
                   @enderror
               </div>
               <div class="mb-4">
                   <label for="prix" class="block text-sm font-medium">Prix (FCFA)</label>
                   <input type="number" name="prix" id="prix" value="{{ old('prix') }}" class="w-full border p-2 rounded @error('prix') border-red-500 @enderror" required>
                   @error('prix')
                       <p class="text-red-500 text-sm">{{ $message }}</p>
                   @enderror
               </div>
               <div class="mb-4">
                   <label for="category_id" class="block text-sm font-medium">Catégorie (facultatif)</label>
                   <select name="category_id" id="category_id" class="w-full border p-2 rounded @error('category_id') border-red-500 @enderror">
                       <option value="">Aucune catégorie</option>
                       @foreach ($categories as $category)
                           <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                       @endforeach
                   </select>
                   @error('category_id')
                       <p class="text-red-500 text-sm">{{ $message }}</p>
                   @enderror
               </div>
               <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Publier</button>
           </form>
       </div>
   @endsection