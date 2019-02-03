<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\GoodRepository;

/**
 * Class GoodsController.
 *
 * @package namespace App\Http\Controllers;
 */
class GoodsController extends CommonController
{
    /**
     * @var GoodRepository
     */
    protected $repository;

    /**
     * GoodsController constructor.
     *
     * @param GoodRepository $repository
     */
    public function __construct(GoodRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goods = $this->repository->paginate(config('blog.posts_per_page'));

        return view($this->layout.'.goods.index', compact('goods'));
    }
}
