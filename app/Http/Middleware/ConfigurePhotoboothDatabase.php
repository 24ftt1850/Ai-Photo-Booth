<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ConfigurePhotoboothDatabase
{
    /**
     * Apply the database connection selected in the Setup page for this session.
     * If remote mode is not selected, Laravel keeps using its normal .env config.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $remote = $request->session()->get('setup.remote');
        $mode = $request->session()->get('setup.connection_mode', 'local');
        $connectionName = config('database.default');

        if ($mode === 'remote' && is_array($remote)) {
            $connectionConfig = config("database.connections.{$connectionName}", []);

            $connectionConfig = array_merge($connectionConfig, [
                'driver' => 'mysql',
                'host' => $remote['host'],
                'port' => (string) $remote['port'],
                'database' => $remote['database'],
                'username' => $remote['username'],
                'password' => $remote['password'] ?? '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => $connectionConfig['prefix'] ?? '',
                'prefix_indexes' => $connectionConfig['prefix_indexes'] ?? true,
                'strict' => $connectionConfig['strict'] ?? true,
                'engine' => $connectionConfig['engine'] ?? null,
            ]);

            config(["database.connections.{$connectionName}" => $connectionConfig]);

            // Important: discard any PDO connection created before this request's settings were applied.
            DB::purge($connectionName);
        }

        return $next($request);
    }
}
