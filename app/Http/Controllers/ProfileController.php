<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $passwordFieldsFilled = $request->filled('current_password')
            || $request->filled('password')
            || $request->filled('password_confirmation');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ];

        if ($passwordFieldsFilled) {
            $rules['current_password'] = [
                'required',
                'current_password',
            ];

            $rules['password'] = [
                'required',
                'string',
                'min:8',
                'confirmed',
            ];

            $rules['password_confirmation'] = [
                'required',
                'string',
            ];
        }

        $validated = $request->validate($rules, [
            'current_password.required' =>
                'Password lama wajib diisi.',
            'current_password.current_password' =>
                'Password lama yang kamu masukkan tidak sesuai.',
            'password.required' =>
                'Password baru wajib diisi.',
            'password.min' =>
                'Password baru minimal 8 karakter.',
            'password.confirmed' =>
                'Konfirmasi password baru tidak cocok.',
            'password_confirmation.required' =>
                'Konfirmasi password baru wajib diisi.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($passwordFieldsFilled) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'current_password.current_password' =>
                'Password lama yang kamu masukkan tidak sesuai.',
            'password.min' =>
                'Password baru minimal 8 karakter.',
            'password.confirmed' =>
                'Konfirmasi password baru tidak cocok.',
        ]);

        $user = $request->user();

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()
            ->route('profile.show')
            ->with('password_success', 'Password berhasil diubah.');
    }
}
