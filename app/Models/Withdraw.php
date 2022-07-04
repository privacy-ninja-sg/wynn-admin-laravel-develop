<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use Auditable;
    use HasFactory;

    public const STATUS_SELECT = [
        'waiting'      => 'Waiting',
        'pending'      => 'Pending',
        'successfully' => 'Successfully',
        'rejected'     => 'Rejected',
    ];

    protected $connection = 'db-main';

    public $table = 'master_wallet_transactions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'debit',
        'credit',
        'balance',
        'remark',
        'txn_type',
        'status',
        'user_wallet',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user() {
        return $this->hasOne('App\Models\Customer', 'id', 'user_wallet');
    }
}
