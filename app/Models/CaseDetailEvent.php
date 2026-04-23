<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class CaseDetailEvent extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'case_detail_events';

    public $fillable = [
        'id',
        'case_details_id',
        'parent_id',
        'subject',
        'notes',
        'type_id',
        'status_id',
        'created_by',
        'assigned_to',
        'closed_by',
        'is_private',
        'client_access',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'subject' => 'string',
        'notes' => 'string',
        'is_private' => 'boolean',
        'client_access' => 'boolean'
    ];

    public static array $rules = [
        'subject' => 'required'
    ];

    public function caseDetails(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\CaseDetails::class, 'case_details_id', 'id');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\CaseDetailEvent::class, 'parent_id', 'id');
    }

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\EventType::class, 'type_id', 'id');
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\EventState::class, 'status_id', 'id');
    }

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }

    public function assignedTo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to', 'id');
    }

    public function closedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'closed_by', 'id');
    }
}
