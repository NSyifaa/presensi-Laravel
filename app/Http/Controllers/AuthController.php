<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAuthVerifyRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    
    public function verify(UserAuthVerifyRequest $request)
    {
        $data = $request->validated();
        if (Auth::guard('admin')->attempt(['username' => $data['username'], 'password' => $data['password'], 'role' => 'admin'])) {
            $request->session()->regenerate();
            return redirect()->route('a.dashboard');
        } else if (Auth::guard('guru')->attempt(['username' => $data['username'], 'password' => $data['password'], 'role' => 'guru'])) {
            $request->session()->regenerate();
            return redirect()->route('g.dashboard');
        } else if (Auth::guard('siswa')->attempt(['username' => $data['username'], 'password' => $data['password'], 'role' => 'siswa'])) {
            $request->session()->regenerate();
            return redirect()->route('s.dashboard');
        } else {
            return redirect()->back()->with('loginError', 'Username atau password salah.');
        }
    }
    
    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else if (Auth::guard('guru')->check()) {
            Auth::guard('guru')->logout();
        } else if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        }
        return redirect()->route('login');
        
    }
    public function ganti_password()
    {
        $user = Auth::user();
        return view('auth.pw', compact('user'));
    }
    public function update_password(Request $request, string $id)
    {
        $request->validate([
            'new_password' => 'required',
            'new_password_confirmation' => 'required|same:new_password',
        ]);
        
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->input('new_password'));
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diubah',
        ]);
        
    }
}
