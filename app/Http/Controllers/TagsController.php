<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Repositories\Contracts\TagRepository;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    protected $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $data = $this->repository->setPresenter("Prettus\\Repository\\Presenter\\ModelFractalPresenter")
            ->orderBy('id', 'desc')->paginate(config('blog.posts_per_page'));

        return view('admin.tags.index', $data);
    }

    public function create()
    {
        return view('admin.tags.add');
    }

    public function store(TagCreateRequest $request)
    {
        $this->repository->create($request->fillData());

        return redirect('/admin/tags')->with('success', '标签「' . $request->get('name') . '」创建成功.');
    }

    public function edit($id)
    {
        $data = $this->repository->setPresenter("Prettus\\Repository\\Presenter\\ModelFractalPresenter")->find($id);

        return view('admin.tags.edit', $data);
    }

    public function update(TagUpdateRequest $request, $id)
    {
        $data = $this->repository->update($request->fillData(), $id);

        return redirect('/admin/tags')->with('success', '标签「' . $data->name . '」修改成功.');
    }

    public function destroy($id)
    {
        $this->repository->sync($id, 'posts', []);
        $deleted = $this->repository->delete($id);

        return redirect('admin/tags')->with('success',  $deleted.'标签删除成功.');
    }
}
