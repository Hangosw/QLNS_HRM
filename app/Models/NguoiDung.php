<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class NguoiDung extends Authenticatable
{
    use Notifiable;

    protected $table = 'nguoi_dungs';

    protected $fillable = [
        'TaiKhoan',
        'MatKhau',
        'SoDienThoai',
        'Email',
        'TrangThai', // 0 là không hoạt động, 1 là hoạt động
    ];

    protected $hidden = [
        'MatKhau',
        'remember_token',
    ];

    protected $casts = [
        'TrangThai' => 'integer',
    ];

    // Override password field for authentication
    public function getAuthPassword()
    {
        return $this->MatKhau;
    }

    /**
     * Scope: Active users only
     */
    public function scopeActive($query)
    {
        return $query->where('TrangThai', 1);
    }

    /**
     * Check if user is active
     */
    public function isActive()
    {
        return $this->TrangThai === 1;
    }

    /**
     * Relationship: Mỗi người dùng gắn với một nhân viên
     */
    public function nhanVien()
    {
        return $this->hasOne(NhanVien::class, 'NguoiDungId');
    }
}
