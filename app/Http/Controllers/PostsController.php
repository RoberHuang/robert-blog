<?php

namespace App\Http\Controllers;

use App\Events\PostVisited;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\TagRepository;
use App\Repositories\Criteria\LimitCriteria;
use App\Repositories\Criteria\PublishedCriteria;
use App\Repositories\Criteria\WhereCriteria;
use App\Services\TreeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Repositories\Contracts\PostRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class PostsController.
 *
 * @package namespace App\Http\Controllers;
 */
class PostsController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $repository;

    protected $category_repository;

    protected $tag_repository;

    protected $layout;

    /**
     * PostsController constructor.
     *
     * @param PostRepository $repository
     * @param CategoryRepository $category_repository
     * @param TagRepository $tag_repository
     */
    public function __construct(PostRepository $repository, CategoryRepository $category_repository, TagRepository $tag_repository)
    {
        $this->middleware('auth.admin:admin')->except('index', 'show');

        $this->repository = $repository;
        $this->category_repository = $category_repository;
        $this->tag_repository = $tag_repository;

        $this->layout = config('web.layout', 'basic');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->path() == 'admin/posts') {
            //$this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
            $posts = $this->repository->with('category')->orderBy('id', 'desc')->paginate(config('blog.posts_per_page'));

            return view('admin.posts.index', $posts);
        }

        $tag = $request->get('tag');
        $this->repository->pushCriteria(new PublishedCriteria());
        $data = $this->repository->getLists($tag);
        $news = $this->getNews();
        $hots = $this->getHots();

        return view($this->layout .'.posts.index', $data)->withNews($news['data'])->withHots($hots['data']);
    }

    public function create()
    {
        $categories = $this->category_repository->orderBy('order', 'asc')->all();
        $categories = $this->getTreeData($categories['data']);

        $when = Carbon::now()->addHour();
        $fields['publish_date'] = $when->format('Y-m-d');
        $fields['publish_time'] = $when->format('g:i A');

        $data = array_merge(
            $fields,
            ['categories' => $categories],
            [
                'allTags' => $this->tag_repository
                    ->setPresenter("Prettus\\Repository\\Presenter\\ModelFractalPresenter")->all(['id', 'name'])
            ]
        );

        return view('admin.posts.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request)
    {
        $post = $this->repository->create($request->fillData()); // 应用了Presenter，所以这里是['data' => ['id'=>...]]的数组
        $this->repository->skipPresenter()->syncWithoutDetaching($post['data']['id'], 'tags', $request->get('tags'));

        return redirect('/admin/posts')->with('success', '文章「' . $post['data']['title'] . '」创建成功.');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $slug)
    {
        $this->repository->pushCriteria(new WhereCriteria(['slug' => $slug]));
        $post = $this->repository->with(['user', 'tags', 'category'])->first();
        $this->repository->resetCriteria();

        if ($tag = $request->get('tag')) {
            $this->tag_repository->pushCriteria(new WhereCriteria(['name' => $tag]));
            $tag = $this->tag_repository->setPresenter("Prettus\\Repository\\Presenter\\ModelFractalPresenter")->first();
            $tag = $tag['data'];
        }

        //DB::enableQueryLog();
        $older = $this->repository->olderPost($post['data'], $tag['name']);
        $newer = $this->repository->newerPost($post['data'], $tag['name']);

        $this->repository->pushCriteria(new LimitCriteria(0, 6));
        $relation = $this->repository->orderBy('id', 'desc')
            ->findWhere(['category_id' => $post['data']['category_id'], ['id', '<>', $post['data']['id']]]);
        //dd(DB::getQueryLog());

        event(new PostVisited($post['data']));

        return view($this->layout .'.posts.show', $post, compact('tag'))->withRelation($relation['data'])->withOlder($older['data'])->withNewer($newer['data']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->repository->with('tags')->find($id);

        $post['data']['tags'] = array_map('pluck_id', $post['data']['tags']);

        $categories = $this->category_repository->orderBy('order', 'asc')->all();
        $categories = $this->getTreeData($categories['data']);

        $data = array_merge(
            $post,
            ['categories' => $categories],
            [
                'allTags' => $this->tag_repository
                    ->setPresenter("Prettus\\Repository\\Presenter\\ModelFractalPresenter")->all(['id', 'name'])
            ]
        );

        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PostUpdateRequest $request
     * @param  string            $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $post = $this->repository->update($request->fillData(), $id); // 应用了Presenter，所以这里是['data' => ['id'=>...]]的数组
        $this->repository->skipPresenter()->sync($post['data']['id'], 'tags', $request->get('tags'));  // 使用skipPresenter()返回的才是对象才可以调用sync()

        if ($request->get('action') === 'continue')
            return redirect()->back()->with('success', '文章「' . $post['data']['title'] . '」修改成功.');

        return redirect('/admin/posts')->with('success', '文章「' . $post['data']['title'] . '」修改成功.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->skipPresenter()->sync($id, 'tags', []);
        $this->repository->delete($id);

        return redirect('/admin/posts')->with('success', '删除成功.');
    }

    /**
     * @param array $data
     * @return array
     */
    protected function getTreeData(array $data)
    {
        $tree = new TreeService();

        return $tree->createTree($data, 'id', 'pid', 'name');
    }

    protected function getNews()
    {
        //DB::enableQueryLog();
        //$this->repository->resetCriteria();
        //$this->repository->pushCriteria(new PublishedCriteria());
        $this->repository->pushCriteria(new LimitCriteria(0, 6));
        $news = $this->repository->orderBy('published_at', 'desc')->all();
        //dd(DB::getQueryLog());
        return $news;
    }

    protected function getHots()
    {
        $this->repository->pushCriteria(new LimitCriteria(0, 5));

        return $this->repository->orderBy('visited', 'desc')->all();
    }
}
