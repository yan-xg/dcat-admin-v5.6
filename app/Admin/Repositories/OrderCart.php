<?php

namespace App\Admin\Repositories;

use App\Models\OrderCart as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class OrderCart extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
