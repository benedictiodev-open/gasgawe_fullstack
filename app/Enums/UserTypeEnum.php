<?php

namespace App\Enums;

enum UserTypeEnum: string
{
    case APPLICANT = 'applicant';
    case RECRUITER = 'recruiter';
    case ADMIN = 'admin';

    public static function toSelectOptions(): array
    {
        return collect(self::cases())
            ->reject(fn($case) => $case === self::ADMIN)
            ->map(fn($case) => (object)[
                'label' => ucfirst($case->value),
                'value' => ucfirst($case->value),
            ])
            ->values()
            ->toArray();
    }
}
