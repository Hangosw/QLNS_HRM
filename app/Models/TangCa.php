<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TangCa extends Model
{
    protected $table = 'tang_cas';

    protected $fillable = [
        'NhanVienId',
        'NguoiDuyetId',
        'Ngay',
        'BatDau',
        'KetThuc',
        'Tong',
        'TrangThai', // dang_cho, da_duyet, tu_choi
        'Dem', // cái này đếm số lần submit, trường hợp người dùng gửi đơn bị từ chối nhiều lần
        'LyDo',
    ];

    protected $casts = [
        'NhanVienId' => 'integer',
        'NguoiDuyetId' => 'integer',
        'Ngay' => 'date',
        'Tong' => 'float',
        'Dem' => 'integer',
    ];

    /**
     * Relationship: Tăng ca của nhân viên
     */
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'NhanVienId');
    }

    /**
     * Relationship: Người duyệt tăng ca
     */
    public function nguoiDuyet()
    {
        return $this->belongsTo(NhanVien::class, 'NguoiDuyetId');
    }

    /**
     * Check if overtime is rejected
     */
    public function isRejected()
    {
        return $this->TrangThai === 'tu_choi';
    }

    /**
     * Check if overtime is approved
     */
    public function isApproved()
    {
        return $this->TrangThai === 'da_duyet';
    }

    /**
     * Check if overtime is pending
     */
    public function isPending()
    {
        return $this->TrangThai === 'dang_cho';
    }

    /**
     * Calculate overtime hours
     */
    public function getOvertimeHours()
    {
        if (!$this->BatDau || !$this->KetThuc) {
            return 0;
        }

        $date = Carbon::parse($this->Ngay)->format('Y-m-d');
        $start = Carbon::parse($date . ' ' . $this->BatDau);
        $end = Carbon::parse($date . ' ' . $this->KetThuc);

        return round($start->diffInMinutes($end) / 60, 2);
    }

    /**
     * Scope: Approved overtime
     */
    public function scopeDaDuyet($query)
    {
        return $query->where('TrangThai', 'da_duyet');
    }

    /**
     * Scope: Pending overtime
     */
    public function scopeDangCho($query)
    {
        return $query->where('TrangThai', 'dang_cho');
    }

    /**
     * Scope: Rejected overtime
     */
    public function scopeTuChoi($query)
    {
        return $query->where('TrangThai', 'tu_choi');
    }
}