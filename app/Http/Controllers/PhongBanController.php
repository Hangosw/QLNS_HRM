<?php

namespace App\Http\Controllers;

use App\Models\DmPhongBan;
use App\Models\DonVi;
use Illuminate\Http\Request;

class PhongBanController extends Controller
{
    public function DanhSachView()
    {
        $phongBans = DmPhongBan::with('donVi')->get();
        return view('departments.index', compact('phongBans'));
    }

    public function TaoView()
    {
        $donVis = DonVi::all();
        return view('departments.add', compact('donVis'));
    }

    public function Tao(Request $request)
    {
        $validated = $request->validate([
            'DonViId' => 'required|exists:don_vis,id',
            'Ma' => 'required|string|max:50|unique:dm_phong_bans,Ma',
            'Ten' => 'required|string|max:255',
        ], [
            'DonViId.required' => 'Vui lòng chọn đơn vị.',
            'DonViId.exists' => 'Đơn vị không tồn tại.',
            'Ma.required' => 'Mã phòng ban không được để trống.',
            'Ma.unique' => 'Mã phòng ban đã tồn tại.',
            'Ten.required' => 'Tên phòng ban không được để trống.',
        ]);

        try {
            DmPhongBan::create($validated);
            return redirect()->route('phong-ban.danh-sach')
                ->with('success', 'Thêm phòng ban thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    public function InfoView($id)
    {
        $phongBan = DmPhongBan::with('donVi')->findOrFail($id);
        return view('departments.info', compact('phongBan'));
    }
}
