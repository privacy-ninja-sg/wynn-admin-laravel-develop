<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use Auditable;
    use HasFactory;

    public const STATUS_SELECT = [
        'approved' => 'Approved',
        'pending'  => 'Pending',
    ];

    protected $connection = 'db-main';

    public $table = 'bank_accounts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'bank_account_id',
        'bank_account_id_last',
        'bank_account_name',
        'status',
        'bank_accounts',
        'user_banks',
        'bank_code',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function bank() {
        return $this->hasOne('App\Models\Bank', 'id', 'bank_accounts');
    }
}
