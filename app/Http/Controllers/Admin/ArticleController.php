<?php

namespace App\Http\Controllers\Admin;

use App\extensions\Tree;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Models\Admin\Article;
use App\Models\Admin\Category;
use App\Models\Admin\Tag;
use Carbon\Carbon;

class ArticleController extends AdminController
{
    protected $fieldList = [
        'article_title' => '',
        'subtitle' => '',
        'cate_id' => 0,
        'article_keywords' => '',
        'article_description' => '',
        'article_thumb' => '',
        'article_content' => '',
        'article_author' => '',
        'article_frequency' => 0,
        'is_draft' => "0",
        'layout' => 'blog.layouts.article',
        'publish_date' => '',
        'publish_time' => '',
        'tag_ids' => [],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('category')->orderBy('id', 'desc')->paginate(config('blog.posts_per_page'));

        return view('admin.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tree = new Tree();
        $categories = Category::orderBy('cate_order', 'asc')->get();
        $categories = $tree->createTree($categories, 'id', 'cate_pid', 'cate_name');

        $fields = array_except($this->fieldList, ['article_frequency']);

        $when = Carbon::now()->addHour();
        $fields['publish_date'] = $when->format('Y-m-d');
        $fields['publish_time'] = $when->format('g:i A');

        foreach ($fields as $field => $default) {
            $fields[$field] = old($field, $default);
        }

        $data = array_merge(
            $fields,
            ['categories' => $categories],
            ['allTags' => Tag::select('id', 'tag')->get()]
        );

        return view('admin.article.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleCreateRequest $request)
    {
        $article = Article::create($request->postFillData());
        $article->syncTags($request->get('tag_ids', []));

        return redirect()->route('article.index')->with('success', '文章创建成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tree = new Tree();
        $categories = Category::orderBy('cate_order', 'asc')->get();
        $categories = $tree->createTree($categories, 'id', 'cate_pid', 'cate_name');

        $fields = $this->fieldsFromModel($id, $this->fieldList);

        foreach ($fields as $field => $value) {
            $fields[$field] = old($field, $value);
        }

        $data = array_merge(
            $fields,
            ['categories' => $categories],
            ['allTags' => Tag::select('id', 'tag')->get()]
        );

        return view('admin.article.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleUpdateRequest $request, $id)
    {
        $article = Article::findOrFail($id);

        $article->fill($request->postFillData());
        $article->save();
        $article->syncTags($request->get('tag_ids', []));

        if ($request->action === 'continue') {
            return redirect()->back()->with('success', '修改成功');
        }
        return redirect()->route('article.index')->with('success', '修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->tags()->detach();
        $article->delete();

        return redirect()->route('article.index')->with('success', '删除成功');
    }

    /**
     * Return the field values from the model
     *
     * @param integer $id
     * @param array $fields
     * @return array
     */
    public function fieldsFromModel($id, array $fields)
    {
        $article = Article::findOrFail($id);

        $fieldNames = array_keys(array_except($fields, ['tag_ids']));

        $fields = ['id' => $id];
        foreach ($fieldNames as $field) {
            $fields[$field] = $article->{$field};
        }
        $fields['tag_ids'] = $article->tags->pluck('id')->all();

        return $fields;
    }
}
