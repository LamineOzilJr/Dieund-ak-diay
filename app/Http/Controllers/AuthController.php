<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:20|unique:users',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone_number' => $validated['phone_number'],
        ];

        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = storage_path('app/public/profiles/' . $filename);

            // Resize image using GD
            $source = null;
            switch ($image->getClientMimeType()) {
                case 'image/jpeg':
                    $source = imagecreatefromjpeg($image->getPathname());
                    break;
                case 'image/png':
                    $source = imagecreatefrompng($image->getPathname());
                    break;
            }

            if ($source) {
                // Create a 150x150 canvas
                $thumb = imagecreatetruecolor(150, 150);

                // Preserve transparency for PNG
                if ($image->getClientMimeType() === 'image/png') {
                    imagealphablending($thumb, false);
                    imagesavealpha($thumb, true);
                    $transparent = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
                    imagefill($thumb, 0, 0, $transparent);
                }

                // Get original dimensions
                $width = imagesx($source);
                $height = imagesy($source);

                // Calculate aspect ratio to fit 150x150
                $ratio = min(150 / $width, 150 / $height);
                $newWidth = (int)($width * $ratio);
                $newHeight = (int)($height * $ratio);
                $x = (int)((150 - $newWidth) / 2);
                $y = (int)((150 - $newHeight) / 2);

                // Resize and copy to canvas
                imagecopyresampled($thumb, $source, $x, $y, 0, 0, $newWidth, $newHeight, $width, $height);

                // Save the image
                if ($image->getClientMimeType() === 'image/jpeg') {
                    imagejpeg($thumb, $path, 90);
                } else {
                    imagepng($thumb, $path);
                }

                // Free memory
                imagedestroy($source);
                imagedestroy($thumb);

                $data['profile_photo'] = 'profiles/' . $filename;
            }
        }

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone_number' => $validated['phone_number'],
            'profile_photo' => $data['profile_photo'] ?? null,
        ]);

        return redirect()->route('login')->with('email', $validated['email']);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']]) ||
            Auth::attempt(['phone_number' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}