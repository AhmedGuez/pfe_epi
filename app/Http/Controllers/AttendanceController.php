<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Pointage;
use App\Models\Employees;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $qrData = trim($request->input('employee_id'));
            $employeeId = $this->extractEmployeeId($qrData);

            if (!$employeeId) {
                throw new \Exception('Format de QR Code invalide');
            }

            $employee = Employees::find($employeeId);
            if (!$employee) {
                throw new \Exception('Employé introuvable');
            }

            $currentTime = Carbon::now();
            $today = $currentTime->toDateString();

            $pointage = Pointage::firstOrCreate(
                ['employee_id' => $employeeId, 'date' => $today],
                [
                    'time_in' => null,
                    'time_out' => null,
                    'breaks' => json_encode([]),
                    'total_hours' => 0,
                    'salary' => 0
                ]
            );

            if ($pointage->time_out) {
                throw new \Exception('Départ déjà enregistré à ' . $pointage->time_out);
            }

            $actionResult = $this->handleAttendanceActions($pointage, $currentTime, $employee);
            
            DB::commit();
            return response()->json($actionResult);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Attendance Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'employee_name' => $employee->full_name ?? 'Inconnu'
            ]);
        }
    }

    private function extractEmployeeId(string $qrData): ?int
    {
        // Essayer plusieurs formats de QR code
        if (preg_match('/Employee ID: (\d+)/', $qrData, $matches)) {
            return (int)$matches[1];
        }

        if (ctype_digit($qrData)) {
            return (int)$qrData;
        }

        return null;
    }

    private function handleAttendanceActions(Pointage $pointage, Carbon $currentTime, Employees $employee): array
    {
        $breaks = json_decode($pointage->breaks, true) ?? [];
        $lastBreak = end($breaks);
        $ongoingBreak = $lastBreak && isset($lastBreak['start']) && !isset($lastBreak['end']);

        if (is_null($pointage->time_in)) {
            $pointage->update(['time_in' => $currentTime->toTimeString()]);
            return $this->createResponse('Entrée enregistrée avec succès !', $employee);
        }

        if (!$ongoingBreak && is_null($pointage->time_out)) {
            $breaks[] = ['start' => $currentTime->toTimeString()];
            $pointage->update(['breaks' => json_encode($breaks)]);
            return $this->createResponse('Début de pause enregistré', $employee);
        }

        if ($ongoingBreak) {
            $breaks[array_key_last($breaks)]['end'] = $currentTime->toTimeString();
            $pointage->update(['breaks' => json_encode($breaks)]);
            return $this->createResponse('Fin de pause enregistrée', $employee);
        }

        $pointage->update(['time_out' => $currentTime->toTimeString()]);
        $this->calculateWorkHoursAndSalary($pointage, $employee);

        return $this->createResponse(
            'Départ enregistré avec succès !',
            $employee,
            $pointage->total_hours,
            $pointage->salary
        );
    }

    private function calculateWorkHoursAndSalary(Pointage $pointage, Employees $employee): void
    {
        try {
            $timeIn = Carbon::parse($pointage->time_in);
            $timeOut = Carbon::parse($pointage->time_out);

            $workDuration = $timeOut->diffInMinutes($timeIn);
            $breaks = json_decode($pointage->breaks, true) ?? [];

            foreach ($breaks as $break) {
                if (isset($break['start'], $break['end'])) {
                    $breakStart = Carbon::parse($break['start']);
                    $breakEnd = Carbon::parse($break['end']);
                    $workDuration -= $breakEnd->diffInMinutes($breakStart);
                }
            }

            $workHours = max($workDuration / 60, 0);
            $salary = round($workHours * ($employee->prix_heure ?? 0), 2);

            $pointage->update([
                'total_hours' => $workHours,
                'salary' => $salary
            ]);

        } catch (\Exception $e) {
            Log::error('Calculation Error: ' . $e->getMessage());
            throw new \Exception('Erreur de calcul du temps de travail');
        }
    }

    private function createResponse(string $message, Employees $employee, ?float $hours = null, ?float $salary = null): array
    {
        return [
            'success' => true,
            'message' => $message,
            'employee_name' => $employee->full_name,
            'work_hours' => $hours,
            'salary' => $salary
        ];
    }
}