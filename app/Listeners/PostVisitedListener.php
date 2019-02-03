<?php

namespace App\Listeners;

use App\Events\PostVisited;
use App\Repositories\Contracts\PostRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostVisitedListener
{
    protected $repository;

    /**
     * Create the event listener.
     *
     * PostVisitedListener constructor.
     * @param PostRepository $repository
     */
    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  PostVisited  $event
     * @return void
     */
    public function handle(PostVisited $event)
    {
        $data = $event->getData();

        if (isset($data['id']) && isset($data['visited'])) {
            $this->repository->update(['visited' => $data['visited'] + 1], $data['id']);
        }
    }
}
