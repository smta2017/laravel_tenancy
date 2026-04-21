<?php

namespace App\Repositories;

use App\Models\ContractBand;
use App\Repositories\BaseRepository;

class ContractBandRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'contract_id',
        'band_id',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ContractBand::class;
    }
}
