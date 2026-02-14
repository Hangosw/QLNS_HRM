<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CauHinhPhepNam extends Model
{
    protected $table = 'cau_hinh_phep_nams';
    
    protected $fillable = [
        'SoNgayCoBan', // 12 hoặc 14 gì đó
        'NamThamNien', // số năm thâm niên để được cộng phép
        'NgayCongThem', // số phép được cộng khi đủ năm thâm niên
    ];

    protected $casts = [
        'SoNgayCoBan' => 'integer',
        'NamThamNien' => 'integer',
        'NgayCongThem' => 'integer',
    ];

    /**
     * Get current active configuration
     */
    public static function getCurrentConfig()
    {
        return self::latest()->first();
    }

    /**
     * Calculate total annual leave for employee based on years of service
     */
    public function calculateTotalLeave($yearsOfService)
    {
        $totalLeave = $this->SoNgayCoBan;
        
        if ($yearsOfService >= $this->NamThamNien) {
            $bonusYears = floor($yearsOfService / $this->NamThamNien);
            $totalLeave += ($bonusYears * $this->NgayCongThem);
        }
        
        return $totalLeave;
    }
}
