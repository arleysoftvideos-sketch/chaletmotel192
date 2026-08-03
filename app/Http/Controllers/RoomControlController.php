<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomControlBooking;

class RoomControlController extends Controller
{
    public function getBookings()
    {
        try {
            $bookings = RoomControlBooking::all()->map(function ($booking) {
                // Formatting dates exactly as expected by the frontend
                $startStr = '';
                if ($booking->fecha_inicio) {
                    $startStr = $booking->fecha_inicio instanceof \Carbon\Carbon 
                        ? $booking->fecha_inicio->format('Y-m-d') 
                        : date('Y-m-d', strtotime($booking->fecha_inicio));
                }
                
                $endStr = '';
                if ($booking->fecha_salida) {
                    $endStr = $booking->fecha_salida instanceof \Carbon\Carbon 
                        ? $booking->fecha_salida->format('Y-m-d') 
                        : date('Y-m-d', strtotime($booking->fecha_salida));
                }

                return [
                    'row' => $booking->id, // Mapped to 'row' for transparent API integration
                    'room' => $booking->room,
                    'cliente' => $booking->cliente,
                    'telefono' => $booking->telefono ?? '',
                    'fecha_inicio' => $startStr,
                    'fecha_salida' => $endStr,
                    'tasa_aseo' => $booking->tasa_aseo,
                    'deposito' => $booking->deposito,
                    'total_pagado' => $booking->total_pagado,
                    'estado' => $booking->estado,
                    'notas' => $booking->notas ?? '',
                    'fecha_registro' => $booking->fecha_registro ?? ($booking->created_at ? $booking->created_at->format('Y-m-d H:i:s') : ''),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $bookings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener reservas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createBooking(Request $request)
    {
        $request->validate([
            'room' => 'required',
            'cliente' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'fecha_inicio' => 'required|date_format:Y-m-d',
            'fecha_salida' => 'required|date_format:Y-m-d',
            'tasa_aseo' => 'nullable|numeric',
            'deposito' => 'nullable|numeric',
            'total_pagado' => 'nullable|numeric',
            'estado' => 'required|string',
            'notas' => 'nullable|string'
        ]);

        try {
            RoomControlBooking::create([
                'room' => $request->input('room'),
                'cliente' => $request->input('cliente'),
                'telefono' => $request->input('telefono'),
                'fecha_inicio' => $request->input('fecha_inicio'),
                'fecha_salida' => $request->input('fecha_salida'),
                'tasa_aseo' => $request->input('tasa_aseo') ?? 0,
                'deposito' => $request->input('deposito') ?? 0,
                'total_pagado' => $request->input('total_pagado') ?? 0,
                'estado' => strtoupper($request->input('estado')),
                'notas' => $request->input('notas') ?? '',
                'fecha_registro' => date('Y-m-d H:i:s')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reserva creada con éxito en la base de datos local.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear reserva: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateBooking(Request $request, $row)
    {
        $request->validate([
            'room' => 'required',
            'cliente' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'fecha_inicio' => 'required|date_format:Y-m-d',
            'fecha_salida' => 'required|date_format:Y-m-d',
            'tasa_aseo' => 'nullable|numeric',
            'deposito' => 'nullable|numeric',
            'total_pagado' => 'nullable|numeric',
            'estado' => 'required|string',
            'notas' => 'nullable|string',
            'fecha_registro' => 'nullable'
        ]);

        try {
            $booking = RoomControlBooking::findOrFail($row);
            
            $booking->update([
                'room' => $request->input('room'),
                'cliente' => $request->input('cliente'),
                'telefono' => $request->input('telefono'),
                'fecha_inicio' => $request->input('fecha_inicio'),
                'fecha_salida' => $request->input('fecha_salida'),
                'tasa_aseo' => $request->input('tasa_aseo') ?? 0,
                'deposito' => $request->input('deposito') ?? 0,
                'total_pagado' => $request->input('total_pagado') ?? 0,
                'estado' => strtoupper($request->input('estado')),
                'notas' => $request->input('notas') ?? '',
                'fecha_registro' => $request->input('fecha_registro') ?? $booking->fecha_registro ?? date('Y-m-d H:i:s')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reserva actualizada con éxito en la base de datos local.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar reserva: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteBooking($row)
    {
        try {
            $booking = RoomControlBooking::findOrFail($row);
            $booking->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reserva eliminada con éxito de la base de datos local.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar reserva: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkoutBooking($row)
    {
        try {
            $booking = RoomControlBooking::findOrFail($row);
            
            $booking->update([
                'estado' => 'CERRADO'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-out registrado con éxito (estado cerrado).'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al realizar check-out: ' . $e->getMessage()
            ], 500);
        }
    }
}
