<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferTransaction extends Model
{
    use Auditable;
    use HasFactory;

    public const TXN_TYPE_SELECT = [
        'deposit'  => 'deposit',
        'withdraw' => 'withdraw',
    ];

    public const STATUS_SELECT = [
        'processing'   => 'Processing',
        'successfully' => 'Successfully',
        'rejected'     => 'Rejected',
    ];

    protected $connection = 'db-main';

    public $table = 'transfer_transactions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'amount',
        'status',
        'user_transfers',
        'game_transfers',
        'txn_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function game() {
        return $this->hasOne('App\Models\Game', 'id', 'game_transfers');
    }
}
