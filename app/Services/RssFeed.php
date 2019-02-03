<?php
/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2018/12/28
 * Time: 15:27
 */

namespace App\Services;

use App\Repositories\Contracts\PostRepository;
use App\Repositories\Criteria\LimitCriteria;
use App\Repositories\Criteria\PublishedCriteria;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RssFeed
{
    protected $repository;
    
    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

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

        $this->repository->pushCriteria(new PublishedCriteria());
        $this->repository->pushCriteria(new LimitCriteria(0, config('blog.rss_size')));
        $posts = $this->repository->orderBy('published_at', 'desc')->all();

        foreach ($posts['data'] as $post) {
            $item = new Item();
            $item->title($post['title'])
                ->description($post['description'])
                ->url(url('/posts/' . $post['slug']))
                ->pubDate(strtotime($post['published_at']))
                ->guid(url('/posts/' . $post['slug']), true)
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