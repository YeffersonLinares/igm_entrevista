<?php

namespace App\Repositories;

use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaRepository extends BaseRepository
{
    protected $modelBase;

    public function __construct(Factura $modelo)
    {
        $this->modelBase = new BaseRepository($modelo);
        parent::__construct($modelo);
    }

    public function list(Request $request)
    {
        return $this->model->with(['items'])->where('estado', 1)
            ->where(function ($query) use ($request) {
                if (!empty($request->id)) $query->where('id', 'like', "%$request->id%");
                if (!empty($request->emisor_nit)) $query->where('emisor_nit', 'like', "%$request->emisor_nit%");
                if (!empty($request->receptor_nit)) $query->where('receptor_nit', 'like', "%$request->receptor_nit%");
                if (!empty($request->fecha_inicio)) $query->where('created_at', '>=', "$request->fecha_inicio");
                if (!empty($request->fecha_fin)) $query->where('created_at', '<=', "$request->fecha_fin");
            })
            ->get();
    }
}
