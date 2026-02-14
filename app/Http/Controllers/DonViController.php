<?php

namespace App\Http\Controllers;

use App\Models\DonVi;
use Illuminate\Http\Request;

class DonViController extends Controller
{
    public function DanhSachView()
    {
        $donVis = DonVi::with('phongBans')->get();
        return view('units.index', compact('donVis'));
    }

    public function DataDonVi()
    {
        $donVis = DonVi::select(['id', 'Ma', 'Ten', 'DiaChi'])->get();
        return response()->json(['data' => $donVis]);
    }

    public function TaoView()
    {
        return view('units.add');
    }

    public function Tao(Request $request)
    {
        $validated = $request->validate([
            'Ma' => 'required|string|max:50|unique:don_vis,Ma',
            'Ten' => 'required|string|max:255',
            'DiaChi' => 'nullable|string|max:500',
        ], [
            'Ma.required' => 'Mã đơn vị không được để trống.',
            'Ma.unique' => 'Mã đơn vị đã tồn tại.',
            'Ten.required' => 'Tên đơn vị không được để trống.',
        ]);

        try {
            DonVi::create($validated);
            return redirect()->route('don-vi.danh-sach')
                ->with('success', 'Thêm đơn vị thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    public function SuaView($id)
    {
        $donVi = DonVi::findOrFail($id);
        return view('units.edit', compact('donVi'));
    }

    public function CapNhat(Request $request, $id)
    {
        $donVi = DonVi::findOrFail($id);

        $validated = $request->validate([
            'Ma' => 'required|string|max:50|unique:don_vis,Ma,' . $id,
            'Ten' => 'required|string|max:255',
            'DiaChi' => 'nullable|string|max:500',
        ], [
            'Ma.required' => 'Mã đơn vị không được để trống.',
            'Ma.unique' => 'Mã đơn vị đã tồn tại.',
            'Ten.required' => 'Tên đơn vị không được để trống.',
        ]);

        try {
            $donVi->update($validated);
            return redirect()->route('don-vi.suaView', $id)
                ->with('success', 'Cập nhật đơn vị thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    public function Xoa($id)
    {
        try {
            DonVi::destroy($id);
            return response()->json(['success' => true, 'message' => 'Xóa đơn vị thành công.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    public function XoaNhieu(Request $request)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Vui lòng chọn đơn vị cần xóa.'], 400);
        }

        try {
            DonVi::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Xóa ' . count($ids) . ' đơn vị thành công.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    public function InfoView($id)
    {
        $donVi = DonVi::with('phongBans')->findOrFail($id);
        return view('units.info', compact('donVi'));
    }
}
