<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\AdminController;
use App\Services\TreeService;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Validators\CategoryValidator;

/**
 * Class CategoriesController.
 *
 * @package namespace App\Http\Controllers;
 */
class CategoriesController extends AdminController
{
    /**
     * @var CategoryRepository
     */
    protected $repository;

    /**
     * @var CategoryValidator
     */
    protected $validator;

    /**
     * CategoriesController constructor.
     *
     * @param CategoryRepository $repository
     * @param CategoryValidator $validator
     */
    public function __construct(CategoryRepository $repository, CategoryValidator $validator)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $categories = $this->repository->orderBy('order', 'asc')->all();
        $categories = $this->getTreeData($categories['data']);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = $this->repository->findWhere([['level', '<', 3]], $columns = ['id', 'pid', 'name', 'level']);
        $categories = $this->getTreeData($categories['data']);

        return view('admin.categories.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            // 空值变null报错：Column 'description' cannot be null
            // 可以注释掉中间件\vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull
            $this->repository->create($request->fillData());

            return redirect('/admin/categories')->with('success', '分类「' . $request->get('name') . '」创建成功.');
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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
        $category = $this->repository->find($id);

        $categories = $this->repository->findWhere([['level', '<', $category['data']['level']]], $columns = ['id', 'pid', 'name', 'level']);

        $categories = $this->getTreeData($categories['data']);

        return view('admin.categories.edit', compact('categories'), $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryUpdateRequest $request
     * @param  string            $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $this->repository->update($request->fillData(), $id);

        return redirect('admin/categories')->with('success', '修改成功');

        /*try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $this->repository->update(convertNullValueToEmpty($request->all()), $id);

            return redirect('admin/categories')->with('success', '修改成功');
        } catch (ValidatorException $e) {

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }*/
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
        $cate = $this->repository->with('posts')->find($id);
        if (! empty($cate['data']['posts']))
            return redirect('admin/categories')->withErrors('删除失败：该分类有关联文章，无法删除.');

        $deleted = $this->repository->delete($id);

        return redirect('admin/categories')->with('success',  $deleted.'分类删除成功.');
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
}
