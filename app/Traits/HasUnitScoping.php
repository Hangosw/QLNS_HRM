<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasUnitScoping
{
    /**
     * Scope a query to only include records from the user's unit if they are a Unit Admin.
     * Super Admin sees everything.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUnit(Builder $query)
    {
        $user = auth()->user();

        if (!$user) {
            return $query;
        }

        // Super Admin thấy toàn bộ
        if ($user->hasRole('Super Admin')) {
            return $query;
        }

        // Admin Đơn Vị chỉ thấy dữ liệu đơn vị mình
        if ($user->hasRole('Admin Đơn Vị')) {
            $table = $this->getTable();

            // Lấy danh sách ID đơn vị được gán cho người dùng này
            $donViIds = $user->donVis->pluck('id')->toArray();

            // Nếu không có đơn vị nào được gán cụ thể, lấy đơn vị của chính nhân viên đó (fallback)
            if (empty($donViIds)) {
                $nhanVien = $user->nhanVien;
                if ($nhanVien && $nhanVien->ttCongViec) {
                    $donViIds = [$nhanVien->ttCongViec->DonViId];
                }
            }

            if (!empty($donViIds)) {
                // Trường hợp 1: Model là NhanVien
                if ($table === 'nhan_viens') {
                    return $query->whereHas('ttCongViec', function ($q) use ($donViIds) {
                        $q->whereIn('DonViId', $donViIds);
                    });
                }

                // Trường hợp 2: Model có cột DonViId trực tiếp (ví dụ: HopDong)
                if (in_array($table, ['hop_dongs', 'don_vis', 'dm_phong_bans', 'dm_to_dois'])) {
                    return $query->whereIn('DonViId', $donViIds);
                }

                // Trường hợp 3: Model có quan hệ nhanVien
                if (method_exists($this, 'nhanVien')) {
                    return $query->whereHas('nhanVien.ttCongViec', function ($q) use ($donViIds) {
                        $q->whereIn('DonViId', $donViIds);
                    });
                }

                // Fallback: Nếu không khớp trường hợp nào, thử tìm cột DonViId 
                return $query->whereIn('DonViId', $donViIds);
            }
        }

        return $query;
    }
}
