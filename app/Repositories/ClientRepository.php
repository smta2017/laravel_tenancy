<?php

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\BaseRepository;

class ClientRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Client::class;
    }
}
