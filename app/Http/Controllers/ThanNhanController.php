<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\ThanNhan;
use Illuminate\Http\Request;

class ThanNhanController extends Controller
{
    /**
     * Store a newly created dependent in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'NhanVienId' => 'required|exists:nhan_viens,id',
            'HoTen' => 'required|string|max:255',
            'NgaySinh' => 'nullable|date',
            'QuanHe' => 'required|in:bo_de,me_de,vo_chong,con_ruot,con_nuoi,khac',
            'CCCD' => 'nullable|string|max:20',
            'SoDienThoai' => 'nullable|string|max:20',
            'MaSoThue' => 'nullable|string|max:20',
            'TepDinhKem' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        $data['LaGiamTruGiaCanh'] = $request->has('LaGiamTruGiaCanh') ? 1 : 0;

        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $filename = 'thannhan_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/than_nhan'), $filename);
            $data['TepDinhKem'] = 'uploads/than_nhan/' . $filename;
        }

        ThanNhan::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm thân nhân thành công!'
        ]);
    }

    /**
     * Remove the specified dependent from storage.
     */
    public function destroy($id)
    {
        $thanNhan = ThanNhan::findOrFail($id);

        // Delete file if exists
        if ($thanNhan->TepDinhKem && file_exists(public_path($thanNhan->TepDinhKem))) {
            unlink(public_path($thanNhan->TepDinhKem));
        }

        $thanNhan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa thân nhân thành công!'
        ]);
    }
}
