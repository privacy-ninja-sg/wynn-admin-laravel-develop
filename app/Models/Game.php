<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use Auditable;
    use HasFactory;

    public const STATUS_SELECT = [
        'on'  => 'On',
        'off' => 'Off',
    ];

    protected $connection = 'db-main';

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

    public static function getGameName()
    {
        return self::pluck('name','id');
    }

    public static function getGameNameById($id)
    {
        return self::where('id',$id)->value('name');
    }
}
