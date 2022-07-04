<?php

namespace App\Models\DBMain;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Auditable;
    use HasFactory;

    protected $connection = 'db-main';

    public const STATUS_SELECT = [
        'active'   => 'Active',
        'inactive' => 'Inactive',
    ];

    public const BONUS_SELECT = [
        'accepted' => 'Accepted',
        'rejected' => 'Rejected',
    ];

    public $table = 'users';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'tel',
        'picture',
        'username',
        'password',
        'status',
        'bonus',
        'channel_user',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
