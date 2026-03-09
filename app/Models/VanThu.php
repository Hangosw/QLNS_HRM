<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VanThu extends Model
{
    // Khai báo tên bảng nếu không theo chuẩn số nhiều của Laravel
    protected $table = 'van_thus';

    protected $fillable = [
        'huong',
        'so_hieu_van_ban',
        'tieu_de',
        'loai_van_ban_id',
        'co_quan_id',
        'ngay',
        'file_path',
        'trang_thai'
    ];

    // Ép kiểu ngày tháng để Laravel tự convert thành Carbon instance
    protected $casts = [
        'ngay' => 'date',
    ];

    /**
     * Liên kết với bảng danh mục loại văn bản
     */
    public function loaiVanBan(): BelongsTo
    {
        return $this->belongsTo(DmVanBan::class, 'loai_van_ban_id');
    }

    /**
     * Liên kết với bảng phòng ban (Cơ quan)
     */
    public function phongBan(): BelongsTo
    {
        return $this->belongsTo(DmPhongBan::class, 'co_quan_id');
    }
}
