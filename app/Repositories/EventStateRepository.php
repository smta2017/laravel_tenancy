<?php

namespace App\Repositories;

use App\Models\EventState;
use App\Repositories\BaseRepository;

class EventStateRepository extends BaseRepository
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
        return EventState::class;
    }
}
