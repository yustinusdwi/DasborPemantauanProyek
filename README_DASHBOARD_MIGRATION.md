# Migrasi Logic Dashboard dari Blade Template ke Controller

## Ringkasan Perubahan

Telah dilakukan migrasi semua logic yang ada di `dashboard.blade.php` ke `dashboardController.php` untuk mengikuti prinsip MVC (Model-View-Controller) yang lebih baik. Dashboard telah diperbarui untuk menampilkan data yang lebih relevan sesuai kebutuhan bisnis.

## File yang Diubah

### 1. `app/Http/Controllers/dashboardController.php` (DIPERBARUI)
- **Method `index()`**: Menampilkan halaman dashboard utama dengan data dari controller
- **Method `getDashboardStats()`**: Mengembalikan statistik dashboard (target sales, target pemasaran, persentase proyek, total proyek)
- **Method `getProjectData()`**: Mengembalikan data proyek untuk tabel dengan informasi customer
- **Method `getChartData()`**: Mengembalikan data untuk pie chart customer dan status proyek
- **Method `filterProjects()`**: API endpoint untuk filtering data proyek dengan filter customer
- **Method `getStatusBadge()`**: Static method untuk generate HTML badge status (Berjalan, Selesai, Pending, Ditolak)
- **Method `getProgressBar()`**: Static method untuk generate HTML progress bar dengan warna sesuai status
- **Method `formatCurrency()`**: Static method untuk format currency ke Rupiah
- **Method `getDataTableData()`**: API endpoint untuk DataTables
- **Method `getFilterOptions()`**: API endpoint untuk opsi filter termasuk customer

### 2. `resources/views/dashboard.blade.php` (DIPERBARUI)
- **Menghapus**: Semua logic JavaScript yang kompleks
- **Menambahkan**: Penggunaan data dari controller (`$dashboardStats`, `$projectData`, `$chartData`)
- **Menambahkan**: CSRF token meta tag untuk AJAX requests
- **Menambahkan**: Include file JavaScript terpisah (`dashboard-controller.js`)
- **Menggunakan**: Blade directives untuk menampilkan data dinamis
- **Memperbarui**: Tampilan dashboard dengan 4 card utama (Target Sales, Target Pemasaran, Persentase Proyek, Total Proyek)
- **Memperbarui**: Chart dari area/bar chart menjadi pie chart untuk customer dan status proyek
- **Memperbarui**: Tabel dengan kolom customer dan status yang diperbarui

### 3. `routes/web.php` (DIPERBARUI)
- **Menambahkan**: Route untuk dashboard controller
- **Menambahkan**: API routes untuk filtering dan data retrieval
- **Route baru**:
  - `GET /dashboard` → `dashboardController@index`
  - `GET /dashboard/api/projects` → `dashboardController@getProjectDataApi`
  - `POST /dashboard/filter` → `dashboardController@filterProjects`
  - `GET /dashboard/api/datatable` → `dashboardController@getDataTableData`
  - `GET /dashboard/api/filter-options` → `dashboardController@getFilterOptions`

### 4. `public/js/dashboard-controller.js` (DIPERBARUI)
- **Class `DashboardController`**: Menangani semua logic JavaScript
- **Method `showDashboard()`**: Menampilkan halaman dashboard utama
- **Method `showDataProyekSection()`**: Menampilkan section data proyek
- **Method `showFilterDataSection()`**: Menampilkan section filter data
- **Method `applyFilter()`**: AJAX request untuk filtering dengan filter customer
- **Method `resetFilter()`**: Reset filter form
- **Method `initializeCharts()`**: Inisialisasi pie chart untuk customer dan status proyek
- **Global functions**: Untuk kompatibilitas dengan onclick events

## Keuntungan Migrasi

### 1. **Separation of Concerns**
- Logic bisnis dipindahkan ke controller
- View hanya menangani tampilan
- JavaScript terpisah dalam file dedicated

### 2. **Maintainability**
- Kode lebih mudah di-maintain
- Logic terpusat di satu tempat
- Mudah untuk testing

### 3. **Reusability**
- Method di controller bisa digunakan di tempat lain
- Data bisa diakses via API endpoints
- JavaScript class bisa di-extend

### 4. **Performance**
- Data di-generate di server side
- Mengurangi JavaScript di client side
- AJAX requests untuk data dinamis

### 5. **Business Focus**
- Dashboard menampilkan data yang relevan untuk bisnis
- Target sales dan pemasaran untuk monitoring performa
- Pie chart untuk analisis customer dan status proyek

## Cara Penggunaan

### 1. **Mengakses Dashboard**
```php
// Route
Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
```

### 2. **Menggunakan Data di View**
```php
// Controller
public function index(): View
{
    $dashboardStats = $this->getDashboardStats();
    $projectData = $this->getProjectData();
    $chartData = $this->getChartData();
    
    return view('dashboard', compact('dashboardStats', 'projectData', 'chartData'));
}

// View
<h4>{{ $dashboardStats['target_sales'] }}</h4>
<h4>{{ $dashboardStats['target_pemasaran'] }}</h4>
<h4>{{ $dashboardStats['persentase_proyek'] }}</h4>
<h4>{{ $dashboardStats['total_proyek'] }}</h4>
```

### 3. **AJAX Filtering dengan Customer**
```javascript
// JavaScript
const formData = {
    nama_proyek: document.getElementById('namaProyek').value,
    customer: document.getElementById('customer').value,
    status: document.getElementById('status').value
};

fetch('/dashboard/filter', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify(formData)
})
.then(response => response.json())
.then(data => {
    // Handle response
});
```

### 4. **Static Methods**
```php
// Controller
echo dashboardController::getStatusBadge('Berjalan');
echo dashboardController::formatCurrency(500000000);
echo dashboardController::getProgressBar(75, 'Berjalan');
```

## Struktur Data Baru

### Dashboard Stats
```php
[
    'target_sales' => 'Rp 10.5M',
    'target_pemasaran' => 'Rp 8.2M',
    'persentase_proyek' => '78.5%',
    'total_proyek' => 12
]
```

### Project Data dengan Customer
```php
[
    [
        'nama' => 'Pembangunan Gedung A',
        'customer' => 'Customer A',
        'nomor_kontrak' => 'KTRK-001',
        'tanggal_kontrak' => '2024-01-15',
        'status' => 'Berjalan',
        'estimasi_nilai' => 500000000,
        'progress' => 75
    ]
]
```

### Chart Data untuk Pie Chart
```php
[
    'customer_pie_chart' => [
        'labels' => ['Customer A', 'Customer B', 'Customer C', 'Customer D', 'Customer E'],
        'data' => [3, 3, 2, 2, 2],
        'colors' => [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)'
        ]
    ],
    'status_pie_chart' => [
        'labels' => ['Berjalan', 'Selesai', 'Pending', 'Ditolak'],
        'data' => [6, 2, 2, 2],
        'colors' => [
            'rgba(40, 167, 69, 0.8)',   // Berjalan - Hijau
            'rgba(108, 117, 125, 0.8)', // Selesai - Abu-abu
            'rgba(255, 193, 7, 0.8)',   // Pending - Kuning
            'rgba(220, 53, 69, 0.8)'    // Ditolak - Merah
        ]
    ]
]
```

## Fitur Baru Dashboard

### 1. **Card Dashboard**
- **Target Sales**: Menampilkan target penjualan yang harus dicapai
- **Target Pemasaran**: Menampilkan target pemasaran yang harus dicapai
- **Persentase Proyek**: Menampilkan persentase keberhasilan proyek
- **Total Proyek**: Menampilkan jumlah total proyek

### 2. **Pie Chart Customer**
- Menampilkan distribusi proyek berdasarkan customer (A-E)
- Warna berbeda untuk setiap customer
- Tooltip menampilkan jumlah proyek dan persentase

### 3. **Pie Chart Status Proyek**
- Menampilkan distribusi status proyek (Berjalan, Selesai, Pending, Ditolak)
- Warna sesuai dengan status (Hijau, Abu-abu, Kuning, Merah)
- Tooltip menampilkan jumlah proyek dan persentase

### 4. **Filter Customer**
- Filter data berdasarkan customer
- Dropdown berisi semua customer yang tersedia
- AJAX request untuk filtering real-time

### 5. **Status Proyek yang Diperbarui**
- **Berjalan**: Proyek yang sedang dalam proses
- **Selesai**: Proyek yang telah selesai
- **Pending**: Proyek yang menunggu persetujuan
- **Ditolak**: Proyek yang ditolak

## Testing

### 1. **Test Controller Methods**
```php
// Test dashboard stats
$controller = new dashboardController();
$stats = $controller->getDashboardStats();
$this->assertEquals('Rp 10.5M', $stats['target_sales']);

// Test project data
$projects = $controller->getProjectData();
$this->assertCount(12, $projects);
$this->assertArrayHasKey('customer', $projects[0]);
```

### 2. **Test API Endpoints**
```php
// Test filter endpoint dengan customer
$response = $this->postJson('/dashboard/filter', [
    'customer' => 'Customer A',
    'status' => 'Berjalan'
]);
$response->assertStatus(200);
$response->assertJsonStructure(['data', 'count']);
```

### 3. **Test Chart Data**
```php
// Test chart data generation
$controller = new dashboardController();
$chartData = $controller->getChartData();
$this->assertArrayHasKey('customer_pie_chart', $chartData);
$this->assertArrayHasKey('status_pie_chart', $chartData);
```

## Kesimpulan

Migrasi ini telah berhasil memindahkan semua logic dari blade template ke controller dan memperbarui tampilan dashboard untuk menampilkan data yang lebih relevan untuk bisnis. Dashboard sekarang menampilkan:

1. **Target Sales dan Pemasaran** untuk monitoring performa
2. **Persentase Proyek** untuk melihat keberhasilan
3. **Pie Chart Customer** untuk analisis distribusi customer
4. **Pie Chart Status** untuk monitoring status proyek
5. **Filter Customer** untuk pencarian data yang lebih spesifik

Semua fungsionalitas tetap berjalan seperti sebelumnya, namun dengan arsitektur yang lebih baik dan data yang lebih relevan untuk kebutuhan bisnis. 