@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Validations des publications</h1>
        @if ($photos->isEmpty())
            <p class="text-gray-600">Aucune photo en attente de validation.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($photos as $photo)
                    <div class="bg-white rounded shadow p-4 relative">
                        <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->title }}" class="w-full h-64 object-cover rounded">
                        <h3 class="mt-2 font-bold">{{ $photo->title }}</h3>
                        <p class="mt-1">{{ $photo->description }}</p>
                        <p class="text-sm text-gray-600">Prix: {{ number_format($photo->prix, 0, ',', ' ') }} FCFA</p>
                        <p class="text-sm text-gray-600">Catégorie: {{ $photo->category ? $photo->category->name : 'Aucune' }}</p>
                        <p class="text-sm text-gray-600">
                            Publié par:
                            <img src="{{ $photo->user->profile_photo_url }}" alt="Profil" class="inline-block w-6 h-6 rounded-full mr-2">
                            {{ $photo->user->first_name }} {{ $photo->user->last_name }}
                        </p>
                        <p class="text-sm text-gray-600">Téléphone: {{ $photo->user->phone_number }}</p>
                        <p class="text-sm text-gray-600">Soumis le: {{ $photo->published_at->format('d/m/Y H:i') }}</p>
                        <div class="mt-4 flex gap-2">
                            <button type="button" class="bg-green-500 text-white px-3 py-1 rounded approve-btn" data-id="{{ $photo->id }}" data-url="{{ route('photos.approve', $photo) }}">Valider</button>
                            <button type="button" class="bg-red-500 text-white px-3 py-1 rounded reject-btn" data-id="{{ $photo->id }}" data-url="{{ route('photos.reject', $photo) }}">Refuser</button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Modal Bootstrap -->
        <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="actionModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="actionModalBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="modalOkBtn">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const approveButtons = document.querySelectorAll('.approve-btn');
            const rejectButtons = document.querySelectorAll('.reject-btn');
            const modal = new bootstrap.Modal(document.getElementById('actionModal'));
            const modalTitle = document.getElementById('actionModalLabel');
            const modalBody = document.getElementById('actionModalBody');
            const modalOkBtn = document.getElementById('modalOkBtn');

            // Fonction pour gérer les requêtes AJAX
            function sendRequest(url, method, callback) {
                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => callback(data))
                .catch(error => {
                    modalTitle.textContent = 'Erreur';
                    modalBody.textContent = 'Une erreur est survenue. Veuillez réessayer.';
                    modalBody.className = 'modal-body text-danger';
                    modal.show();
                });
            }

            // Gestion des boutons "Valider"
            approveButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const url = this.getAttribute('data-url');
                    sendRequest(url, 'POST', function (data) {
                        if (data.success) {
                            modalTitle.textContent = 'Succès';
                            modalBody.textContent = data.success;
                            modalBody.className = 'modal-body text-success';
                            modal.show();
                        } else {
                            modalTitle.textContent = 'Erreur';
                            modalBody.textContent = data.error || 'Accès non autorisé.';
                            modalBody.className = 'modal-body text-danger';
                            modal.show();
                        }
                    });
                });
            });

            // Gestion des boutons "Refuser"
            rejectButtons.forEach(button => {
                button.addEventListener('click', function () {
                    if (confirm('Voulez-vous vraiment refuser et supprimer cette photo ?')) {
                        const url = this.getAttribute('data-url');
                        sendRequest(url, 'POST', function (data) {
                            if (data.success) {
                                modalTitle.textContent = 'Succès';
                                modalBody.textContent = data.success;
                                modalBody.className = 'modal-body text-danger';
                                modal.show();
                            } else {
                                modalTitle.textContent = 'Erreur';
                                modalBody.textContent = data.error || 'Accès non autorisé.';
                                modalBody.className = 'modal-body text-danger';
                                modal.show();
                            }
                        });
                    }
                });
            });

            // Recharger la page après clic sur "OK"
            modalOkBtn.addEventListener('click', function () {
                window.location.reload();
            });
        });
    </script>
@endsection