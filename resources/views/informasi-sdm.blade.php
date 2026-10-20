<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Informasi & Aturan SDM - Fakultas Informatika</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
    </style>
</head>
<body class="flex flex-col md:flex-row bg-[#F8FAFC] min-h-screen text-[#1E293B]">

    @auth
        <x-navbar />
    @else
        <x-navbarguest />
    @endauth

    <main class="flex-1 flex flex-col min-h-screen p-6 md:p-8 overflow-y-auto">
        @auth
            <x-topbar />
        @else
            <!-- Header for Guest -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-[#C41E3A] font-bold text-lg">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Fakultas Informatika</h2>
                        <p class="text-xs text-gray-500">Telkom University</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 bg-white px-3 py-1.5 rounded-lg border border-gray-100 shadow-sm">
                    <i class="fa-regular fa-calendar-days text-[#C41E3A]"></i>
                    <span id="current-date-span"></span>
                </div>
            </div>
        @endauth

        <!-- Banner Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-[#C41E3A] to-[#99152C] rounded-3xl p-6 md:p-8 text-white shadow-lg mb-8">
            <div class="relative z-10 max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold uppercase tracking-wider mb-3">
                    <i class="fa-solid fa-book-open"></i> Portal Informasi & Regulasi SDM
                </div>
                <h1 class="text-2xl md:text-4xl font-extrabold tracking-tight mb-2">Panduan & Aturan Kepegawaian</h1>
                <p class="text-red-100 text-sm md:text-base leading-relaxed">
                    Akses informasi resmi terkait regulasi Studi Lanjut Dosen, Kenaikan Jabatan Akademik (JAD/PAK), Ketentuan Jam Kerja & Lembur Tenaga Kependidikan, serta format permohonan resmi.
                </p>
            </div>
            <div class="absolute -right-8 -bottom-10 opacity-10 text-white text-9xl pointer-events-none">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
        </div>

        <!-- Tab Navigation Buttons -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-6 border-b border-gray-200 scrollbar-none">
            <button onclick="switchTab('studi-lanjut')" id="tab-btn-studi-lanjut" 
                    class="tab-btn flex items-center gap-2.5 px-5 py-3 rounded-xl font-bold text-sm transition-all whitespace-nowrap bg-[#C41E3A] text-white shadow-sm">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Aturan Studi Lanjut</span>
            </button>
            <button onclick="switchTab('jad')" id="tab-btn-jad" 
                    class="tab-btn flex items-center gap-2.5 px-5 py-3 rounded-xl font-bold text-sm transition-all whitespace-nowrap bg-white text-gray-600 hover:text-gray-900 border border-gray-200">
                <i class="fa-solid fa-award"></i>
                <span>Jabatan Akademik Dosen (JAD)</span>
            </button>
            <button onclick="switchTab('lembur')" id="tab-btn-lembur" 
                    class="tab-btn flex items-center gap-2.5 px-5 py-3 rounded-xl font-bold text-sm transition-all whitespace-nowrap bg-white text-gray-600 hover:text-gray-900 border border-gray-200">
                <i class="fa-solid fa-business-time"></i>
                <span>Jam Kerja & Lembur TPA</span>
            </button>
            <button onclick="switchTab('unduhan')" id="tab-btn-unduhan" 
                    class="tab-btn flex items-center gap-2.5 px-5 py-3 rounded-xl font-bold text-sm transition-all whitespace-nowrap bg-white text-gray-600 hover:text-gray-900 border border-gray-200">
                <i class="fa-solid fa-file-arrow-down"></i>
                <span>Format & Unduhan Dokumen</span>
            </button>
        </div>

        <!-- TAB CONTENT 1: ATURAN STUDI LANJUT -->
        <div id="tab-content-studi-lanjut" class="tab-pane space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Card: Kategori Studi Lanjut -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg font-bold">
                            <i class="fa-solid fa-book-bookmark"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Skema Studi Lanjut</h3>
                            <p class="text-xs text-gray-500">Tugas Belajar vs Izin Belajar</p>
                        </div>
                    </div>
                    <div class="space-y-4 text-sm text-gray-600">
                        <div class="p-4 rounded-xl bg-purple-50/50 border border-purple-100">
                            <h4 class="font-bold text-purple-900 mb-1 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                                Tugas Belajar (Tubel)
                            </h4>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                Dosen dibebastugaskan sementara dari kewajiban tridharma reguler untuk fokus menempuh pendidikan formal tingkat magister/doktoral, baik dengan beasiswa penuh maupun mandiri yang disetujui universitas.
                            </p>
                        </div>
                        <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-100">
                            <h4 class="font-bold text-blue-900 mb-1 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                Izin Belajar (Ibel)
                            </h4>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                Dosen menempuh pendidikan lanjut tanpa meninggalkan kewajiban pokok tugas tridharma perguruan tinggi di Fakultas Informatika (jadwal kuliah tidak mengganggu penugasan mengajar & bimbingan).
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card: Batas Masa Studi & Persyaratan -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg font-bold">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Masa Studi & Ketentuan Batas</h3>
                            <p class="text-xs text-gray-500">Durasi maksimal studi formal</p>
                        </div>
                    </div>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-500 mt-1"></i>
                            <div>
                                <strong class="text-gray-800">Program Magister (S2):</strong>
                                <p class="text-xs text-gray-500">Masa studi normal 2 tahun (4 semester), perpanjangan maksimal 1 tahun (2 semester) dengan persetujuan pimpinan fakultas.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-500 mt-1"></i>
                            <div>
                                <strong class="text-gray-800">Program Doktoral (S3):</strong>
                                <p class="text-xs text-gray-500">Masa studi normal 3-4 tahun (6-8 semester), batas akhir studi maksimal 5 tahun (10 semester).</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-1"></i>
                            <div>
                                <strong class="text-gray-800">Kewajiban Laporan Berkala:</strong>
                                <p class="text-xs text-gray-500">Dosen yang sedang studi lanjut wajib menyerahkan Kartu Hasil Studi (KHS) dan Progress Report riset kepada Bagian SDM setiap akhir semester berjalan.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Alur Pengajuan Studi Lanjut -->
            <div class="bg-white rounded-2xl p-6 md:p-8 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-gray-800 text-lg mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-diagram-project text-[#C41E3A]"></i>
                    Alur & Prosedur Pengajuan Studi Lanjut
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="relative p-5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="inline-block w-8 h-8 rounded-lg bg-[#C41E3A] text-white font-black text-center leading-8 mb-3">1</span>
                        <h4 class="font-bold text-gray-800 text-sm mb-1">Persetujuan Prodi & KK</h4>
                        <p class="text-xs text-gray-500">Koordinasi kesesuaian bidang keahlian (roadmap KK) dan perencanaan beban mengajar dengan Kaprodi & Ketua KK.</p>
                    </div>
                    <div class="relative p-5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="inline-block w-8 h-8 rounded-lg bg-[#C41E3A] text-white font-black text-center leading-8 mb-3">2</span>
                        <h4 class="font-bold text-gray-800 text-sm mb-1">Pengajuan ke Dekanat</h4>
                        <p class="text-xs text-gray-500">Mengunggah Letter of Acceptance (LoA), rincian beasiswa, dan formulir permohonan ke Bagian Urusan SDM Fakultas.</p>
                    </div>
                    <div class="relative p-5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="inline-block w-8 h-8 rounded-lg bg-[#C41E3A] text-white font-black text-center leading-8 mb-3">3</span>
                        <h4 class="font-bold text-gray-800 text-sm mb-1">Penerbitan SK Tugas/Izin</h4>
                        <p class="text-xs text-gray-500">Fakultas merekomendasikan ke Direktorat SDM Universitas untuk penerbitan Surat Keputusan (SK) resmi.</p>
                    </div>
                    <div class="relative p-5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="inline-block w-8 h-8 rounded-lg bg-[#C41E3A] text-white font-black text-center leading-8 mb-3">4</span>
                        <h4 class="font-bold text-gray-800 text-sm mb-1">Update Status Sistem</h4>
                        <p class="text-xs text-gray-500">Status dosen diperbarui di database SDM (Tugas Belajar / Izin Belajar) dan pelaporan berkala per semester.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB CONTENT 2: JABATAN AKADEMIK DOSEN (JAD) -->
        <div id="tab-content-jad" class="tab-pane hidden space-y-6">
            <div class="bg-white rounded-2xl p-6 md:p-8 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-[#C41E3A] flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-ranking-star"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Jenjang Jabatan Fungsional Akademik (JFA / JAD)</h3>
                        <p class="text-xs text-gray-500">Angka Kredit Kumulatif (KUM PAK) Berdasarkan Standar Kemendikbudristek & Telkom University</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Asisten Ahli -->
                    <div class="p-5 rounded-2xl border-2 border-blue-200 bg-blue-50/30">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Jenjang Pertama</span>
                        <h4 class="font-extrabold text-xl text-gray-800 mt-3 mb-1">Asisten Ahli</h4>
                        <p class="text-sm font-semibold text-blue-600 mb-3">KUM: 100 / 150</p>
                        <p class="text-xs text-gray-500 leading-relaxed">Syarat minimal berpendidikan Magister (S2), memiliki NIDN, dan telah memenuhi angka kredit tridharma.</p>
                    </div>

                    <!-- Lektor -->
                    <div class="p-5 rounded-2xl border-2 border-emerald-200 bg-emerald-50/30">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Jenjang Muda</span>
                        <h4 class="font-extrabold text-xl text-gray-800 mt-3 mb-1">Lektor</h4>
                        <p class="text-sm font-semibold text-emerald-600 mb-3">KUM: 200 / 300</p>
                        <p class="text-xs text-gray-500 leading-relaxed">Publikasi jurnal nasional terakreditasi SINTA atau prosiding internasional bereputasi.</p>
                    </div>

                    <!-- Lektor Kepala -->
                    <div class="p-5 rounded-2xl border-2 border-amber-200 bg-amber-50/30">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">Jenjang Madya</span>
                        <h4 class="font-extrabold text-xl text-gray-800 mt-3 mb-1">Lektor Kepala</h4>
                        <p class="text-sm font-semibold text-amber-600 mb-3">KUM: 400 / 550 / 700</p>
                        <p class="text-xs text-gray-500 leading-relaxed">Wajib berpendidikan S3 (Doktor) untuk usulan kenaikan pangkat tertinggi atau jurnal internasional terindeks Scopus/WoS.</p>
                    </div>

                    <!-- Guru Besar -->
                    <div class="p-5 rounded-2xl border-2 border-red-200 bg-red-50/30">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">Jenjang Tertinggi</span>
                        <h4 class="font-extrabold text-xl text-gray-800 mt-3 mb-1">Guru Besar</h4>
                        <p class="text-sm font-semibold text-red-600 mb-3">KUM: 850 / 1050</p>
                        <p class="text-xs text-gray-500 leading-relaxed">Kualifikasi Doktor (S3), karya ilmiah artikel jurnal internasional bereputasi tinggi (first/corresponding author).</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-[#C41E3A]"></i>
                        Persyaratan Dokumen Usulan JAD
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-gray-600">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> SK Pengangkatan Pertama / SK JFA Terakhir</div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Bukti Tridharma (Pengajaran, BKD minimal 4 semester)</div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Repositori & Bukti Korespondensi Karya Ilmiah</div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Lembar Penilaian Peer Review 2 Reviewer Sebidang</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB CONTENT 3: JAM KERJA & LEMBUR TPA -->
        <div id="tab-content-lembur" class="tab-pane hidden space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Jam Kerja Standar -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Waktu Kerja Efektif TPA</h3>
                            <p class="text-xs text-gray-500">Tenaga Pendukung Akademik / Kependidikan</p>
                        </div>
                    </div>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between items-center p-3 rounded-xl bg-gray-50">
                            <span class="font-semibold text-gray-700">Senin - Kamis</span>
                            <span class="font-bold text-[#C41E3A]">08.00 - 16.30 WIB (Istirahat 12.00 - 13.00)</span>
                        </div>
                        <div class="flex justify-between items-center p-3 rounded-xl bg-gray-50">
                            <span class="font-semibold text-gray-700">Jumat</span>
                            <span class="font-bold text-[#C41E3A]">08.00 - 17.00 WIB (Istirahat 11.30 - 13.00)</span>
                        </div>
                        <div class="flex justify-between items-center p-3 rounded-xl bg-emerald-50 text-emerald-800">
                            <span class="font-semibold">Total Jam Kerja Normal</span>
                            <span class="font-bold">40 Jam / Minggu</span>
                        </div>
                    </div>
                </div>

                <!-- Aturan Kerja Lembur -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg font-bold">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Ketentuan Kerja Lembur</h3>
                            <p class="text-xs text-gray-500">Berdasarkan Regulasi Universitas</p>
                        </div>
                    </div>
                    <ul class="space-y-3 text-xs text-gray-600">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-dot text-amber-500 mt-1"></i>
                            <span><strong>Kriteria Lembur:</strong> Pekerjaan yang dilakukan di luar jam kerja reguler atas perintah atasan langsung untuk tugas mendesak/event khusus.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-dot text-amber-500 mt-1"></i>
                            <span><strong>Surat Perintah Kerja Lembur (SPKL):</strong> Wajib diterbitkan dan ditandatangani Kepala Bagian / Wakil Dekan sebelum kegiatan lembur dilaksanakan.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-dot text-amber-500 mt-1"></i>
                            <span><strong>Batasan Jam:</strong> Maksimal 4 jam per hari pada hari kerja, atau maksimal 8 jam pada hari libur/akhir pekan.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-dot text-amber-500 mt-1"></i>
                            <span><strong>Presensi Lembur:</strong> Staf wajib melakukan presensi biometrik/aplikasi saat memulai dan mengakhiri waktu lembur.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- TAB CONTENT 4: FORMAT & UNDUHAN DOKUMEN -->
        <div id="tab-content-unduhan" class="tab-pane hidden space-y-6">
            <div class="bg-white rounded-2xl p-6 md:p-8 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-gray-800 text-lg mb-2">Formulir & Panduan Resmi SDM</h3>
                <p class="text-xs text-gray-500 mb-6">Unduh template surat permohonan, panduan JAD, formulir SPKL, dan dokumen administrasi SDM lainnya.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-red-200 hover:bg-red-50/30 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-red-100 text-[#C41E3A] flex items-center justify-center text-lg">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm group-hover:text-[#C41E3A] transition-colors">Panduan Kenaikan JAD Dosen</h4>
                                <p class="text-xs text-gray-400">PDF • Dokumen Pedoman Operasional PAK</p>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="alert('Fitur berkas panduan JAD siap diunduh.')" class="p-2 text-gray-400 hover:text-[#C41E3A]">
                            <i class="fa-solid fa-download"></i>
                        </a>
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-red-200 hover:bg-red-50/30 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-file-word"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm group-hover:text-blue-600 transition-colors">Formulir Rekomendasi Studi Lanjut</h4>
                                <p class="text-xs text-gray-400">DOCX • Surat Permohonan Tugas/Izin Belajar</p>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="alert('Template surat rekomendasi siap diunduh.')" class="p-2 text-gray-400 hover:text-blue-600">
                            <i class="fa-solid fa-download"></i>
                        </a>
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-red-200 hover:bg-red-50/30 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-file-excel"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm group-hover:text-emerald-600 transition-colors">Formulir SPKL Lembur Staf TPA</h4>
                                <p class="text-xs text-gray-400">XLSX • Format Rekap Penugasan & Jam Lembur</p>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="alert('Formulir SPKL siap diunduh.')" class="p-2 text-gray-400 hover:text-emerald-600">
                            <i class="fa-solid fa-download"></i>
                        </a>
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-red-200 hover:bg-red-50/30 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm group-hover:text-purple-600 transition-colors">SOP Izin Cuti Pegawai</h4>
                                <p class="text-xs text-gray-400">PDF • Prosedur Pengajuan Cuti Sakit, Melahirkan & Tahunan</p>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="alert('Dokumen SOP Cuti siap diunduh.')" class="p-2 text-gray-400 hover:text-purple-600">
                            <i class="fa-solid fa-download"></i>
                        </a>
                    </div>
                </div>

                <!-- Kontak Layanan SDM -->
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h4 class="font-bold text-gray-800 text-sm mb-3">Kontak Layanan Urusan SDM FIF</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-gray-400">Lokasi Kerja</p>
                            <p class="font-bold text-gray-700 mt-0.5">Gedung Fakultas Informatika Lt. 1</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-gray-400">Email Resmi</p>
                            <p class="font-bold text-gray-700 mt-0.5">sdm-fif@telkomuniversity.ac.id</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-gray-400">Waktu Pelayanan</p>
                            <p class="font-bold text-gray-700 mt-0.5">Senin - Jumat, 08.00 - 16.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        function switchTab(tabId) {
            // Hide all tab panes
            document.querySelectorAll('.tab-pane').forEach(el => el.classList.add('hidden'));
            
            // Show selected tab pane
            const targetPane = document.getElementById('tab-content-' + tabId);
            if(targetPane) {
                targetPane.classList.remove('hidden');
            }

            // Update buttons styling
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-[#C41E3A]', 'text-white', 'shadow-sm');
                btn.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-200');
            });

            const activeBtn = document.getElementById('tab-btn-' + tabId);
            if(activeBtn) {
                activeBtn.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-200');
                activeBtn.classList.add('bg-[#C41E3A]', 'text-white', 'shadow-sm');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const dateSpan = document.getElementById('current-date-span');
            if (dateSpan) {
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                dateSpan.textContent = new Date().toLocaleDateString('id-ID', options);
            }
        });
    </script>
</body>
</html>
