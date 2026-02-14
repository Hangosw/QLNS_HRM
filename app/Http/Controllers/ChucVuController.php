<?php

namespace App\Http\Controllers;

use App\Models\DmChucVu;
use Illuminate\Http\Request;

class ChucVuController extends Controller
{
    public function DanhSachView()
    {
        $chucVus = DmChucVu::withCount('nhanViens')->get();
        return view('positions.index', compact('chucVus'));
    }

    public function TaoView()
    {
        return view('positions.add');
    }

    public function Tao(Request $request)
    {
        $validated = $request->validate([
            'Ma' => 'required|string|max:50|unique:dm_chuc_vus,Ma',
            'Ten' => 'required|string|max:255',
            'Loai' => 'required|in:0,1',
            'PhuCapChucVu' => 'nullable|numeric|min:0',
        ], [
            'Ma.required' => 'Mã chức vụ không được để trống.',
            'Ma.unique' => 'Mã chức vụ đã tồn tại.',
            'Ten.required' => 'Tên chức vụ không được để trống.',
            'Loai.required' => 'Vui lòng chọn loại chức vụ.',
            'PhuCapChucVu.numeric' => 'Phụ cấp phải là số.',
        ]);

        try {
            DmChucVu::create($validated);
            return redirect()->route('chuc-vu.danh-sach')
                ->with('success', 'Thêm chức vụ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    public function InfoView($id)
    {
        $chucVu = DmChucVu::withCount('nhanViens')->findOrFail($id);
        return view('positions.info', compact('chucVu'));
    }

    public function SuaView($id)
    {
        $chucVu = DmChucVu::findOrFail($id);
        return view('positions.edit', compact('chucVu'));
    }

    public function CapNhat(Request $request, $id)
    {
        $chucVu = DmChucVu::findOrFail($id);

        $validated = $request->validate([
            'Ma' => 'required|string|max:50|unique:dm_chuc_vus,Ma,' . $id,
            'Ten' => 'required|string|max:255',
            'Loai' => 'required|in:0,1',
            'PhuCapChucVu' => 'nullable|numeric|min:0',
        ], [
            'Ma.required' => 'Mã chức vụ không được để trống.',
            'Ma.unique' => 'Mã chức vụ đã tồn tại.',
            'Ten.required' => 'Tên chức vụ không được để trống.',
            'Loai.required' => 'Vui lòng chọn loại chức vụ.',
            'PhuCapChucVu.numeric' => 'Phụ cấp phải là số.',
        ]);

        try {
            $chucVu->update($validated);
            return redirect()->route('chuc-vu.info', $id)
                ->with('success', 'Cập nhật chức vụ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    public function Xoa($id)
    {
        try {
            DmChucVu::destroy($id);
            return response()->json(['success' => true, 'message' => 'Xóa chức vụ thành công.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    public function XoaNhieu(Request $request)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Vui lòng chọn chức vụ cần xóa.'], 400);
        }

        try {
            DmChucVu::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Xóa ' . count($ids) . ' chức vụ thành công.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }
}
