<?php

namespace App\Http\Controllers\Admin;

use App\extensions\Tree;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Admin\Category;

class CategoryController extends AdminController
{
    protected $fields = [
        'cate_name' => '',
        'cate_title' => '',
        'cate_keywords' => '',
        'cate_description' => '',
        'cate_order' => 0,
        'cate_pid'=> 0
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::orderBy('cate_order', 'asc')->get();

        $code = new Tree();
        $data = $code->createTree($category, 'id', 'cate_pid', 'cate_name');

        return view('admin.category.index', compact('data', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        $categories = Category::where('cate_pid', 0)->select('id', 'cate_name')->get();

        return view('admin.category.add', compact('categories'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = $request->get($field)??$default;
        }

        $res = Category::create($data);

        return redirect('/admin/cate')->with('success', 'f分类「' . $res->cate_name . '」创建成功.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Category::findOrFail($id);
        $data = ['id' => $id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $tag->$field);
        }

        $categories = Category::where('cate_pid', 0)->select('id', 'cate_name')->get();

        return view('admin.category.edit', compact('categories'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $cate = Category::findOrFail($id);

        foreach ($this->fields as $field => $default) {
            $cate->$field = $request->get($field)??$default;
        }
        $cate->save();

        return redirect('admin/cate')->with('success', '修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = Category::findOrFail($id);

        if ($cate->delete()){
            Category::where('cate_pid', $id)->update(['cate_pid'=>$cate->cate_pid]);

            return redirect('admin/cate')->with('success', '分类「' . $cate->cate_name . '」已经被删除.');
        }

        return redirect('admin/cate')->withErrors(['分类「' . $cate->cate_name . '」删除失败.']);
    }
}
