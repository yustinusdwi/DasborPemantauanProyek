@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar BAPP</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nomor BAPP</th>
                    <th>Nomor PO</th>
                    <th>Tanggal PO</th>
                    <th>Tanggal Terima</th>
                    <th>Nama Proyek</th>
                    <th>Berkas BAPP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bapps as $bapp)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bapp->nomor_bapp }}</td>
                    <td>{{ $bapp->no_po }}</td>
                    <td>{{ $bapp->tanggal_po }}</td>
                    <td>{{ $bapp->tanggal_terima }}</td>
                    <td>{{ $bapp->nama_proyek }}</td>
                    <td>
                        @if($bapp->berkas_bapp)
                        <a href="{{ asset('storage/' . $bapp->berkas_bapp) }}" target="_blank" class="btn btn-sm btn-primary">Pratinjau</a>
                        @else
                        <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data BAPP.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 