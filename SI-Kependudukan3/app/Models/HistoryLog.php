<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryLog extends Model
{
    protected $table = 'history_logs';

    protected $fillable = [
        'action',
        'details',
    ];

    public static function logAction($action, $details)
    {
        self::create([
            'action' => $action,
            'details' => $details,
        ]);
    }
}
