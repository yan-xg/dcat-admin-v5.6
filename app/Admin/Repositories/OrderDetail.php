<?php

namespace App\Admin\Repositories;

use App\Models\OrderDetail as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class OrderDetail extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
