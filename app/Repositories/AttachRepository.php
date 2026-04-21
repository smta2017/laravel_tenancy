<?php

namespace App\Repositories;

use App\Models\Attach;
use App\Repositories\BaseRepository;

class AttachRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'type',
        'path',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Attach::class;
    }
}
