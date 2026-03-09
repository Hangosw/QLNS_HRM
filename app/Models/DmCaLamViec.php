<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DmCaLamViec extends Model
{
    protected $table = 'dm_ca_lam_viecs';

    protected $fillable = [
        'MaCa',
        'TenCa',
        'GioVao',
        'GioRa',
        'BatDauNghi',
        'KetThucNghi',
        'LaCaQuaDem',
        'PhuCapCaDem',
        'GhiChu',
    ];
}
