<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $isAdmin = $request->user()
            ->roles()
            ->where('slug', 'admin')
            ->exists();

        if (!$isAdmin) {
            abort(403, 'غير مصرح لك بالدخول إلى لوحة الإدارة.');
        }

        $response = $next($request);

        /*
        |--------------------------------------------------------------------------
        | منع المتصفح من عرض نسخة قديمة من صفحات لوحة الإدارة
        |--------------------------------------------------------------------------
        |
        | هذا يجعل صفحات الأدمن تجلب البيانات الحالية بعد كل إجراء
        | مثل حل البلاغ، استبعاده، إعادة فتحه، التفعيل والتعطيل.
        |
        */
        $response->headers->set(
            'Cache-Control',
            'no-store, no-cache, must-revalidate, max-age=0, private'
        );

        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }
}
