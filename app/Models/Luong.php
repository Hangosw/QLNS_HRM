<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Luong extends Model
{
    protected $table = 'luongs';
    
    protected $fillable = [
        'NhanVienId',
        'LoaiLuong', // 0 là loại lương văn phòng, 1 là loại công nhân, 2 là loại cộng tác viên
        'Luong',
        'ThoiGian', // chỉ lấy tháng và năm nhận lương (format YYYY-MM-01)
        'TrangThai', // 0 là chưa trả, 1 là đã trả
    ];

    protected $casts = [
        'NhanVienId' => 'integer',
        'LoaiLuong' => 'integer',
        'Luong' => 'decimal:2',
        'ThoiGian' => 'date',
        'TrangThai' => 'integer',
    ];

    /**
     * Relationship: Lương của nhân viên
     */
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'NhanVienId');
    }

    /**
     * Check if salary is paid
     */
    public function isPaid()
    {
        return $this->TrangThai === 1;
    }

    /**
     * Check if salary is unpaid
     */
    public function isUnpaid()
    {
        return $this->TrangThai === 0;
    }

    /**
     * Check if office worker salary
     */
    public function isVanPhong()
    {
        return $this->LoaiLuong === 0;
    }

    /**
     * Check if worker salary
     */
    public function isCongNhan()
    {
        return $this->LoaiLuong === 1;
    }

    /**
     * Check if contractor salary
     */
    public function isCongTacVien()
    {
        return $this->LoaiLuong === 2;
    }

    /**
     * Scope: Unpaid salaries
     */
    public function scopeChuaTra($query)
    {
        return $query->where('TrangThai', 0);
    }

    /**
     * Scope: Paid salaries
     */
    public function scopeDaTra($query)
    {
        return $query->where('TrangThai', 1);
    }

    /**
     * Scope: Salaries for specific month/year
     */
    public function scopeThang($query, $month, $year)
    {
        return $query->whereYear('ThoiGian', $year)
                     ->whereMonth('ThoiGian', $month);
    }
}
