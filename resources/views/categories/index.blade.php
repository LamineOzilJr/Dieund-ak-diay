@extends('layouts.app')

     @section('content')
         <div class="container mx-auto p-4">
             <h1 class="text-2xl font-bold mb-4">Gestion des catégories</h1>
             @if (session('success'))
                 <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                     {{ session('success') }}
                 </div>
             @endif
             <a href="{{ route('categories.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">Ajouter une catégorie</a>
             <table class="w-full bg-white rounded shadow">
                 <thead>
                     <tr>
                         <th class="p-2 text-left">Nom</th>
                         <th class="p-2 text-left">Actions</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($categories as $category)
                         <tr>
                             <td class="p-2">{{ $category->name }}</td>
                             <td class="p-2 flex gap-2">
                                 <a href="{{ route('categories.edit', $category) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Modifier</a>
                                 <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
                                     @csrf
                                     @method('DELETE')
                                     <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Supprimer</button>
                                 </form>
                             </td>
                         </tr>
                     @endforeach
                 </tbody>
             </table>
         </div>
     @endsection