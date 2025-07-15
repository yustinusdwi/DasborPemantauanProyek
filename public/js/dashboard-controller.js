/**
 * Dashboard Controller JavaScript
 * Menangani semua logic dashboard yang dipindahkan dari blade template
 */

class DashboardController {
    constructor() {
        this.chartData = null;
        this.init();
    }

    init() {
        this.initializeEventListeners();
        this.showDashboard();
    }

    initializeEventListeners() {
        // Sidebar toggle (handle)
        const sidebarToggleHandle = document.getElementById('sidebarToggleHandle');
        if (sidebarToggleHandle) {
            sidebarToggleHandle.addEventListener('click', (e) => {
                e.preventDefault();
                const sidenav = document.getElementById('layoutSidenav_nav');
                if (sidenav) {
                    sidenav.classList.toggle('sidebar-hidden');
                }
            });
        }
        // Sidebar toggle (lama, jika masih ada)
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', (e) => {
                e.preventDefault();
                document.body.classList.toggle('sb-sidenav-toggled');
            });
        }

        // Add smooth transition to sidebar
        const layoutSidenav = document.getElementById('layoutSidenav');
        if (layoutSidenav) {
            layoutSidenav.style.transition = 'all 0.3s cubic-bezier(.4,2,.6,1)';
        }
    }

    setChartData(data) {
        this.chartData = data;
    }

    showDashboard() {
        const dataProyekSection = document.getElementById('dataProyekSection');
        if (dataProyekSection) dataProyekSection.style.display = 'none';
        const sphSection = document.getElementById('sphSection');
        if (sphSection) sphSection.style.display = 'none';
        const negoSection = document.getElementById('negoSection');
        if (negoSection) negoSection.style.display = 'none';
        const kontrakSection = document.getElementById('kontrakSection');
        if (kontrakSection) kontrakSection.style.display = 'none';
        const filterDataSection = document.getElementById('filterDataSection');
        if (filterDataSection) filterDataSection.style.display = 'none';
        // Show dashboard content
        const dashboardContent = document.querySelector('.container-fluid');
        if (dashboardContent) {
            const dashboardElements = dashboardContent.children;
            for (let i = 0; i < dashboardElements.length - 6; i++) {
                dashboardElements[i].style.display = 'block';
            }
        }
        this.initializeCharts();
    }

    showDataProyekSection() {
        const dataProyekSection = document.getElementById('dataProyekSection');
        if (dataProyekSection) dataProyekSection.style.display = 'block';
        const sphSection = document.getElementById('sphSection');
        if (sphSection) sphSection.style.display = 'none';
        const negoSection = document.getElementById('negoSection');
        if (negoSection) negoSection.style.display = 'none';
        const kontrakSection = document.getElementById('kontrakSection');
        if (kontrakSection) kontrakSection.style.display = 'none';
        const filterDataSection = document.getElementById('filterDataSection');
        if (filterDataSection) filterDataSection.style.display = 'none';
        
        // Hide dashboard content
        const dashboardContent = document.querySelector('.container-fluid');
        if (dashboardContent) {
            const dashboardElements = dashboardContent.children;
            for (let i = 0; i < dashboardElements.length - 6; i++) {
                dashboardElements[i].style.display = 'none';
            }
        }
        
        this.initializeDataProyekTable();
    }

    showSpphSection() {
        this.showDataProyekSection();
    }

    showSphSection() {
        const dataProyekSection = document.getElementById('dataProyekSection');
        if (dataProyekSection) dataProyekSection.style.display = 'none';
        const sphSection = document.getElementById('sphSection');
        if (sphSection) sphSection.style.display = 'block';
        const negoSection = document.getElementById('negoSection');
        if (negoSection) negoSection.style.display = 'none';
        const kontrakSection = document.getElementById('kontrakSection');
        if (kontrakSection) kontrakSection.style.display = 'none';
        const filterDataSection = document.getElementById('filterDataSection');
        if (filterDataSection) filterDataSection.style.display = 'none';
        
        // Hide dashboard content
        const dashboardContent = document.querySelector('.container-fluid');
        if (dashboardContent) {
            const dashboardElements = dashboardContent.children;
            for (let i = 0; i < dashboardElements.length - 6; i++) {
                dashboardElements[i].style.display = 'none';
            }
        }
        
        this.initializeSphTable();
    }

    showNegoSection() {
        const dataProyekSection = document.getElementById('dataProyekSection');
        if (dataProyekSection) dataProyekSection.style.display = 'none';
        const sphSection = document.getElementById('sphSection');
        if (sphSection) sphSection.style.display = 'none';
        const negoSection = document.getElementById('negoSection');
        if (negoSection) negoSection.style.display = 'block';
        const kontrakSection = document.getElementById('kontrakSection');
        if (kontrakSection) kontrakSection.style.display = 'none';
        const filterDataSection = document.getElementById('filterDataSection');
        if (filterDataSection) filterDataSection.style.display = 'none';
        
        // Hide dashboard content
        const dashboardContent = document.querySelector('.container-fluid');
        if (dashboardContent) {
            const dashboardElements = dashboardContent.children;
            for (let i = 0; i < dashboardElements.length - 6; i++) {
                dashboardElements[i].style.display = 'none';
            }
        }
        
        this.initializeNegoTable();
    }

    showKontrakSection() {
        const dataProyekSection = document.getElementById('dataProyekSection');
        if (dataProyekSection) dataProyekSection.style.display = 'none';
        const sphSection = document.getElementById('sphSection');
        if (sphSection) sphSection.style.display = 'none';
        const negoSection = document.getElementById('negoSection');
        if (negoSection) negoSection.style.display = 'none';
        const kontrakSection = document.getElementById('kontrakSection');
        if (kontrakSection) kontrakSection.style.display = 'block';
        const filterDataSection = document.getElementById('filterDataSection');
        if (filterDataSection) filterDataSection.style.display = 'none';
        
        // Hide dashboard content
        const dashboardContent = document.querySelector('.container-fluid');
        if (dashboardContent) {
            const dashboardElements = dashboardContent.children;
            for (let i = 0; i < dashboardElements.length - 6; i++) {
                dashboardElements[i].style.display = 'none';
            }
        }
        
        this.initializeKontrakTable();
    }

    showFilterDataSection() {
        const dataProyekSection = document.getElementById('dataProyekSection');
        if (dataProyekSection) dataProyekSection.style.display = 'none';
        const sphSection = document.getElementById('sphSection');
        if (sphSection) sphSection.style.display = 'none';
        const negoSection = document.getElementById('negoSection');
        if (negoSection) negoSection.style.display = 'none';
        const kontrakSection = document.getElementById('kontrakSection');
        if (kontrakSection) kontrakSection.style.display = 'none';
        const filterDataSection = document.getElementById('filterDataSection');
        if (filterDataSection) filterDataSection.style.display = 'block';
        
        // Hide dashboard content
        const dashboardContent = document.querySelector('.container-fluid');
        if (dashboardContent) {
            const dashboardElements = dashboardContent.children;
            for (let i = 0; i < dashboardElements.length - 6; i++) {
                dashboardElements[i].style.display = 'none';
            }
        }
        
        this.initializeFilteredTable();
    }

    initializeDataProyekTable() {
        if ($.fn.DataTable.isDataTable('#dataProyekTable')) {
            $('#dataProyekTable').DataTable().destroy();
        }
        
        $('#dataProyekTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json",
                "zeroRecords": "Data tidak ditemukan"
            },
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "order": [[0, "asc"]],
            "responsive": true
        });
    }

    initializeSphTable() {
        if ($.fn.DataTable.isDataTable('#sphTable')) {
            $('#sphTable').DataTable().destroy();
        }
        
        $('#sphTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json",
                "zeroRecords": "Data tidak ditemukan"
            },
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "order": [[0, "asc"]],
            "responsive": true
        });
    }

    initializeNegoTable() {
        if ($.fn.DataTable.isDataTable('#negoTable')) {
            $('#negoTable').DataTable().destroy();
        }
        
        $('#negoTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json",
                "zeroRecords": "Data tidak ditemukan"
            },
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "order": [[0, "asc"]],
            "responsive": true
        });
    }

    initializeKontrakTable() {
        if ($.fn.DataTable.isDataTable('#kontrakTable')) {
            $('#kontrakTable').DataTable().destroy();
        }
        
        $('#kontrakTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json",
                "zeroRecords": "Data tidak ditemukan"
            },
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "order": [[0, "asc"]],
            "responsive": true
        });
    }

    initializeFilteredTable() {
        if ($.fn.DataTable.isDataTable('#filteredTable')) {
            $('#filteredTable').DataTable().destroy();
        }
        
        $('#filteredTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json",
                "zeroRecords": "Data tidak ditemukan"
            },
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "order": [[0, "asc"]],
            "responsive": true
        });
    }

    async applyFilter() {
        const formData = {
            nama_proyek: document.getElementById('namaProyek').value,
            spph: document.getElementById('spph').value,
            sph: document.getElementById('sph').value,
            nego: document.getElementById('nego').value,
            kontrak: document.getElementById('kontrak').value
        };
        
        try {
            const response = await fetch('/dashboard/filter', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(formData)
            });
            
            const data = await response.json();
            this.updateFilteredTable(data.data);
            alert(`Filter berhasil diterapkan! Ditemukan ${data.count} data.`);
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menerapkan filter.');
        }
    }

    updateFilteredTable(data) {
        const table = $('#filteredTable').DataTable();
        table.clear();
        
        data.forEach((project, index) => {
            table.row.add([
                index + 1,
                project.nama,
                project.spph,
                project.sph,
                project.nego,
                project.kontrak,
                project.progress_bar,
                '<button class="btn btn-sm btn-info">Detail</button> <button class="btn btn-sm btn-warning">Edit</button>'
            ]);
        });
        
        table.draw();
    }

    resetFilter() {
        document.getElementById('filterForm').reset();
        
        // Clear filtered table
        const table = $('#filteredTable').DataTable();
        table.clear().draw();
        
        alert('Filter berhasil direset!');
    }

    initializeCharts() {
        if (typeof Chart === 'undefined' || !this.chartData) {
            return;
        }

        // Destroy existing charts if they exist
        if (window.customerPieChart && typeof window.customerPieChart.destroy === 'function') {
            window.customerPieChart.destroy();
        }
        if (window.statusPieChart && typeof window.statusPieChart.destroy === 'function') {
            window.statusPieChart.destroy();
        }

        // Customer Pie Chart
        const customerPieChartCtx = document.getElementById('customerPieChart');
        if (customerPieChartCtx) {
            window.customerPieChart = new Chart(customerPieChartCtx, {
                type: 'pie',
                data: {
                    labels: this.chartData.customer_pie_chart.labels,
                    datasets: [{
                        data: this.chartData.customer_pie_chart.data,
                        backgroundColor: this.chartData.customer_pie_chart.colors,
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                const dataset = data.datasets[tooltipItem.datasetIndex];
                                const total = dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((dataset.data[tooltipItem.index] / total) * 100).toFixed(1);
                                return data.labels[tooltipItem.index] + ': ' + dataset.data[tooltipItem.index] + ' proyek (' + percentage + '%)';
                            }
                        }
                    }
                }
            });
        }
        
        // Status Pie Chart
        const statusPieChartCtx = document.getElementById('statusPieChart');
        if (statusPieChartCtx && this.chartData.status_pie_chart && Array.isArray(this.chartData.status_pie_chart.labels) && this.chartData.status_pie_chart.labels.length > 0) {
            window.statusPieChart = new Chart(statusPieChartCtx, {
                type: 'pie',
                data: {
                    labels: this.chartData.status_pie_chart.labels,
                    datasets: [{
                        data: this.chartData.status_pie_chart.data,
                        backgroundColor: this.chartData.status_pie_chart.colors,
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                const dataset = data.datasets[tooltipItem.datasetIndex];
                                const total = dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((dataset.data[tooltipItem.index] / total) * 100).toFixed(1);
                                return data.labels[tooltipItem.index] + ': ' + dataset.data[tooltipItem.index] + ' proyek (' + percentage + '%)';
                            }
                        }
                    }
                }
            });
        } else if (statusPieChartCtx) {
            // Jika data kosong, tampilkan pesan
            statusPieChartCtx.insertAdjacentHTML('afterend', '<div class="text-center text-muted mt-2">Tidak ada data untuk ditampilkan</div>');
        }
    }
}

// Global functions untuk kompatibilitas dengan onclick events
function showDashboard() {
    if (window.dashboardController) {
        window.dashboardController.showDashboard();
    }
}

function showDataProyekSection() {
    if (window.dashboardController) {
        window.dashboardController.showDataProyekSection();
    }
}

function showSpphSection() {
    if (window.dashboardController) {
        window.dashboardController.showSpphSection();
    }
}

function showSphSection() {
    if (window.dashboardController) {
        window.dashboardController.showSphSection();
    }
}

function showNegoSection() {
    if (window.dashboardController) {
        window.dashboardController.showNegoSection();
    }
}

function showKontrakSection() {
    if (window.dashboardController) {
        window.dashboardController.showKontrakSection();
    }
}

function showFilterDataSection() {
    if (window.dashboardController) {
        window.dashboardController.showFilterDataSection();
    }
}

function applyFilter() {
    if (window.dashboardController) {
        window.dashboardController.applyFilter();
    }
}

function resetFilter() {
    if (window.dashboardController) {
        window.dashboardController.resetFilter();
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dashboard controller
    window.dashboardController = new DashboardController();
    
    // Set chart data if available
    if (typeof chartData !== 'undefined') {
        window.dashboardController.setChartData(chartData);
    }

    // Handler pop up detail proyek universal
    $(document).on('click', '.proyek-check', function(e) {
        e.preventDefault();
        var data = $(this).data('info');
        if (typeof data === 'string') data = JSON.parse(data);
        var tipe = $(this).data('tipe');
        function formatRupiah(angka) {
            if (!angka || isNaN(angka)) return '-';
            var number_string = angka.toString().replace(/[^\d]/g, ''),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);
            if (ribuan) {
                rupiah += (sisa ? '.' : '') + ribuan.join('.');
            }
            return 'Rp. ' + rupiah;
        }
        var html = '<div class="table-responsive"><table class="table table-bordered">';
        html += '<thead><tr>';
        if (tipe === 'spph') {
            html += '<th>Nomor SPPH</th><th>Tanggal</th><th>Batas Akhir SPH</th><th>Uraian</th>';
        } else if (tipe === 'sph') {
            html += '<th>Nomor SPH</th><th>Tanggal</th><th>Uraian</th><th>Harga Total</th>';
        } else if (tipe === 'nego') {
            html += '<th>Nomor Nego</th><th>Tanggal</th><th>Uraian</th><th>Harga Total</th>';
        } else if (tipe === 'kontrak') {
            html += '<th>Nomor Kontrak</th><th>Tanggal</th><th>Uraian</th><th>Harga Total</th>';
        }
        html += '</tr></thead><tbody><tr>';
        if (tipe === 'spph') {
            html += '<td>' + (data.no_spph || '-') + '</td>';
            html += '<td>' + (data.tanggal || '-') + '</td>';
            html += '<td>' + (data.batas_akhir || '-') + '</td>';
            html += '<td>' + (data.uraian || '-') + '</td>';
        } else if (tipe === 'sph') {
            html += '<td>' + (data.no_sph || '-') + '</td>';
            html += '<td>' + (data.tanggal || '-') + '</td>';
            html += '<td>' + (data.uraian || '-') + '</td>';
            html += '<td>' + (data.harga_total ? formatRupiah(data.harga_total) : '-') + '</td>';
        } else if (tipe === 'nego') {
            html += '<td>' + (data.no_nego || '-') + '</td>';
            html += '<td>' + (data.tanggal || '-') + '</td>';
            html += '<td>' + (data.uraian || '-') + '</td>';
            html += '<td>' + (data.harga_total ? formatRupiah(data.harga_total) : '-') + '</td>';
        } else if (tipe === 'kontrak') {
            html += '<td>' + (data.no_kontrak || '-') + '</td>';
            html += '<td>' + (data.tanggal || '-') + '</td>';
            html += '<td>' + (data.uraian || '-') + '</td>';
            html += '<td>' + (data.harga_total ? formatRupiah(data.harga_total) : '-') + '</td>';
        }
        html += '</tr></tbody></table></div>';
        $('#proyekInfoContent').html(html);
        $('#proyekInfoModal').modal('show');
        return false;
    });
}); 