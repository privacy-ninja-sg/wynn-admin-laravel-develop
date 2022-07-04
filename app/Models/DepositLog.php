<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositLog extends Model
{
    use Auditable;
    use HasFactory;

    public const STATUS_SELECT = [
        'waiting'      => 'Waiting',
        'pending'      => 'Pending',
        'successfully' => 'Successfully',
        'rejected'     => 'Rejected',
    ];

    protected $connection = 'db-bank';

    public $table = 'deposit_log';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'receive_bank',
        'bank_number',
        'amount',
        'datetime',
        'user_id',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
