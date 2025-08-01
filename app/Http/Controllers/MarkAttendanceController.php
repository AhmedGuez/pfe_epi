<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pointage;

class MarkAttendanceController extends Controller
{
    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'attendance.*.date' => 'required|date',
            'attendance.*.hours_worked' => 'nullable|numeric|min:0',
            'attendance.*.overtime_hours' => 'nullable|numeric|min:0',
        ]);

        $attendanceData = $request->input('attendance');

        foreach ($attendanceData as $employeeId => $data) {
            // Check if a record already exists for this employee and date
            $existingRecord = Pointage::where('employee_id', $employeeId)
                ->where('date', $data['date'])
                ->first();

            if ($existingRecord) {
                // Update existing record
                $existingRecord->update([
                    'hours_worked' => $data['hours_worked'] ?? $existingRecord->hours_worked,
                    'overtime_hours' => $data['overtime_hours'] ?? $existingRecord->overtime_hours,
                    'is_weekend' => isset($data['is_weekend']) ? true : $existingRecord->is_weekend,
                ]);
            } else {
                // Create a new record
                Pointage::create([
                    'employee_id' => $employeeId,
                    'date' => $data['date'],
                    'hours_worked' => $data['hours_worked'] ?? 0,
                    'overtime_hours' => $data['overtime_hours'] ?? 0,
                    'is_weekend' => isset($data['is_weekend']) ? true : false,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Attendance saved successfully!');
    }
}

