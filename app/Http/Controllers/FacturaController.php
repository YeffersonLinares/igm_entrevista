<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacturaStoreRequest;
use App\Repositories\FacturaRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FacturaController extends Controller
{

    private $facturaRepository;
    public function __construct(FacturaRepository $facturaRepository)
    {
        $this->facturaRepository = $facturaRepository;
    }

    public function index()
    {
        $facturas = $this->list(new Request());
        return Inertia::render('Factura', [
            'facturas_props' => $facturas
        ]);
    }

    public function list(Request $request)
    {
        return $this->facturaRepository->list($request);
    }

    public function delete(Request $request)
    {
        $this->facturaRepository->changeState($request->id, '0');
        return response()->json([
            'status' => 200,
            'msg' => 'Factura eliminada con éxito'
        ]);
    }

    public function store(FacturaStoreRequest $request)
    {
        if (empty($request->id)) $factura = $this->facturaRepository->new();
        else $factura = $this->facturaRepository->find($request->id);
        // unset($request, $items);
        foreach ($request->all() as $key => $value) {
            if($key != 'items') $factura[$key] = $value;
        }

        $factura->valor_total = $request->valor + ($request->valor * ($request->iva / 100));
        $this->facturaRepository->save($factura);

        return response()->json([
            'status' => 200,
            'msg' => 'Factura guardada con éxito',
        ]);
    }
}
