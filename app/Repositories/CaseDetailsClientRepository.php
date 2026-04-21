<?php

namespace App\Repositories;

use App\Models\CaseDetailsClient;
use App\Repositories\BaseRepository;

class CaseDetailsClientRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'case_details_id',
        'client_id',
        'attribute_opponent_id',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return CaseDetailsClient::class;
    }
}
