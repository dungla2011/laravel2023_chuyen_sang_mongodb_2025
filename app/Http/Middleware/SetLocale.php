<?php
// app/Http/Middleware/SetLocale.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->route('locale') ?? 'en'; // Default locale is 'en'
        if (!in_array($locale, ['en', 'vi'])) { // Enforce supported locales
            abort(404); // Or handle the error as needed
        }
        App::setLocale($locale);
        return $next($request);
    }
}
