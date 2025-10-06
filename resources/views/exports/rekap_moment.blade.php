<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Nasabah</th>
            <th>CIF</th>
            <th>Tanggal Lahir</th>
            <th>No HP</th>
            <th>Moments</th>
            <th>Deskripsi</th>
            <th>Foto Moment</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Diinput Oleh</th>
            <th>Tanggal Input</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($moments as $index => $moment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $moment->nm_nasabah }}</td>
                <td>{{ $moment->cif }}</td>
                <td>{{ \Carbon\Carbon::parse($moment->tgl_lahir)->format('d-m-Y') }}</td>
                <td>{{ $moment->no_hp }}</td>
                <td>{{ $moment->moments }}</td>
                <td>{{ $moment->deskripsi ?? '-' }}</td>
                <td>
                    @if ($moment->foto_moment)
                        <img src="{{ public_path('storage/moment/' . $moment->foto_moment) }}" width="80">
                    @else
                        -
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($moment->tgl_mulai)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($moment->tgl_selesai)->format('d-m-Y') }}</td>
                <td>{{ $moment->user->detail->nama ?? $moment->user->username }}</td>
                <td>{{ $moment->created_at->format('d-m-Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
