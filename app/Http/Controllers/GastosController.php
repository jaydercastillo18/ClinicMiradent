<?php

namespace App\Http\Controllers;

use App\Http\Requests\GastoRequest;
use App\Models\Doctora;
use App\Models\Gasto;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GastosController extends Controller
{


    /**
     * Generate and download a PDF report of expenses.
     */
    public function descargarPdf(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $categoria = $request->query('categoria');
        $mes = $request->query('mes', Carbon::now()->format('Y-m'));

        $gastos = $this->gastosQuery($search, $categoria, $mes)
            ->orderBy('fecha_gasto', 'desc')
            ->get();
        $totalMes = $gastos->sum('monto');
        $doctora = Doctora::first();

        $pdf = Pdf::loadView('pdf.reporte_gastos', compact('gastos', 'search', 'categoria', 'mes', 'totalMes', 'doctora'))
            ->setPaper('a4', 'portrait');

        $filename = 'reporte-gastos-' . $mes . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Store a new expense.
     */
    public function store(GastoRequest $request)
    {
        $gasto = Gasto::create($request->validated());

        return $this->backSavedResponse(
            $request,
            'Gasto registrado correctamente.',
            ['gasto' => $this->formatearGasto($gasto)],
            201
        );
    }

    /**
     * Update an existing expense.
     */
    public function update(GastoRequest $request, int $id)
    {
        $gasto = Gasto::findOrFail($id);
        $gasto->update($request->validated());

        return $this->backSavedResponse(
            $request,
            'Gasto actualizado correctamente.',
            ['gasto' => $this->formatearGasto($gasto->fresh())]
        );
    }

    /**
     * Soft delete an expense.
     */
    public function destroy(Request $request, int $id)
    {
        Gasto::findOrFail($id)->delete();

        return $this->backDeletedResponse($request, 'Gasto eliminado correctamente.');
    }

    private function gastosQuery(?string $search = '', ?string $categoria = null, ?string $mes = null, ?string $fecha = null)
    {
        return Gasto::query()
            ->select(['id', 'concepto', 'descripcion', 'monto', 'categoria', 'metodo_pago', 'fecha_gasto', 'comprobante', 'created_at'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('concepto', 'like', "%{$search}%")
                        ->orWhere('descripcion', 'like', "%{$search}%")
                        ->orWhere('metodo_pago', 'like', "%{$search}%")
                        ->orWhere('comprobante', 'like', "%{$search}%");
                });
            })
            ->when($categoria, fn ($query) => $query->where('categoria', $categoria))
            ->when($fecha, fn ($query) => $query->whereDate('fecha_gasto', $fecha))
            ->when($mes, function ($query) use ($mes): void {
                $parts = explode('-', $mes);
                if (count($parts) === 2) {
                    $query->whereYear('fecha_gasto', $parts[0])
                        ->whereMonth('fecha_gasto', $parts[1]);
                }
            });
    }

    private function formatearGasto(Gasto $gasto): array
    {
        return [
            'id' => $gasto->id,
            'concepto' => $gasto->concepto,
            'descripcion' => $gasto->descripcion,
            'categoria' => $gasto->categoria,
            'monto' => $gasto->monto,
            'monto_display' => 'S/. ' . number_format((float) $gasto->monto, 2),
            'metodo_pago' => $gasto->metodo_pago,
            'fecha_gasto' => $gasto->fecha_gasto?->format('Y-m-d'),
            'fecha_gasto_display' => $gasto->fecha_gasto?->format('d/m/Y') ?? 'Sin fecha',
            'comprobante' => $gasto->comprobante,
            'creado' => $gasto->created_at?->format('d/m/Y H:i'),
        ];
    }
}
