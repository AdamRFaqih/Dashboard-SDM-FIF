<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Laporan TPA & Akreditasi - Dashboard SDM FIF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Nunito', sans-serif; }
    </style>
</head>
<body class="flex flex-col md:flex-row bg-[#F8FAFC] min-h-screen text-[#1E293B]">
    {{-- Sidebar Navigation --}}
    <x-navbar />
    
    {{-- Main Content --}}
    <main class="flex-1 p-6 md:p-8 overflow-y-auto">
        {{-- Top Search Bar --}}
        <x-topbar />

        {{-- Page Title & Actions --}}
        <div class="mb-8 mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-[#C41E3A] tracking-tight">Laporan TPA & Akreditasi</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Rekapitulasi data kepegawaian TPA, status pegawai, serta laporan pelatihan dan sertifikasi kompetensi untuk keperluan akreditasi.</p>
            </div>
            <div class="flex items-center gap-3">
                @can('kelola-data-tpa.create')
                <button onclick="openModalUpdateAkreditasi()" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#FBB03B] hover:bg-[#E09A2A] text-black font-bold rounded-xl transition-all duration-200 text-sm shadow-sm">
                    <i class="fas fa-edit"></i>
                    <span>Update Data Akreditasi</span>
                </button>
                @endcan
                <a href="{{ route('manajemen-tpa.kelola-data') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-600 hover:text-black font-semibold rounded-xl transition-all duration-200 text-sm shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- BAGIAN 1: LAPORAN JUMLAH TPA PEGAWAI TETAP & PROFESIONAL --}}
        {{-- ======================================================== --}}
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-id-card-clip"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Laporan Status Kepegawaian TPA</h2>
                    <p class="text-xs text-gray-500">Perbandingan jumlah Tenaga Pendukung Akademik berstatus Pegawai Tetap dan Profesional / Kontrak</p>
                </div>
            </div>

            <!-- KPI Cards Status Pegawai -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total TPA -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Tenaga Kependidikan</p>
                    <p class="text-3xl font-black text-gray-800 mt-2">{{ $statistik['totalTPA'] ?? 0 }}</p>
                    <div class="mt-3 flex items-center text-xs text-gray-500 gap-1 font-semibold">
                        <span class="px-2 py-0.5 bg-gray-100 rounded-md">Fakultas Informatika</span>
                    </div>
                </div>

                <!-- Pegawai Tetap -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-2 h-full bg-blue-600"></div>
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Pegawai Tetap</p>
                    <p class="text-3xl font-black text-blue-700 mt-2">{{ $statistik['totalTetap'] ?? 0 }}</p>
                    <div class="mt-3 flex items-center text-xs text-blue-600 gap-1 font-semibold">
                        <span class="px-2 py-0.5 bg-blue-50 rounded-md">{{ $statistik['persenTetap'] ?? 0 }}% dari total staf</span>
                    </div>
                </div>

                <!-- Pegawai Profesional / Kontrak -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-2 h-full bg-amber-500"></div>
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Pegawai Profesional / Kontrak</p>
                    <p class="text-3xl font-black text-amber-600 mt-2">{{ $statistik['totalProfesional'] ?? 0 }}</p>
                    <div class="mt-3 flex items-center text-xs text-amber-600 gap-1 font-semibold">
                        <span class="px-2 py-0.5 bg-amber-50 rounded-md">{{ $statistik['persenProfesional'] ?? 0 }}% dari total staf</span>
                    </div>
                </div>

                <!-- Kualifikasi Tinggi -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-2 h-full bg-purple-600"></div>
                    <p class="text-xs font-bold text-purple-600 uppercase tracking-wider">Kualifikasi ≥ D4/S1</p>
                    <p class="text-3xl font-black text-purple-700 mt-2">{{ $statistik['pendidikanTinggiCount'] ?? 0 }}</p>
                    <div class="mt-3 flex items-center text-xs text-purple-600 gap-1 font-semibold">
                        <span class="px-2 py-0.5 bg-purple-50 rounded-md">{{ $statistik['persenPendidikanTinggi'] ?? 0 }}% berkualifikasi tinggi</span>
                    </div>
                </div>
            </div>

            <!-- Tabel Sebaran Status Pegawai per Unit Penempatan -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="font-bold text-gray-800 text-base mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-building-user text-[#C41E3A]"></i>
                    Sebaran Pegawai Tetap & Profesional Berdasarkan Unit Penempatan
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 border-b border-gray-100 uppercase tracking-wider">
                                <th class="text-left py-3 px-4 font-bold rounded-l-lg">Unit Penempatan / Lokasi Kerja</th>
                                <th class="text-center py-3 px-4 font-bold">Pegawai Tetap</th>
                                <th class="text-center py-3 px-4 font-bold">Pegawai Profesional / Kontrak</th>
                                <th class="text-center py-3 px-4 font-bold">Total Staf</th>
                                <th class="text-right py-3 px-4 font-bold rounded-r-lg">Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($rincianStatusUnit as $row)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3 px-4 font-bold text-gray-800">{{ $row->lokasi_kerja }}</td>
                                <td class="py-3 px-4 text-center font-semibold text-blue-700">
                                    <span class="px-2.5 py-1 bg-blue-50 rounded-md">{{ $row->total_tetap }}</span>
                                </td>
                                <td class="py-3 px-4 text-center font-semibold text-amber-700">
                                    <span class="px-2.5 py-1 bg-amber-50 rounded-md">{{ $row->total_profesional }}</span>
                                </td>
                                <td class="py-3 px-4 text-center font-black text-gray-800">{{ $row->total_unit }}</td>
                                <td class="py-3 px-4 text-right font-medium text-gray-500">
                                    {{ $statistik['totalTPA'] > 0 ? round(($row->total_unit / $statistik['totalTPA']) * 100, 1) : 0 }}%
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-400">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50/80 font-bold border-t border-gray-200">
                            <tr>
                                <td class="py-3 px-4 text-gray-800">Total Keseluruhan</td>
                                <td class="py-3 px-4 text-center text-blue-700">{{ $statistik['totalTetap'] ?? 0 }}</td>
                                <td class="py-3 px-4 text-center text-amber-700">{{ $statistik['totalProfesional'] ?? 0 }}</td>
                                <td class="py-3 px-4 text-center text-gray-800">{{ $statistik['totalTPA'] ?? 0 }}</td>
                                <td class="py-3 px-4 text-right text-gray-800">100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- BAGIAN 2: LAPORAN PELATIHAN & SERTIFIKASI TPA AKREDITASI --}}
        {{-- ======================================================== --}}
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-certificate"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Laporan Pelatihan & Sertifikasi Kompetensi (Standar Akreditasi)</h2>
                    <p class="text-xs text-gray-500">Format resmi data akreditasi kualifikasi dan pengembangan kompetensi tenaga kependidikan</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Tabel 1: Persentase TPA Bersertifikat Kompetensi / Profesi -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100">
                            <h3 class="font-bold text-gray-800 text-sm">Persentase Sertifikasi Kompetensi/Profesi</h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700">Akreditasi</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-6 leading-relaxed">
                            Rasio tenaga kependidikan yang memiliki sertifikat kompetensi atau profesi yang relevan dengan tugas pokok dan fungsinya.
                        </p>
                        
                        <div class="space-y-4">
                            <div class="p-3.5 bg-gray-50 rounded-xl flex items-center justify-between">
                                <span class="text-xs font-semibold text-gray-600">Staf Bersertifikat</span>
                                <span class="font-extrabold text-base text-gray-800">{{ $tpaBersertifikat }} Orang</span>
                            </div>
                            <div class="p-3.5 bg-gray-50 rounded-xl flex items-center justify-between">
                                <span class="text-xs font-semibold text-gray-600">Total Tenaga Kependidikan</span>
                                <span class="font-extrabold text-base text-gray-800">{{ $totalTpaAkreditasi }} Orang</span>
                            </div>
                            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center justify-between">
                                <div>
                                    <span class="text-xs font-bold text-emerald-800 block">Persentase Pemenuhan</span>
                                    <span class="text-[10px] text-emerald-600">Target Akreditasi Unggul</span>
                                </div>
                                <span class="text-2xl font-black text-emerald-700">{{ $persenSertifikat }}%</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 text-[11px] text-gray-400 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info text-blue-500"></i>
                        <span>Data dapat diperbarui berkala oleh Super Admin.</span>
                    </div>
                </div>

                <!-- Tabel 2: Rincian Kegiatan Pengembangan Tenaga Kependidikan -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100">
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm">Rincian Jumlah Kegiatan Pengembangan Tenaga Kependidikan</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Kegiatan Pelatihan, Sertifikasi, dan Studi Lanjut per Tahun Anggaran</p>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700">Format Akreditasi</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 uppercase font-bold border-b border-gray-100">
                                    <th class="py-3 px-4 text-center rounded-l-lg w-12">No</th>
                                    <th class="py-3 px-4">Kegiatan</th>
                                    @foreach($tahunList as $th)
                                        <th class="py-3 px-4 text-center">{{ $th }}</th>
                                    @endforeach
                                    <th class="py-3 px-4 text-center rounded-r-lg bg-gray-100/70 font-extrabold text-[#C41E3A]">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 font-medium">
                                @php $rowNumber = 1; @endphp
                                @foreach($matrixKegiatan as $namaKegiatan => $row)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-4 text-center text-gray-400">{{ $rowNumber++ }}</td>
                                    <td class="py-3.5 px-4 font-bold text-gray-800">{{ $namaKegiatan }}</td>
                                    @foreach($tahunList as $th)
                                        <td class="py-3.5 px-4 text-center text-gray-700">
                                            {{ $row['per_tahun'][$th] ?? 0 }}
                                        </td>
                                    @endforeach
                                    <td class="py-3.5 px-4 text-center font-black bg-gray-50/70 text-[#C41E3A]">
                                        {{ $row['total'] }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 font-extrabold border-t border-gray-200">
                                <tr>
                                    <td colspan="2" class="py-3.5 px-4 text-gray-800 uppercase tracking-wider">Total Kegiatan</td>
                                    @foreach($tahunList as $th)
                                        <td class="py-3.5 px-4 text-center text-gray-900">{{ $totalPerTahun[$th] ?? 0 }}</td>
                                    @endforeach
                                    <td class="py-3.5 px-4 text-center text-xl text-[#C41E3A] font-black bg-red-50">
                                        {{ $grandTotalKegiatan }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Tables (Lokasi, Pendidikan, Jabatan) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            {{-- Pendidikan Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-user-graduate text-[#C41E3A]"></i> 
                    Sebaran Tingkat Pendidikan
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600">
                                <th class="text-left py-2.5 px-3 font-semibold rounded-l-lg">Jenjang</th>
                                <th class="text-right py-2.5 px-3 font-semibold">Jumlah</th>
                                <th class="text-right py-2.5 px-3 font-semibold rounded-r-lg">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($statistik['pendidikanCountsMap'] as $pendidikan => $jumlah)
                            <tr class="border-b border-gray-50">
                                <td class="py-2.5 px-3 text-gray-800 font-medium">{{ $pendidikan }}</td>
                                <td class="text-right py-2.5 px-3 font-bold">{{ $jumlah }}</td>
                                <td class="text-right py-2.5 px-3 text-gray-500 font-medium">
                                    {{ $statistik['totalTPA'] > 0 ? round(($jumlah / $statistik['totalTPA']) * 100, 1) : 0 }}%
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-gray-400">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Jabatan Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-briefcase text-[#C41E3A]"></i> 
                    Sebaran Jabatan TPA
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600">
                                <th class="text-left py-2.5 px-3 font-semibold rounded-l-lg">Jabatan</th>
                                <th class="text-right py-2.5 px-3 font-semibold">Jumlah</th>
                                <th class="text-right py-2.5 px-3 font-semibold rounded-r-lg">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($statistik['jabatanCounts'] as $jabatan => $jumlah)
                            <tr class="border-b border-gray-50">
                                <td class="py-2.5 px-3 text-gray-800 font-medium">{{ $jabatan }}</td>
                                <td class="text-right py-2.5 px-3 font-bold">{{ $jumlah }}</td>
                                <td class="text-right py-2.5 px-3 text-gray-500 font-medium">
                                    {{ $statistik['totalTPA'] > 0 ? round(($jumlah / $statistik['totalTPA']) * 100, 1) : 0 }}%
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-gray-400">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- MODAL UPDATE DATA AKREDITASI (Super Admin) --}}
        @can('kelola-data-tpa.create')
        <div id="modalUpdateAkreditasi" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-2xl w-full p-6 md:p-8 shadow-2xl relative">
                <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-100">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Update Data Laporan Akreditasi TPA</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Perbarui angka sertifikasi kompetensi dan kegiatan pengembangan TPA</p>
                    </div>
                    <button type="button" onclick="closeModalUpdateAkreditasi()" class="text-gray-400 hover:text-gray-600 p-2">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('manajemen-tpa.laporan.update-akreditasi') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Section 1: Sertifikasi -->
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 space-y-4">
                        <h4 class="font-bold text-sm text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-certificate text-emerald-600"></i>
                            Tabel 1: Sertifikasi Kompetensi/Profesi
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div>
                                <label class="block font-semibold text-gray-600 mb-1">Jumlah TPA Bersertifikat</label>
                                <input type="number" name="jumlah_tpa_bersertifikat" value="{{ $tpaBersertifikat }}" min="0" required
                                       class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:border-[#C41E3A] focus:outline-none">
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-600 mb-1">Jumlah Total Tenaga Kependidikan</label>
                                <input type="number" name="jumlah_total_tpa" value="{{ $totalTpaAkreditasi }}" min="1" required
                                       class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:border-[#C41E3A] focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Kegiatan Pengembangan per Tahun -->
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 space-y-4">
                        <h4 class="font-bold text-sm text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-chart-line text-[#C41E3A]"></i>
                            Tabel 2: Rincian Kegiatan Pengembangan per Tahun
                        </h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="text-gray-500 font-bold border-b border-gray-200">
                                        <th class="text-left py-2">Kegiatan</th>
                                        @foreach($tahunList as $th)
                                            <th class="text-center py-2 px-2">{{ $th }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach(['Pelatihan', 'Sertifikasi', 'Studi Lanjut'] as $keg)
                                    <tr>
                                        <td class="py-2.5 font-bold text-gray-700">{{ $keg }}</td>
                                        @foreach($tahunList as $th)
                                            <td class="py-2.5 px-1.5 text-center">
                                                <input type="number" 
                                                       name="kegiatan[{{ $keg }}][{{ $th }}]" 
                                                       value="{{ $matrixKegiatan[$keg]['per_tahun'][$th] ?? 0 }}" 
                                                       min="0"
                                                       class="w-16 px-2 py-1 rounded-lg border border-gray-200 text-center text-xs font-semibold focus:border-[#C41E3A] focus:outline-none">
                                            </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" onclick="closeModalUpdateAkreditasi()" 
                                class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold text-sm hover:bg-gray-100">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-6 py-2.5 rounded-xl bg-[#C41E3A] hover:bg-[#A31830] text-white font-bold text-sm transition-all shadow-sm">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endcan

    </main>

    <script>
        function openModalUpdateAkreditasi() {
            const modal = document.getElementById('modalUpdateAkreditasi');
            if (modal) modal.classList.remove('hidden');
        }

        function closeModalUpdateAkreditasi() {
            const modal = document.getElementById('modalUpdateAkreditasi');
            if (modal) modal.classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    showConfirmButton: true,
                    confirmButtonColor: '#C41E3A'
                });
            @endif
        });
    </script>
</body>
</html>