<?php

namespace App\Models\DBMain;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use Auditable;
    use HasFactory;

    protected $connection = 'db-main';

    public const STATUS_SELECT = [
        'on'  => 'On',
        'off' => 'Off',
    ];

    public $table = 'games';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'name',
        'banner',
        'desc',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
