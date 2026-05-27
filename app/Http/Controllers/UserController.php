<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. KELOLA DATA PETUGAS (CRUD)
    public function indexPetugas() {
        $petugas = User::where('role', 'petugas')->get();
        return view('admin.petugas.index', compact('petugas'));
    }

    public function storePetugas(Request $request) {
        $request->validate([
            'Username' => 'required|unique:user,Username|max:255',
            'Password' => 'required|min:5',
            'Email' => 'required|email|unique:user,Email',
            'NamaLengkap' => 'required|max:255',
            'Alamat' => 'required',
        ]);

        User::create([
            'Username' => $request->Username,
            'Password' => Hash::make($request->Password),
            'Email' => $request->Email,
            'NamaLengkap' => $request->NamaLengkap,
            'Alamat' => $request->Alamat,
            'role' => 'petugas', // Dikunci sebagai petugas
        ]);

        return back()->with('success', 'Petugas baru berhasil ditambahkan!');
    }

  // 2. KELOLA DATA USER/ANGGOTA (RUD)
    public function indexUser() {
        // KITA GANTI 'user' JADI 'peminjam' BIAR SISWANYA MUNCUL!
        $users = User::where('role', 'peminjam')->get();
        
        return view('admin.user.anggota', compact('users'));
    }

    // 3. FITUR UPDATE & DELETE BERSAMA
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        
        $request->validate([
            'Email' => 'required|email|unique:user,Email,'.$id.',UserID',
            'NamaLengkap' => 'required|max:255',
            'Alamat' => 'required',
        ]);

        $data = [
            'Email' => $request->Email,
            'NamaLengkap' => $request->NamaLengkap,
            'Alamat' => $request->Alamat,
        ];

        // Jika form password diisi, maka password lama diganti
        if ($request->filled('Password')) {
            $data['Password'] = Hash::make($request->Password);
        }

        $user->update($data);
        return back()->with('success', 'Data akun berhasil diperbarui!');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Akun berhasil dihapus!');
    }
}