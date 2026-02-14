<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuaTrinhCongTac extends Model
{
    protected $table = 'qua_trinh_cong_tacs';
    
    protected $fillable = [
        'NhanVienId',
        'TuNgay',
        'DenNgay', // after TuNgay
        'DonViId',
        'ChucVuId',
    ];

    protected $casts = [
        'TuNgay' => 'date',
        'DenNgay' => 'date',
        'NhanVienId' => 'integer',
        'DonViId' => 'integer',
        'ChucVuId' => 'integer',
    ];

    /**
     * Relationship: Quá trình công tác của nhân viên
     */
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'NhanVienId');
    }

    /**
     * Relationship: Quá trình công tác tại đơn vị
     */
    public function donVi()
    {
        return $this->belongsTo(DonVi::class, 'DonViId');
    }

    /**
     * Relationship: Quá trình công tác với chức vụ
     */
    public function chucVu()
    {
        return $this->belongsTo(DmChucVu::class, 'ChucVuId');
    }

    /**
     * Scope: Current work assignments
     */
    public function scopeHienTai($query)
    {
        return $query->whereNull('DenNgay')
                     ->orWhere('DenNgay', '>=', now());
    }

    /**
     * Check if this is current assignment
     */
    public function isCurrent()
    {
        return is_null($this->DenNgay) || $this->DenNgay >= now();
    }
}
