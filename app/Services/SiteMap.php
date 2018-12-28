<?php
/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2018/12/28
 * Time: 16:20
 */

namespace App\Services;


use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SiteMap
{
    /**
     * Return the content of the Site Map
     */
    public function getSiteMap()
    {
        if (Cache::has('site-map')) {
            return Cache::get('site-map');
        }

        $site_map = $this->buildSiteMap();
        Cache::add('site-map', $site_map, 120);

        return $site_map;
    }

    /**
     * Build the Site Map
     */
    protected function buildSiteMap()
    {
        $articles = Article::where('published_at', '<=', Carbon::now())
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')
            ->take(config('blog.rss_size'))
            ->pluck('updated_at', 'slug')
            ->all();

        $data = array_values($articles);
        sort($data);
        $lastmod = last($data); // 将数组的内部指针设置为其最后一个元素
        $url = trim(url('/'), '/') . '/';

        $xml = [];
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?' . '>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml[] = '  <url>';
        $xml[] = "    <loc>$url</loc>";
        $xml[] = "    <lastmod>$lastmod</lastmod>";
        $xml[] = '    <changefreq>daily</changefreq>';
        $xml[] = '    <priority>0.8</priority>';
        $xml[] = '  </url>';

        foreach ($articles as $slug => $lastmod) {
            $xml[] = '  <url>';
            $xml[] = "    <loc>{$url}index/$slug</loc>";
            $xml[] = "    <lastmod>$lastmod</lastmod>";
            $xml[] = "  </url>";
        }

        $xml[] = '</urlset>';

        return join("\n", $xml);
    }
}