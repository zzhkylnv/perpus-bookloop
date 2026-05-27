<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        // Hanya mengambil user yang role-nya 'peminjam' (Siswa)
        $anggota = User::where('role', 'peminjam')->get();
        // Diarahkan ke file resources/views/admin/user/anggota.blade.php
        return view('user.anggota', compact('anggota'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Username' => 'required|string|max:255|unique:user',
            'Email' => 'required|string|email|max:255|unique:user',
            'Password' => 'required|string|min:6',
            'Alamat' => 'required|string',
        ]);

        User::create([
            'NamaLengkap' => $request->NamaLengkap,
            'Username' => $request->Username,
            'Email' => $request->Email,
            'Password' => Hash::make($request->Password),
            'Alamat' => $request->Alamat,
            'role' => 'peminjam',
        ]);

        return back()->with('success', 'Anggota baru berhasil didaftarkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Username' => 'required|string|max:255|unique:user,Username,' . $id . ',UserID',
            'Email' => 'required|string|email|max:255|unique:user,Email,' . $id . ',UserID',
            'Alamat' => 'required|string',
        ]);

        $user->NamaLengkap = $request->NamaLengkap;
        $user->Username = $request->Username;
        $user->Email = $request->Email;
        $user->Alamat = $request->Alamat;

        if ($request->filled('Password')) {
            $request->validate(['Password' => 'string|min:6']);
            $user->Password = Hash::make($request->Password);
        }

        $user->save();

        return back()->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Data anggota berhasil dihapus!');
    }
}