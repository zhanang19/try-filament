<?php

namespace App\Filament\Imports;

use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->label('Full Name')
                ->exampleHeader(fn (ImportColumn $column) => $column->getLabel())
                ->example('John Doe')
                ->rules(['required']),

            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'email']),

            ImportColumn::make('email_verified_at')
                ->rules(['email', 'datetime']),

            ImportColumn::make('password')
                ->requiredMapping()
                ->rules(['required']),

            ImportColumn::make('gender')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?User
    {
        return new User();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your user import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
