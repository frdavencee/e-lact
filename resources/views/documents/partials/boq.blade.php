<div class="card mb-3" id="section-boq">
    <div class="card-header bg-white">
        <h5 class="mb-0">2. Laporan Bill of Quantity</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Kode Item</th>
                        <th>Nama Material</th>
                        <th>Volume</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($boqItems as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->item_code ?? '-' }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ $item->volume }}</td>
                        <td class="text-center">{{ $item->unit }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Belum ada data BOQ.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="text-end mt-3">
            <a href="{{ route('boq.create') }}" class="btn btn-sm btn-primary">Tambah Item BOQ</a>
        </div>
    </div>
</div>
