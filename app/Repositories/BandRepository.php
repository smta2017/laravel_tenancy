<?php

namespace App\Repositories;

use App\Models\Band;
use App\Repositories\BaseRepository;

class BandRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'subject',
        'created_by',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Band::class;
    }
}
