<?php

namespace App\Http\Controllers;

use App\Models\TallaStock;
use App\Models\Zapatilla;
use Illuminate\Http\Request;

class TallaStockController extends Controller
{
    public function store(Request $request, Zapatilla $zapatilla)
    {
        $request->validate([
            'talla' => 'required|numeric',
            'stock' => 'required|integer|min:0',
        ]);

        $tallaStock = TallaStock::updateOrCreate(
            ['zapatilla_id' => $zapatilla->id, 'talla' => $request->talla],
            ['stock' => $request->stock]
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Talla ' . $request->talla . ' guardada con éxito.',
                'talla' => $tallaStock->talla,
                'stock' => $tallaStock->stock,
                'id' => $tallaStock->id,
                'destroy_url' => route('admin.tallas.destroy', $tallaStock)
            ]);
        }

        return redirect()->back()->with('success', 'Stock actualizado con éxito para la talla ' . $request->talla);
    }

    public function destroy(Request $request, TallaStock $tallaStock)
    {
        $id = $tallaStock->id;
        $tallaStock->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Talla eliminada.',
                'id' => $id
            ]);
        }

        return redirect()->back()->with('success', 'Talla eliminada del inventario.');
    }
}
