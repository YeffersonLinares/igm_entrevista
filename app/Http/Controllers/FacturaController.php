<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacturaStoreRequest;
use App\Repositories\FacturaRepository;
use App\Repositories\ItemRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FacturaController extends Controller
{

    private $facturaRepository;
    private $itemRepository;

    public function __construct(FacturaRepository $facturaRepository, ItemRepository $itemRepository)
    {
        $this->facturaRepository = $facturaRepository;
        $this->itemRepository = $itemRepository;
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
        foreach ($request->all() as $key => $value) if ($key != 'items') $factura[$key] = $value;
        foreach ($request->items as $key => $value) :
            $item = $this->itemRepository->new();
            $item->descripcion = $value->descripcion;
            $item->cantidad = $value->cantidad;
            $item->valor_unitario = $value->valor_unitario;
            $item->valor_total = $value->valor_total;
            $item->factura_id = $factura->id;
            $this->itemRepository->save($item);
        endforeach;


        $factura->valor_total = $request->valor + ($request->valor * ($request->iva / 100));
        $this->facturaRepository->save($factura);

        return response()->json([
            'status' => 200,
            'msg' => 'Factura guardada con éxito',
        ]);
    }
}
