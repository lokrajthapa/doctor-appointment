<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class PatientDashboardWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [


            Stat::make('Appointment', function () {
                // Assuming you have the user ID
                $userId = auth()->id(); // or any specific user ID

                // Get the patient related to the user
                $patient = User::find($userId)->patient;

                // Count the appointments related to this patient
                $appointmentCount = $patient ? $patient->appointments()->count() : 0;

                return $appointmentCount;
            })
            ->description('Total Appointments for particular patient')
            ->chart([0, 30, 60, 65, 70, 75, 80])
            ->color('success'),

        ];

    }


    public static function canView(): bool
    {
        return auth()->user()->user_type === 'patient';
    }


}
