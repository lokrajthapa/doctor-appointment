<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Filament\Resources\DoctorResource\RelationManagers;
use App\Models\Doctor;
use App\Models\User;
use Filament\Forms;
use Filament\Infolists\Components\Section;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                ->options(User::where('user_type', 'doctor')->pluck('name', 'id'))->label('User')
                    ->required(),
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required(),
                Forms\Components\Textarea::make('bio')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
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
                Section::make('Doctor Details')
                    ->columns([
                        'sm' => 1,
                        'xl' => 2,
                        '2xl' => 3,
                    ])
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Name')
                            ->icon('heroicon-m-user')
                            ->fontFamily(FontFamily::Mono)
                            ->iconColor('primary'),
                        TextEntry::make('department.name')
                            ->label('Department Name')
                            ->icon('heroicon-m-calendar')
                            ->iconColor('primary'),
                        TextEntry::make('address')
                            ->label('Address')
                            ->icon('heroicon-m-question-mark-circle')
                            ->iconColor('primary'),
                        TextEntry::make('bio')
                            ->label('Bio')
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
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'view' => Pages\ViewDoctor::route('/{record}'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
