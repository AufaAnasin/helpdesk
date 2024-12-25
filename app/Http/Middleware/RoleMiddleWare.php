<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class RoleMiddleware
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \Closure  $next
//      * @param  string  $role
//      * @return mixed
//      */
//     public function handle(Request $request, Closure $next, $role)
//     {
//         $user = Auth::user();

//         // Check if the user is authenticated
//         if (!$user) {
//             return redirect('/login'); // Redirect to login if not authenticated
//         }

//         // Check the user's role
//         if ($role === 'admin' && $user->role !== 'Admin') {
//             return redirect('/'); // Redirect to home or another page if not an admin
//         }

//         if ($role === 'client' && $user->role !== 'Client') {
//             return redirect('/'); // Redirect to home or another page if not a client
//         }

//         return $next($request); // Allow the request to proceed
//     }
// }
