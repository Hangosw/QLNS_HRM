<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BacLuong extends Model
{
    protected $table = 'bac_luongs';
    
    protected $fillable = [
        'NgachLuongId',
        'Bac',
        'HeSo',
    ];

    protected $casts = [
        'NgachLuongId' => 'integer',
        'Bac' => 'integer',
        'HeSo' => 'decimal:2',
    ];

    /**
     * Relationship: Bậc lương thuộc ngạch lương
     */
    public function ngachLuong()
    {
        return $this->belongsTo(NgachLuong::class, 'NgachLuongId');
    }

    /**
     * Relationship: Một bậc lương có nhiều diễn biến lương
     */
    public function dienBienLuongs()
    {
        return $this->hasMany(DienBienLuong::class, 'BacLuongId');
    }

    /**
     * Calculate actual salary based on base salary
     */
    public function calculateSalary($mucLuongCoSo)
    {
        return $this->HeSo * $mucLuongCoSo;
    }
}
