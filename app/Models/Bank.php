<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use Auditable;
    use HasFactory;

    public const STATUS_SELECT = [
        'on'  => 'On',
        'off' => 'Off',
    ];

    protected $connection = 'db-main';

    public $table = 'banks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'name',
        'short_name',
        'logo',
        'status',
        'bank_id',
        'name_th',
        'short_name_th',
        'bank_account_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
