<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HistoryLog extends Model
{
    protected $table = 'history_logs';

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function logAction($action, $details)
    {
        $user = Auth::user();
        
        self::create([
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : 'System',
            'action' => $action,
            'details' => $details,
        ]);
    }
}
