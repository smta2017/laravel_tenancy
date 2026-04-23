<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->get('locale', $request->header('X-Locale', 'en'));
        app()->setLocale($locale);
        
        $translations = [
            'users' => (array) Lang::get('users', [], $locale),
            'roles' => (array) Lang::get('roles', [], $locale),
            'menu' => (array) Lang::get('menu', [], $locale),
            'common' => (array) Lang::get('crud', [], $locale),
        ];

        return $this->sendResponse($translations, 'Translations retrieved successfully');
    }
}
