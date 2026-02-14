@extends('layouts.app')

@section('title', 'Quản lý chức vụ - Vietnam Rubber Group')

@section('content')
    <div class="page-header">
        <h1>Quản lý chức vụ</h1>
        <p>Danh sách các chức vụ trong công ty</p>
    </div>

    <!-- Actions Bar -->
    <div class="card">
        <div class="action-bar">
            <div class="search-bar">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" class="form-control" placeholder="Tìm kiếm chức vụ..." id="searchInput">
            </div>
            <div class="action-buttons">
                <a href="{{ route('chuc-vu.taoView') }}" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Thêm chức vụ
                </a>
            </div>
        </div>
    </div>

    <!-- Cards Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 24px;">
        @forelse($chucVus ?? [] as $chucVu)
            <a href="{{ route('chuc-vu.info', $chucVu->id) }}" style="text-decoration: none; color: inherit;">
                <div class="card position-card" style="transition: box-shadow 0.2s; cursor: pointer;">
                    <div style="display: flex; align-items: flex-start; gap: 16px;">
                        <div
                            style="width: 48px; height: 48px; background-color: rgba(15, 81, 50, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg fill="none" stroke="#0F5132" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <h3 style="font-size: 18px; font-weight: 600; color: #1f2937; margin: 0;">{{ $chucVu->Ten }}
                                </h3>
                                @if($chucVu->Loai == 1)
                                    <span class="badge"
                                        style="background-color: #fef3c7; color: #92400e; font-size: 11px; padding: 2px 8px;">Trưởng
                                        phòng</span>
                                @endif
                            </div>
                            <p style="font-size: 14px; color: #6b7280; margin-bottom: 16px;">Mã: {{ $chucVu->Ma }}</p>

                            <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px;">
                                <div
                                    style="display: flex; align-items: center; justify-content: space-between; font-size: 14px;">
                                    <span style="color: #6b7280;">Phụ cấp:</span>
                                    <span class="font-medium"
                                        style="color: #1f2937;">{{ number_format($chucVu->PhuCapChucVu ?? 0, 0, ',', '.') }}
                                        VNĐ</span>
                                </div>
                                <div
                                    style="display: flex; align-items: center; justify-content: space-between; font-size: 14px;">
                                    <span style="color: #6b7280;">Số nhân viên:</span>
                                    <span class="font-medium" style="color: #0F5132;">{{ $chucVu->nhan_viens_count ?? 0 }}
                                        người</span>
                                </div>
                            </div>

                            <div style="padding-top: 16px; border-top: 1px solid #f3f4f6;">
                                <span class="badge badge-success">Hoạt động</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 48px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    style="width: 48px; height: 48px; margin: 0 auto 16px; color: #9ca3af;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <p style="color: #6b7280; font-size: 16px;">Chưa có chức vụ nào</p>
                <a href="{{ route('chuc-vu.taoView') }}" class="btn btn-primary" style="margin-top: 16px;">Thêm chức vụ đầu
                    tiên</a>
            </div>
        @endforelse
    </div>
@endsection

@push('styles')
    <style>
        .position-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const searchTerm = this.value.toLowerCase();
            const cards = document.querySelectorAll('.position-card');

            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.parentElement.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
@endpush