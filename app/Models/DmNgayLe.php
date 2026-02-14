<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DmNgayLe extends Model
{
    protected $table = 'dm_ngay_les';
    
    protected $fillable = [
        'TenNgayLe',
        'Ngay',
        'LoaiLe', // 1 là dương, 0 là âm
        'Nam',
    ];

    protected $casts = [
        'Ngay' => 'date',
        'LoaiLe' => 'integer',
        'Nam' => 'integer',
    ];

    /**
     * Check if holiday is solar calendar
     */
    public function isDuongLich()
    {
        return $this->LoaiLe === 1;
    }

    /**
     * Check if holiday is lunar calendar
     */
    public function isAmLich()
    {
        return $this->LoaiLe === 0;
    }

    /**
     * Scope: Solar calendar holidays
     */
    public function scopeDuongLich($query)
    {
        return $query->where('LoaiLe', 1);
    }

    /**
     * Scope: Lunar calendar holidays
     */
    public function scopeAmLich($query)
    {
        return $query->where('LoaiLe', 0);
    }

    /**
     * Scope: Holidays for specific year
     */
    public function scopeNam($query, $year)
    {
        return $query->where('Nam', $year);
    }

    /**
     * Get holidays for current year
     */
    public static function getCurrentYearHolidays()
    {
        return self::where('Nam', now()->year)->get();
    }

    /**
     * Check if a specific date is a holiday
     */
    public static function isHoliday($date)
    {
        return self::whereDate('Ngay', $date)->exists();
    }
}
