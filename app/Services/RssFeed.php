<?php
/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2018/12/28
 * Time: 15:27
 */

namespace App\Services;


use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RssFeed
{
    /**
     * Return the content of the RSS feed
     */
    public function getRSS()
    {
        if (Cache::has('rss-feed'))
        {
            return Cache::get('rss-feed');
        }

        $rss = $this->buildRssData();
        Cache::add('rss-feed', $rss, 120);

        return $rss;
    }

    /**
     * Return a string with the feed data
     *
     * @return string
     */
    protected function buildRssData()
    {
        $now = Carbon::now();
        $feed = new Feed();
        $channel = new Channel();
        $channel->title(config('blog.title'))
            ->description(config('blog.description'))
            ->url(url('/'))
            ->language(app()->getLocale())
            ->copyright('Copyright © '. config('blog.author') .' 2018')
            ->lastBuildDate($now->timestamp)
            ->appendTo($feed);

        $articles = Article::where('published_at', '<=', $now)
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')
            ->take(config('blog.rss_size'))
            ->get();

        foreach ($articles as $article) {
            $item = new Item();
            $item->title($article->article_title)
                ->description($article->article_description)
                ->url($article->url())
                ->pubDate($article->published_at->timestamp)
                ->guid($article->url(), true)
                ->appendTo($channel);
        }

        $feed = (string) $feed;

        // Replace a couple items to make the feed more compliant
        $feed = str_replace(
            ['<rss version="2.0">', '<channel>',],
            ['<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">', '<channel>' . "\n" . '    <atom:link href="' . url('/rss') .
                '" rel="self" type="application/rss+xml" />',],
            $feed
        );

        return $feed;
    }
}