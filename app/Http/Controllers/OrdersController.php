<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\GoodRepository;
use App\Repositories\Contracts\OrderRepository;

/**
 * Class OrdersController.
 *
 * @package namespace App\Http\Controllers;
 */
class OrdersController extends CommonController
{
    /**
     * @var OrderRepository
     */
    protected $repository;

    /**
     * @var GoodRepository
     */
    protected $good_repository;

    /**
     * OrdersController constructor.
     *
     * @param OrderRepository $repository
     * @param GoodRepository $good_repository
     */
    public function __construct(OrderRepository $repository, GoodRepository $good_repository)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->good_repository  = $good_repository;
    }



}
