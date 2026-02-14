<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DmChucVu extends Model
{
    protected $table = 'dm_chuc_vus';

    protected $fillable = [
        'Ma',
        'Ten',
        'Loai', // 1 là trưởng phòng, 0 là bình thường
        'PhuCapChucVu',
    ];

    protected $casts = [
        'Loai' => 'integer',
        'PhuCapChucVu' => 'decimal:2',
    ];

    /**
     * Relationship: Một chức vụ có nhiều nhân viên
     */
    public function nhanViens()
    {
        return $this->hasManyThrough(
            NhanVien::class,
            TtNhanVienCongViec::class,
            'ChucVuId',
            'id',
            'id',
            'NhanVienId'
        );
    }

    /**
     * Relationship: Một chức vụ có nhiều hợp đồng
     */
    public function hopDongs()
    {
        return $this->hasMany(HopDong::class, 'ChucVuId');
    }

    /**
     * Relationship: Một chức vụ có nhiều quá trình công tác
     */
    public function quaTrinhCongTacs()
    {
        return $this->hasMany(QuaTrinhCongTac::class, 'ChucVuId');
    }

    /**
     * Check if position is manager level
     */
    public function isTruongPhong()
    {
        return $this->Loai === 1;
    }

    /**
     * Scope: Manager positions only
     */
    public function scopeTruongPhong($query)
    {
        return $query->where('Loai', 1);
    }
}
