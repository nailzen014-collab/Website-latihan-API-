# Product Requirements Document (PRD)
## Frontend Website Pendaftaran OSIS

### 1. Overview
**Project Name:** Frontend Pendaftaran OSIS  
**Project Type:** Laravel Web Application (Frontend)  
**API Base URL:** http://localhost:8000/api  
**Frontend URL:** http://localhost:8001  
**Framework:** Laravel 13.x with Blade Templates  
**Styling:** Tailwind CSS (via CDN)

---

### 2. Objectives
Membangun aplikasi frontend yang mengkonsumsi API OSIS untuk mengelola data pendaftaran calon pengurus OSIS dengan fitur CRUD (Create, Read, Update, Delete) lengkap.

---

### 3. API Endpoints (Project A - API OSIS)
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/siswa` | Mendapatkan daftar siswa (dengan relasi kelas & jenis kelamin) |
| GET | `/api/kelas` | Mendapatkan daftar kelas |
| GET | `/api/pendaftaran-osis` | Mendapatkan daftar pendaftaran OSIS (dengan relasi siswa) |
| GET | `/api/pendaftaran-osis/{id}` | Mendapatkan detail pendaftaran by ID |
| POST | `/api/pendaftaran-osis` | Menambah pendaftaran baru |
| PUT | `/api/pendaftaran-osis/{id}` | Memperbarui pendaftaran |
| DELETE | `/api/pendaftaran-osis/{id}` | Menghapus pendaftaran |

---

### 4. Features & Requirements

#### 4.1 Halaman Daftar Pendaftaran (Index)
- **URL:** `/pendaftaran`
- **Fitur:**
  - Menampilkan tabel pendaftaran dengan kolom: No, Siswa, NIS, Kelas, Jenis Kelamin, Bidang, Motivasi, Aksi
  - Data diambil dari API `/api/pendaftaran-osis` via Laravel HTTP Client
  - **Search:** Pencarian berdasarkan nama siswa, NIS, atau bidang (client-side filtering)
  - **Filter Bidang:** Dropdown filter berdasarkan pilihan bidang
  - **Pagination:** Client-side pagination (10 items per page) menggunakan Laravel LengthAwarePaginator
  - **Aksi:** Tombol Edit & Hapus per baris
  - **Empty State:** Tampilan informatif ketika belum ada data
  - **Responsive:** Table scroll horizontal di mobile

#### 4.2 Halaman Tambah Pendaftaran (Create)
- **URL:** `/pendaftaran/create`
- **Form Fields:**
  - **Siswa (Dropdown):** Data dari API `/api/siswa`, menampilkan nama, NIS, kelas, jenis kelamin. Value = `siswa_id`
  - **Pilihan Bidang (Dropdown):** Kepemimpinan, Keagamaan, Kesekretariatan, Kebendaharaan, Humas, Kreatif, Olahraga
  - **Motivasi (Textarea):** Required, min 10 karakter
- **Validasi:** Client-side (HTML5) + Server-side via API (422 handling)
- **Error Handling:** Menampilkan error per field dari API, retain input (old())
- **Success:** Redirect ke index dengan flash message success

#### 4.3 Halaman Edit Pendaftaran (Edit)
- **URL:** `/pendaftaran/{id}/edit`
- **Fitur:**
  - Menampilkan info siswa (read-only): Nama, NIS, Kelas, Jenis Kelamin
  - Form edit: Pilihan Bidang & Motivasi (pre-filled dari API detail)
  - Validasi & Error handling sama seperti Create
  - **Success:** Redirect ke index dengan flash message success

#### 4.4 Hapus Pendaftaran (Delete)
- **Method:** DELETE via form dengan `@method('DELETE')`
- **Konfirmasi:** JavaScript confirm dialog sebelum submit
- **API Response:** Handle 204 No Content
- **Success:** Redirect ke index dengan flash message success

---

### 5. Technical Implementation

#### 5.1 Service Layer (ApiService)
```php
app/Services/ApiService.php
```
- Base URL dari env `API_BASE_URL`
- HTTP Client dengan timeout 10s, retry 3x
- Methods: getSiswa(), getKelas(), getPendaftaran(), getPendaftaranById(), createPendaftaran(), updatePendaftaran(), deletePendaftaran()
- Error handling: Throw ValidationException untuk 422, Exception untuk error lain

#### 5.2 Controller (PendaftaranController)
```php
app/Http/Controllers/PendaftaranController.php
```
- Dependency Injection ApiService
- Index: Client-side pagination, search, filter
- Create: Load siswa dari API
- Store/Update: Validasi request, call API, handle errors
- Edit: Load detail + siswa list
- Destroy: Call API delete, handle 204

#### 5.3 Views (Blade Templates)
```
resources/views/
├── layouts/
│   └── app.blade.php          # Layout utama dengan header, footer, mobile menu
└── pendaftaran/
    ├── index.blade.php        # Daftar dengan table, search, filter, pagination
    ├── create.blade.php       # Form tambah
    └── edit.blade.php         # Form edit dengan info siswa read-only
```

#### 5.4 Routing
```php
routes/web.php
Route::resource('pendaftaran', PendaftaranController::class)
    ->parameters(['pendaftaran' => 'id'])
    ->names('pendaftaran');
```

---

### 6. UI/UX Design

#### Color Scheme
- **Primary:** Blue-600 (#0284c7) - untuk aksi utama
- **Success:** Green-500/600 - untuk notifikasi berhasil
- **Error:** Red-500/600 - untuk notifikasi error & hapus
- **Gender Badge:** Blue (Laki-laki), Pink (Perempuan)
- **Bidang Badge:** Primary-100 text-primary-800

#### Components
- **Header:** Sticky, logo + title, navigation links, mobile hamburger menu
- **Table:** Striped rows, hover effect, responsive scroll
- **Forms:** Consistent spacing, focus rings, error states
- **Buttons:** Primary (blue), Secondary (gray), Danger (red)
- **Alerts:** Slide-down animation, auto-hide 5s, dismissible
- **Pagination:** Laravel default pagination links

---

### 7. Error Handling Strategy

| Scenario | Handling |
|----------|----------|
| API Connection Failed | Flash error message, tampilkan empty state |
| Validation Error (422) | Throw ValidationException, display errors per field, retain input |
| 404 Not Found | Redirect ke index dengan error message |
| 500 Server Error | Flash error message, log error |
| Delete 204 No Content | Handle sebagai success |

---

### 8. Data Flow

```
User Request → Controller → ApiService → HTTP Client → API (localhost:8000)
                                                      ↓
Response JSON ← handleResponse() ← HTTP Response ← API
                                                      ↓
Controller → View (Blade) → Rendered HTML → Browser
```

---

### 9. Environment Configuration
```env
# .env
API_BASE_URL=http://localhost:8000/api
APP_URL=http://localhost:8001
```

---

### 10. Testing Checklist

| Test Case | Expected Result |
|-----------|-----------------|
| 1. Buka `/pendaftaran` | Tampil tabel data dari API |
| 2. Search nama siswa | Filter hasil pencarian |
| 3. Filter bidang | Tampil data sesuai bidang |
| 4. Pagination | Navigasi halaman berfungsi |
| 5. Buka `/pendaftaran/create` | Form tampil, dropdown siswa terisi dari API |
| 6. Submit valid | Redirect ke index, flash success, data baru muncul |
| 7. Submit invalid (kosong/duplikat) | Error per field, input retained |
| 8. Buka `/pendaftaran/{id}/edit` | Form terisi data lama, info siswa read-only |
| 9. Update valid | Redirect ke index, flash success, data berubah |
| 10. Update invalid | Error per field, data lama tetap |
| 11. Hapus dengan konfirmasi | Record hilang, siswa tetap ada di API |
| 12. API down | Error message tampil, tidak crash |

---

### 11. Dependencies
- Laravel Framework ^13.17
- PHP ^8.3
- GuzzleHTTP (via Laravel HTTP Client)
- Tailwind CSS (CDN)
- Inter Font (Google Fonts CDN)

---

### 12. Deployment Notes
- Jalankan Project A (API) di port 8000: `php artisan serve --port=8000`
- Jalankan Project B (Frontend) di port 8001: `php artisan serve --port=8001`
- Pastikan `.env` tidak di-commit ke repository
- API_BASE_URL harus mengarah ke Project A
- Database SQLite digunakan untuk session/cache frontend

---

### 13. Future Enhancements
- [ ] Server-side pagination & search di API
- [ ] Export PDF/Excel daftar pendaftaran
- [ ] Authentication & Authorization
- [ ] Dashboard statistik pendaftaran per bidang
- [ ] Real-time notification dengan WebSocket
- [ ] Unit & Feature tests
- [ ] CI/CD pipeline