<?php

namespace App\Repositories;

use App\Models\AttributeOpponent;
use App\Repositories\BaseRepository;

class AttributeOpponentRepository extends BaseRepository
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
        return AttributeOpponent::class;
    }
}
