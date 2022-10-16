<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacturaStoreRequest;
use App\Repositories\FacturaRepository;
use App\Repositories\ItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // dd('llego');
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
        try {
            DB::beginTransaction();
            if (empty($request->id)) $factura = $this->facturaRepository->new();
            else $factura = $this->facturaRepository->find($request->id);
            foreach ($request->all() as $key => $value) if ($key != 'items') $factura[$key] = $value;
            $factura->valor_total = $request->valor + ($request->valor * ($request->iva / 100));
            $this->facturaRepository->save($factura);
            if (empty($request->id)) :
                foreach ($request->items as $key => $value) :
                    $item = $this->itemRepository->new();
                    $item->descripcion = $value['descripcion'];
                    $item->cantidad = $value['cantidad'];
                    $item->valor_unitario = $value['valor_unitario'];
                    $item->valor_total = $value['valor_total'];
                    $item->factura_id = $factura->id;
                    $this->itemRepository->save($item);
                endforeach;
            endif;
            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'Factura guardada con éxito',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'msg' => 'Error en el servidor',
            ]);
        }
    }
}
