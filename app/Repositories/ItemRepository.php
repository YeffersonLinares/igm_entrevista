<?php

namespace App\Repositories;

use App\Models\Factura;
use App\Models\Items;
use Illuminate\Http\Request;

class ItemRepository extends BaseRepository
{
    protected $modelBase;

    public function __construct(Items $modelo)
    {
        $this->modelBase = new BaseRepository($modelo);
        parent::__construct($modelo);
    }
}
