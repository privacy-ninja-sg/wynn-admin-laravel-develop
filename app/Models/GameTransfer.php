<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameTransfer extends Model
{
    use HasFactory;

    public $table = 'game_transfers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $connection = 'db-main';

    protected $fillable = [
        'game',
        'transfer_transaction',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
