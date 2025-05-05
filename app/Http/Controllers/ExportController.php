<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;

class ExportController extends Controller
{
    /**
     * Export reservations to Excel.
     */
    public function exportReservations()
    {
        $this->authorize('exportReservations', Reservation::class);

        $reservations = Reservation::with(['user', 'room'])->get();
        $rooms = Room::all();

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reservaciones');

        // Set headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Cliente');
        $sheet->setCellValue('C1', 'Sala');
        $sheet->setCellValue('D1', 'Fecha');
        $sheet->setCellValue('E1', 'Hora Inicio');
        $sheet->setCellValue('F1', 'Hora Fin');
        $sheet->setCellValue('G1', 'Estado');

        // Fill data
        $row = 2;
        foreach ($reservations as $reservation) {
            $sheet->setCellValue('A' . $row, $reservation->id);
            $sheet->setCellValue('B' . $row, $reservation->user->name);
            $sheet->setCellValue('C' . $row, $reservation->room->name);
            $sheet->setCellValue('D' . $row, $reservation->start_time->format('Y-m-d'));
            $sheet->setCellValue('E' . $row, $reservation->start_time->format('H:i'));
            $sheet->setCellValue('F' . $row, $reservation->end_time->format('H:i'));
            $sheet->setCellValue('G' . $row, ucfirst($reservation->status));
            $row++;
        }

        // Create a new sheet for room statistics
        $statsSheet = $spreadsheet->createSheet();
        $statsSheet->setTitle('Estadísticas por Sala');

        // Set headers for stats
        $statsSheet->setCellValue('A1', 'Sala');
        $statsSheet->setCellValue('B1', 'Total Horas Reservadas');

        // Calculate total hours per room
        $row = 2;
        foreach ($rooms as $room) {
            $totalHours = 0;
            $roomReservations = $room->reservations()->where('status', 'accepted')->get();
            
            foreach ($roomReservations as $reservation) {
                $startTime = Carbon::parse($reservation->start_time);
                $endTime = Carbon::parse($reservation->end_time);
                $hours = $endTime->diffInHours($startTime);
                $totalHours += $hours;
            }
            
            $statsSheet->setCellValue('A' . $row, $room->name);
            $statsSheet->setCellValue('B' . $row, $totalHours);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        foreach (range('A', 'B') as $col) {
            $statsSheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create the Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'reservaciones_' . date('Y-m-d_H-i-s') . '.xlsx';
        $path = storage_path('app/public/' . $filename);
        
        // Save the file
        $writer->save($path);
        
        // Return the file as a download
        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend();
    }
}