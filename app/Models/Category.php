<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\ModelTree;
use Spatie\EloquentSortable\Sortable;

class Category extends Model implements Sortable
{
    use ModelTree;

    protected $table = 'category';
    protected $titleColumn = 'title';
    protected $orderColumn = 'order';
    protected $parentColumn = 'parent_id';
}
