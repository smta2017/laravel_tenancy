<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Repositories\BaseRepository;

class UnitRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
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
        return Unit::class;
    }
}
