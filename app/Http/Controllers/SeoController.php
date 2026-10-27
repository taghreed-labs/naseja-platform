<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $urls = collect([
            [
                'loc' => url('/'),
                'lastmod' => null,
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
            [
                'loc' => route('explore'),
                'lastmod' => null,
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
        ]);

        $providers = User::query()
            ->where('status', 'active')
            ->where('approval_status', 'approved')
            ->whereHas('roles', function ($query) {
                $query->where('slug', 'provider');
            })
            ->whereHas('profile', function ($query) {
                $query->whereNotNull('slug')
                    ->where('slug', '!=', '');
            })
            ->with([
                'profile:id,user_id,slug',
            ])
            ->get([
                'id',
                'updated_at',
            ]);

        foreach ($providers as $provider) {
            if (!$provider->profile?->slug) {
                continue;
            }

            $urls->push([
                'loc' => route('users.show', [
                    'slug' => $provider->profile->slug,
                ]),
                'lastmod' => $provider->updated_at?->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ]);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . $this->xmlEscape($url['loc']) . "</loc>\n";

            if (!empty($url['lastmod'])) {
                $xml .= '    <lastmod>' . $this->xmlEscape($url['lastmod']) . "</lastmod>\n";
            }

            $xml .= '    <changefreq>' . $url['changefreq'] . "</changefreq>\n";
            $xml .= '    <priority>' . $url['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin/',
            'Disallow: /dashboard',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /start-register',
            'Disallow: /splash',
            'Disallow: /auth/',
            'Disallow: /favorites',
            'Disallow: /orders',
            'Disallow: /provider/',
            'Disallow: /messages',
            'Disallow: /skills',
            'Disallow: /services',
            'Disallow: /portfolio',
            'Disallow: /settings',
            '',
            'Sitemap: ' . route('seo.sitemap'),
        ];

        return response(implode("\n", $lines) . "\n", 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    private function xmlEscape(string $value): string
    {
        return htmlspecialchars(
            $value,
            ENT_XML1 | ENT_COMPAT,
            'UTF-8'
        );
    }
}
