<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin() || $user->isGestionnaire()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('employee.dashboard');
        }

        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin() || $user->isGestionnaire()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('employee.dashboard');
        }

        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->isAdmin() || $user->isGestionnaire()) {
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->intended(route('employee.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'matricule_solde' => ['required', 'string'],
            'lieu_affectation' => ['required', 'string'],
            'date_prise_service' => ['required', 'date'],
        ]);

        $agent = Agent::where('matricule_solde', $request->matricule_solde)->first();

        if (!$agent) {
            $agent = Agent::create([
                'matricule_solde' => $request->matricule_solde,
                'nom' => $request->name,
                'prenom' => '',
                'lieu_affectation' => $request->lieu_affectation,
                'type_agent' => 'titulaire',
                'nombre_enfants' => 0,
                'date_prise_service' => $request->date_prise_service,
                'jours_conges_dus' => 24,
                'jours_reportes' => 0,
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'agent_id' => $agent->id,
        ]);

        if (Auth::login($user)) {
            return redirect()->route('employee.dashboard');
        }

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
