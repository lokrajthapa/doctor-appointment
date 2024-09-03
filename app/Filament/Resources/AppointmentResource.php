<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Department;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\User;
use Filament\Forms\Components\ViewField;
use Filament\Forms\FormsComponent;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')->hidden(fn () => auth()->user()->user_type === 'patient')
                    ->label('Patient')
                    ->options(function () {
                        return Patient::with('user')
                            ->whereHas('user', function ($query) {
                                $query->where('user_type', 'patient');
                            })
                            ->get()
                            ->pluck('user.name', 'id')
                            ->toArray();
                    })
                    ->required(),
                Forms\Components\Select::make('department_id')
                    ->label('Department')
                    ->options(Department::all()->pluck('name', 'id'))
                    ->reactive() // Make it reactive to trigger changes
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('doctor_id', null); // Reset doctor selection when department changes
                    }),


                Forms\Components\Select::make('doctor_id')
                    ->label('Doctor')
                    ->options(function (callable $get) {
                        $departmentId = $get('department_id');
                       if($departmentId)
                       {
                        return Doctor::with('user')->where('department_id', $departmentId)
                        ->whereHas('user', function ($query) {
                            $query->where('user_type', 'doctor');
                        }) ->get()
                        ->pluck('user.name', 'id')
                        ->toArray();
                       }
                       return [];
                    })->reactive() // Make it reactive to trigger schedule changes
                    ->afterStateUpdated(function ($state, callable $set) {
                        $doctor = Doctor::with('schedules')->find($state);
                        if ($doctor) {
                            $set('schedule', $doctor->schedules);
                        } else {
                            $set('schedule', null);
                        }
                    })
                    ->required(),
                    ViewField::make('schedule')
                    ->label('Schedule')
                    ->view('components.doctor-schedule') // Blade view for rendering the schedule
                    ->columnSpan('full'),




                Forms\Components\DateTimePicker::make('appointment_time')
                    ->required(),
                Forms\Components\Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $userId = Auth::user()->id;
        return $table
            ->modifyQueryUsing(function (Builder $query) use ($userId) {
                if (auth()->user()->user_type === 'admin') {
                    return;
                }
                if (auth()->user()->user_type === 'patient') {
                    // Patient sees only their own appointments
                    $query->whereHas('patient', function (Builder $query) use ($userId) {
                        $query->where('user_id', $userId);
                    });
                }
                if (auth()->user()->user_type === 'doctor') {
                    // Doctor sees only their own appointments
                    $query->whereHas('doctor', function (Builder $query) use ($userId) {
                        $query->where('user_id', $userId);
                    });
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('patient.user.name')->label('Patient')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('doctor.user.name')->label('Doctor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('appointment_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('doctor_id')
                    ->label('Doctor')
                    ->options(function () {
                        return Doctor::query()
                            ->with('user')
                            ->get()
                            ->pluck('user.name', 'id')
                            ->filter(function ($name) {
                                return !is_null($name);
                            })
                            ->toArray();
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'view' => Pages\ViewAppointment::route('/{record}'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
    public static function rules($record = null): array
    {
        return [
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:schedules,id',
        ];
    }
}
