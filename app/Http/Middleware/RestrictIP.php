<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowed_ips = [
            '192.168.110.1',
            '36.73.253.110',
            '192.168.112.0/24',
        ];

        $client_ip = $request->ip();

        foreach ($allowed_ips as $ip) {
            if ($this->ipInRange($client_ip, $ip)) {
                return $next($request);
            }
        }

        abort(403, 'Access denied');
    }

    private function ipInRange($ip, $range)
    {
        if (strpos($range, '/') === false) {
            return $ip === $range;
        }

        list($range, $netmask) = explode('/', $range, 2);
        $netmask = ~((1 << (32 - $netmask)) - 1);

        return (ip2long($ip) & $netmask) === (ip2long($range) & $netmask);
    }
}
