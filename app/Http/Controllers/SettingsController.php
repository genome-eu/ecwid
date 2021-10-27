<?php

namespace App\Http\Controllers;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index_html');
    }

    public function functionsJs()
    {
        return response(view(
            'settings.functions_js',
            ['ecwid_client_id' => env('ECWID_CLIENT_ID')]
        ))->header('Content-Type', 'application/javascript');
    }
}
