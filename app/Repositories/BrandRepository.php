<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\BaseRepository;

class BrandRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'img',
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
        return Brand::class;
    }
}
