<?php
/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2018/12/28
 * Time: 16:20
 */

namespace App\Services;

use App\Repositories\Contracts\PostRepository;
use App\Repositories\Criteria\LimitCriteria;
use App\Repositories\Criteria\PublishedCriteria;
use Illuminate\Support\Facades\Cache;

class SiteMap
{
    protected $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

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
        $this->repository->pushCriteria(new PublishedCriteria());
        $this->repository->pushCriteria(new LimitCriteria(0, config('blog.rss_size')));
        $posts = $this->repository->orderBy('updated_at', 'desc')->all(['updated_at', 'slug']);

        $lastmod = $posts['data'][0]['updated_at'] ?? '';

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

        foreach ($posts['data'] as $post) {
            $xml[] = '  <url>';
            $xml[] = "    <loc>{$url}posts/{$post['slug']}</loc>";
            $xml[] = "    <lastmod>{$post['updated_at']}</lastmod>";
            $xml[] = "  </url>";
        }

        $xml[] = '</urlset>';

        return join("\n", $xml);
    }
}