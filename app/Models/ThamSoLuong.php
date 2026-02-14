<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThamSoLuong extends Model
{
    protected $table = 'tham_so_luongs';
    
    protected $fillable = [
        'NgayApDung',
        'MucLuongCoSo', // 4.350.000 vnđ
    ];

    protected $casts = [
        'NgayApDung' => 'date',
        'MucLuongCoSo' => 'decimal:2',
    ];

    /**
     * Get current base salary
     */
    public static function getCurrentBaseSalary()
    {
        return self::where('NgayApDung', '<=', now())
                   ->orderBy('NgayApDung', 'desc')
                   ->first();
    }

    /**
     * Get base salary at specific date
     */
    public static function getBaseSalaryAtDate($date)
    {
        return self::where('NgayApDung', '<=', $date)
                   ->orderBy('NgayApDung', 'desc')
                   ->first();
    }
}
