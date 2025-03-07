<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    // Les tableaux des providers autorisés
    protected $providers = ["facebook", "google"];

    # La vue pour les liens vers les providers
    public function loginRegister()
    {
        return view("auth.register");
    }

    # redirection vers le provider
    public function redirect(Request $request, $provider)
    {
        // Log the provider for debugging
        Log::debug('Provider received:', ['provider' => $provider]);

        // Check if provider is null or empty
        if (!$provider) {
            abort(404, 'Provider not specified');
        }

        // On vérifie si le provider est autorisé
        if (in_array($provider, $this->providers)) {
            return Socialite::driver($provider)->redirect();
        }

        abort(404, 'Invalid provider');
    }

    public function callback(Request $request, $provider)
    {
        try {
            // Verify provider is valid
            if (!in_array($provider, $this->providers)) {
                abort(404, 'Invalid provider');
            }

            // Les informations provenant du provider
            $data = Socialite::driver($provider)->user();

            # Social login - register
            $email = $data->getEmail();
            $name = $data->getName();

            # 1. On récupère l'utilisateur à partir de l'adresse email
            $user = User::where("email", $email)->first();

            # 2. Si l'utilisateur existe
            if ($user) {
                // Mise à jour des informations de l'utilisateur
                $user->name = $name;
                $user->save();
            } else {
                # 3. Si l'utilisateur n'existe pas, on l'enregistre
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'role' => 'passenger', // Default role
                    'password' => bcrypt(Str::random(16)) // Generate secure random password
                ]);
            }

            # 4. On connecte l'utilisateur
            Auth::login($user);

            # 5. On redirige l'utilisateur vers le tableau de bord approprié
            if ($user->role === 'driver') {
                return redirect()->route('dashboarddriver');
            } else {
                return redirect()->route('dashboard');
            }

        } catch (\Exception $e) {
            Log::error('Socialite error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'فشلت عملية المصادقة. يرجى المحاولة مرة أخرى.');
        }
    }
}