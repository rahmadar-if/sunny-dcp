# AGENTS.md - SunnyCRM AI Guidelines

## 1. Navigation & Tracing Fast-Track
Setiap kali diminta melakukan perbaikan bug, tracing flow, atau penambahan fitur:
1. **JANGAN melakukan scanning/grep dari nol ke seluruh direktori.**
2. Buka dan baca terlebih dahulu file [docs/ARCHITECTURE_INDEX.md](file:///d:/2.PRESALES/Sunny%20DCP/SunnyCRM/docs/ARCHITECTURE_INDEX.md).
3. Langsung buka file Controller, Blade View, Service, atau Model yang sudah dipetakan di indeks tersebut.
4. Jika ada penambahan route/fitur baru atau perbaikan flow, perbarui entri di `docs/ARCHITECTURE_INDEX.md`.

## 2. Lean Workflow & Manual Verification (Aturan Testing)
1. **DILARANG menjalankan automated testing berat/lama** setiap kali selesai modifikasi kode (menghemat waktu).
2. Langsung berikan **instruksi uji manual singkat** agar user bisa test sendiri di browser/aplikasi:
   - **Halaman/URL**: Halaman target yang diuji.
   - **Aksi**: Tombol/input apa yang harus dicoba.
   - **Ekspektasi**: Respon atau output yang seharusnya muncul.
