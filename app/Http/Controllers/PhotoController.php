<?php
namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index(Request $request)
    {
        $query = Photo::with('user', 'category')
                      ->where('status', 'approved')
                      ->orderBy('published_at', 'desc');

        if ($author = $request->input('author')) {
            $query->whereHas('user', function ($q) use ($author) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$author%"]);
            });
        }
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($date = $request->input('date')) {
            $query->whereDate('published_at', $date);
        }

        $photos = $query->latest()->paginate(9);
        $categories = Category::all();
        return view('home', compact('photos', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('photos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('home')->with('error', 'Vous devez être connecté pour publier une photo.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string|max:1000',
            'prix' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $path = $request->file('image')->store('photos', 'public');
        $status = Auth::user()->isAdmin() ? 'approved' : 'pending';

        Photo::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'image_path' => $path,
            'description' => $validated['description'],
            'published_at' => now(),
            'prix' => $validated['prix'],
            'category_id' => $validated['category_id'],
            'status' => $status,
        ]);

        $message = Auth::user()->isAdmin()
            ? 'Photo publiée avec succès.'
            : 'Votre publication est en cours de validation de la part de l\'administrateur.';

        return redirect()->route('home')->with('success', $message);
    }

    public function validations()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        $photos = Photo::with('user', 'category')
                       ->where('status', 'pending')
                       ->latest()
                       ->get();

        return view('photos.validations', compact('photos'));
    }

    // public function approve(Photo $photo)
    // {
    //     if (!Auth::check() || !Auth::user()->isAdmin()) {
    //         return redirect()->route('home')->with('error', 'Accès non autorisé.');
    //     }

    //     $photo->update(['status' => 'approved']);

    //     return redirect()->route('photos.validations')->with('success', 'Photo validée avec succès.');
    // }

    // public function reject(Photo $photo)
    // {
    //     if (!Auth::check() || !Auth::user()->isAdmin()) {
    //         return redirect()->route('home')->with('error', 'Accès non autorisé.');
    //     }

    //     Storage::disk('public')->delete($photo->image_path);
    //     $photo->delete();

    //     return redirect()->route('photos.validations')->with('success', 'Photo refusée et supprimée.');
    // }

     public function approve(Photo $photo)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }

        $photo->update(['status' => 'approved']);

        return response()->json(['success' => 'Photo validée avec succès.']);
    }

    public function reject(Photo $photo)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }

        Storage::disk('public')->delete($photo->image_path);
        $photo->delete();

        return response()->json(['success' => 'Photo refusée et supprimée.']);
    }

    public function edit(Photo $photo)
    {
        if (!Auth::check() || (!Auth::user()->isAdmin() && $photo->user_id !== Auth::id())) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }
        $categories = Category::all();
        return view('photos.edit', compact('photo', 'categories'));
    }

    public function update(Request $request, Photo $photo)
    {
        if (!Auth::check() || (!Auth::user()->isAdmin() && $photo->user_id !== Auth::id())) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string|max:1000',
            'prix' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($photo->image_path);
            $validated['image_path'] = $request->file('image')->store('photos', 'public');
        } else {
            $validated['image_path'] = $photo->image_path;
        }

         // Si la photo était déjà approuvée, elle reste approuvée pour tous les utilisateurs
        $status = $photo->status === 'approved' ? 'approved' : (Auth::user()->isAdmin() ? 'approved' : 'pending');
        $photo->update([
            'title' => $validated['title'],
            'image_path' => $validated['image_path'],
            'description' => $validated['description'],
            'published_at' => now(),
            'prix' => $validated['prix'],
            'category_id' => $validated['category_id'],
            'status' => $status,
        ]);

       $message = $status === 'approved'
            ? 'Photo mise à jour avec succès.'
            : 'Votre mise à jour est en cours de validation de la part de l\'administrateur.';

        return redirect()->route('home')->with('success', $message);
    }

    public function destroy(Photo $photo)
    {
        if (!Auth::check() || (!Auth::user()->isAdmin() && $photo->user_id !== Auth::id())) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        Storage::disk('public')->delete($photo->image_path);
        $photo->delete();

        return redirect()->route('home')->with('success', 'Photo supprimée avec succès.');
    }

    public function show(Photo $photo)
    {
        if ($photo->status !== 'approved' && (!Auth::check() || !Auth::user()->isAdmin())) {
            return redirect()->route('home')->with('error', 'Photo non disponible.');
        }
        return view('photos.show', compact('photo'));
    }
}