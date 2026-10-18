@php
    $urutan = ['menunggu' => 'Diajukan', 'disetujui' => 'Disetujui', 'aktif' => 'Kucing Masuk', 'selesai' => 'Selesai'];
    $indeks = array_search($penitipan->status, array_keys($urutan));
@endphp

<ol class="steps">
    @if ($penitipan->status === 'ditolak')
        <li class="done">Diajukan</li>
        <li class="fail">Ditolak</li>
    @else
        @foreach ($urutan as $kode => $label)
            @php $i = array_search($kode, array_keys($urutan)); @endphp
            <li class="{{ $i < $indeks || $penitipan->status === 'selesai' ? 'done' : ($i === $indeks ? 'now' : '') }}">{{ $label }}</li>
        @endforeach
    @endif
</ol>
