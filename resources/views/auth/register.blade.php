@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Creer votre profil</h2>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="first_name" class="block text-sm font-medium">Prénom</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="w-full border p-2 rounded @error('first_name') border-red-500 @enderror" required>
                @error('first_name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="last_name" class="block text-sm font-medium">Nom</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="w-full border p-2 rounded @error('last_name') border-red-500 @enderror" required>
                @error('last_name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border p-2 rounded @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="phone_number" class="block text-sm font-medium">Numéro de téléphone</label>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" class="w-full border p-2 rounded @error('phone_number') border-red-500 @enderror" required>
                @error('phone_number')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="profile_photo" class="block text-sm font-medium">Photo de profil (facultatif)</label>
                <input type="file" name="profile_photo" id="profile_photo" class="w-full border p-2 rounded @error('profile_photo') border-red-500 @enderror" accept="image/*">
                @error('profile_photo')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Mot de passe</label>
                <input type="password" name="password" id="password" class="w-full border p-2 rounded @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border p-2 rounded">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">S'inscrire</button>
        </form>
    </div>
@endsection