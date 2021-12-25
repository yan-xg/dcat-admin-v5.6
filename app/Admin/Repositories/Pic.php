<?php

namespace App\Admin\Repositories;

use App\Models\Pic as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Pic extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
