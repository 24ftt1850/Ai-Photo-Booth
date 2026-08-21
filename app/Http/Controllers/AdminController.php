<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Login Page
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        if (session('admin_authenticated') === true) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Login
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);


        $adminEmail =
            env('RUPAVUE_ADMIN_EMAIL');

        $adminPassword =
            env('RUPAVUE_ADMIN_PASSWORD');


        /*
        |--------------------------------------------------------------------------
        | Check credentials
        |--------------------------------------------------------------------------
        */

        if (
            $request->email !== $adminEmail ||
            $request->password !== $adminPassword
        ) {
            return back()
                ->withInput(
                    $request->only('email')
                )
                ->withErrors([
                    'email' =>
                        'Invalid administrator credentials.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Create authenticated session
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        session([
            'admin_authenticated' => true,
            'admin_email' => $adminEmail,
        ]);


        return redirect()->route(
            'admin.dashboard'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        /*
        |--------------------------------------------------------------------------
        | Temporary Statistics
        |--------------------------------------------------------------------------
        |
        | These values are temporary.
        | They will later come from MySQL.
        |
        */

        $stats = [

            // Users
            'total_users' => 0,

            // Sessions
            'total_sessions' => 0,

            // AI generation
            'total_generated_images' => 0,
            'total_successful_generations' => 0,
            'total_failed_generations' => 0,

            // Themes
            'total_themes' => 3,

            // Events
            'total_events' => 0,

            // Activity
            'total_downloads' => 0,
            'total_prints' => 0,
            'total_qr_scans' => 0,

            // Feedback
            'average_rating' => '—',
        ];


        /*
        |--------------------------------------------------------------------------
        | Most Popular Theme
        |--------------------------------------------------------------------------
        */

        $mostPopularTheme = (object) [
            'name' => 'No data yet',
            'generated_images_count' => 0,
        ];


        /*
        |--------------------------------------------------------------------------
        | Most Used Event
        |--------------------------------------------------------------------------
        */

        $mostUsedEvent = (object) [
            'name' => 'No data yet',
            'sessions_count' => 0,
        ];

        /*
        |--------------------------------------------------------------------------
        | Theme Statistics
        |--------------------------------------------------------------------------
        */

        $themeStats = [

            [
                'name' => 'Graduation',
                'generated' => 0,
            ],

            [
                'name' => 'Spider-Man',
                'generated' => 0,
            ],

            [
                'name' => 'Mafia',
                'generated' => 0,
            ],

        ];

        /*
        |--------------------------------------------------------------------------
        | Temporary Generation Statistics
        |--------------------------------------------------------------------------
        */

        $generationStats = [
            'completed' => 0,
            'failed' => 0,
            'pending' => 0,
        ];

        /*
        |--------------------------------------------------------------------------
        | Temporary Recent Events
        |--------------------------------------------------------------------------
        */

        $recentEvents = collect();


        /*
        |--------------------------------------------------------------------------
        | Temporary Feedback
        |--------------------------------------------------------------------------
        */

        $recentFeedback = collect();


        /*
        |--------------------------------------------------------------------------
        | Send Data To Dashboard
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            [
                'stats' => $stats,

                'mostPopularTheme' =>
                    $mostPopularTheme,

                'mostUsedEvent' =>
                    $mostUsedEvent,

                'themeStats' =>
                    $themeStats,

                'generationStats' =>
                    $generationStats,

                'recentEvents' =>
                    $recentEvents,

                'recentFeedback' =>
                    $recentFeedback,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Logout
    |--------------------------------------------------------------------------
    */

    public function logout(
        Request $request
    ) {
        $request->session()->forget([
            'admin_authenticated',
            'admin_email',
        ]);


        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()->route(
            'admin.login'
        );
    }
}