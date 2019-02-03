<?php

namespace App\Listeners;

use App\Entities\Category;
use App\Repositories\Contracts\CategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RepositoryEntityDeletedListener
{
    protected $repository;

    /**
     * Create the event listener.
     * RepositoryEntityDeletedListener constructor.
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEntityDeleted  $event
     * @return void
     */
    public function handle(RepositoryEntityDeleted $event)
    {
        $model = $event->getModel();

        if ($model instanceof Category) {
            try {
                $this->repository->find($model->id, ['id']);
            } catch (ModelNotFoundException $exception) {
                if ($model->level < 3)
                    $this->updateCate($model->id, $model->pid, $model->level);
            }
        }
    }

    public function updateCate($id, $pid, $level)
    {
        $categories = $this->repository->skipPresenter()->findWhere(['pid' => $id, 'level' => $level + 1], $columns = ['id', 'level']);
        Log::info('修改以下分类的level为: '.$level.', pid为： '. $pid);
        Log::info($categories);
        foreach ($categories as $category)
        {
            if ($level == 1) $this->updateCate($category->id, $category->id, $category->level);

            $this->repository->update(['level' => $level, 'pid' => $pid], $category->id);
        }
    }

    public function failed(RepositoryEntityDeleted $event, $exception)
    {
        Log::info($event->getAction());
    }
}
