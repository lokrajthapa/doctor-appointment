<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Doctor;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TimePicker;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontFamily;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;


class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('doctor_id')->hidden(fn() => auth()->user()->user_type === 'doctor')
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
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TimePicker::make('start_time')->withoutSeconds()
                    ->required(),
                Forms\Components\TimePicker::make('end_time')->withoutSeconds()
                    ->required(),
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
            if (auth()->user()->user_type === 'doctor') {
                // Patient sees only their own appointments
                $query->whereHas('doctor', function (Builder $query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            }

        })

            ->columns([
                Tables\Columns\TextColumn::make('doctor.user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time'),
                Tables\Columns\TextColumn::make('end_time'),
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
                //
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

    public static function infolist(Infolist $infolist): Infolist
    {
           return $infolist
            ->schema([
                Section::make('Schedules Details')
                    ->columns([
                        'sm' => 1,
                        'xl' => 2,
                        '2xl' => 3,
                    ])
                    ->schema([
                        TextEntry::make('doctor.user.name')
                            ->label('Name')
                            ->icon('heroicon-m-user')
                            ->fontFamily(FontFamily::Mono)
                            ->iconColor('primary'),
                        TextEntry::make('date')
                            ->label('Date')
                            ->icon('heroicon-m-calendar')
                            ->iconColor('primary'),
                        TextEntry::make('start_time')
                            ->label('Start Time')
                            ->icon('heroicon-m-question-mark-circle')
                            ->iconColor('primary'),
                        TextEntry::make('end_time')
                            ->label('End Date')
                            ->icon('heroicon-m-clipboard-document-list')
                            ->iconColor('primary'),
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->icon('heroicon-m-calendar')
                            ->iconColor('primary'),
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->icon('heroicon-m-calendar')
                            ->iconColor('primary'),
                    ])
            ]);
    }






    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'view' => Pages\ViewSchedule::route('/{record}'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
