<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use App\Models\Patient;
use App\Models\User;
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
                Forms\Components\Select::make('patient_id')->hidden(fn() => auth()->user()->user_type === 'patient')
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
                Forms\Components\Select::make('doctor_id')
                ->label('Doctor')
                ->options(function () {
                    return Doctor::with('user')
                        ->whereHas('user', function ($query) {
                            $query->where('user_type', 'doctor');
                        })
                        ->get()
                        ->pluck('user.name', 'id')
                        ->toArray();
                })
                ->required(),
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
}
