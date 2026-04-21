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
            'stock' => 'required|integer|min:0'
        ]);

        TallaStock::updateOrCreate(
            ['zapatilla_id' => $zapatilla->id, 'talla' => $request->talla],
            ['stock' => $request->stock]
        );

        return redirect()->back()->with('success', 'Stock actualizado con éxito para la talla ' . $request->talla);
    }

    public function destroy(TallaStock $tallaStock)
    {
        $tallaStock->delete();
        return redirect()->back()->with('success', 'Talla eliminada del inventario.');
    }
}
