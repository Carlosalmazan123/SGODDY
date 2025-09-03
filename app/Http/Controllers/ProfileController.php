<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    { $user = Auth::user();
        return view('profile.edit', compact('user')
        );
    }

    /**
     * Update the user's profile information.
     */
    

     public function update(Request $request)
     {
         /** @var \App\Models\User $user **/
         $user = Auth::user(); // Obtener el usuario autenticado
     
         $request->validate([
             'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validar imagen
         ]);
     
         // Si se sube una nueva imagen
         if ($request->hasFile('image')) {
             // Eliminar la imagen anterior si existe
             if ($user->image) {
                 Storage::disk('public')->delete($user->image);
             }
     
             // Obtener la extensión del archivo
             $extension = $request->file('image')->getClientOriginalExtension();
     
             // Generar un nuevo nombre basado en la fecha y hora
             $imageName = now()->format('Ymd_His') . '.' . $extension;
     
             // Guardar la nueva imagen en storage/app/public/users con el nuevo nombre
             $imagePath = $request->file('image')->storeAs('users', $imageName, 'public');
     
             // Guardar la ruta en la base de datos
             $user->image = $imagePath;
         }
     
         $user->save();
     
         return redirect()->back()->with('success', 'Imagen actualizada correctamente');
     }
     



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
