<?php

namespace App\Repositories;

use App\Models\TheCase;
use App\Repositories\BaseRepository;

class TheCaseRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'code',
        'case_number',
        'type',
        'status',
        'subject',
        'court',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return TheCase::class;
    }

    public function recordFeatureUsage($featureName)
    {
        $user = auth()->user();

        $centralUser = $user->centralUser();

        $tenant = $centralUser->Tenants->first();

        $tenant->planSubscription('main')->recordFeatureUsage($featureName);
    }
}
