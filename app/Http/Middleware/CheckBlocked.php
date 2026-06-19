<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBlocked {
    public function handle(Request $request, Closure $next) {
        if (Auth::check() && Auth::user()->is_blocked) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect('/login')->withErrors(['email' => 'Ваш аккаунт заблокирован администратором.']);
        }
        return $next($request);
    }
}
