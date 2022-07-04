<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrettyGameAccount extends Model
{
    use HasFactory;

    public $table = 'pretty_game_accounts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $connection = 'db-main';

    protected $fillable = [
        'uuid',
        'username',
        'password',
        'desktop_uri',
        'mobile_uri',
        'raw_data',
        'game_account_pretty',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
