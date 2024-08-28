<?php

namespace App\Filament\Resources\UserResource\Pages\Auth;

use App\Filament\Resources\UserResource;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\Page;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getRoleFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getRoleFormComponent(): Component
    {
        return Select::make('user_type')
            ->options([
                'patient' => 'Patient',
                'doctor' => 'Doctor',
            ])
            ->default('patient')
            ->required();
    }
}
