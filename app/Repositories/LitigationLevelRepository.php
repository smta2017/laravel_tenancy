<?php

namespace App\Repositories;

use App\Models\LitigationLevel;
use App\Repositories\BaseRepository;

class LitigationLevelRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return LitigationLevel::class;
    }
}
