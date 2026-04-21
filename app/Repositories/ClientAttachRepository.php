<?php

namespace App\Repositories;

use App\Models\ClientAttach;
use App\Repositories\BaseRepository;

class ClientAttachRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'client_id',
        'attach_id',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ClientAttach::class;
    }
}
