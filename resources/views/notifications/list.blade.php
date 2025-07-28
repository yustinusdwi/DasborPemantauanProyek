@extends('layouts.app')

@section('title', 'Daftar Notifikasi Proyek')

@section('content')
<div class="container-fluid">
<ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar Pemberitahuan</li>
    </ol>
    @if($notifications->isEmpty())
        <div class="alert alert-info">Belum ada notifikasi apapun.</div>
    @else
        @foreach($notifications as $nama_proyek => $notifs)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <strong>{{ $nama_proyek }}</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Pesan</th>
                                <th>Asal Dokumen</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($notifs as $notif)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($notif->batas_akhir)->translatedFormat('d M Y') }}</td>
                                <td>{{ $notif->message }}</td>
                                <td>
                                    @if($notif->type === 'spph')
                                        <span class="badge badge-info">SPPH</span>
                                    @elseif($notif->type === 'kontrak')
                                        <span class="badge badge-warning">Kontrak</span>
                                    @else
                                        <span class="badge badge-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($notif->is_read)
                                        <span class="badge badge-success">Sudah Dibaca</span>
                                    @else
                                        <span class="badge badge-danger">Belum Dibaca</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection 