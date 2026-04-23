<?php

namespace App\Repositories;

use App\Models\EventType;
use App\Repositories\BaseRepository;

class EventTypeRepository extends BaseRepository
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
        return EventType::class;
    }
}
