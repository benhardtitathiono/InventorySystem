<form method="POST" action="{{ route('product.updateStockOut', $pap->id) }}">
    @csrf
    @can('staf')
    {{-- @method('PUT') --}}
    <div class="form-group">
        <label for="idProd">ID produk</label>
        <input type="text" class="form-control" name="idProd" id="idProd" aria-describedby="idHelp"
            value="{{ $pap->id }}" readonly>

        <label for="nameProd">Name produk</label>
        <input type="text" class="form-control" name="nameProd" id="nameProd" aria-describedby="nameHelp"
            value="{{ $pap->nama_barang }}" readonly>

        <label for="batchProd">Batch produk</label>
        @php
            $maxValue = 0;
            $first = true;
        @endphp
        <select name="batchProd" id="batchProd" class="form-control" onchange="updateMaxValue(this)">
            @php
                $groupedBatches = $pap->batchList->sortBy('tanggal_kadaluarsa')->groupBy('id');
            @endphp
            @foreach ($groupedBatches as $batchId => $batches)
                @php
                    $batchModel = \App\Models\Batch::find($batchId);
                    $totalQuantityIn =  $batchModel ? $batchModel->jumlah : 0;
                    $totalQuantityOut = $batches->sum('pivot.quantity_out');
                    $remainingStock = $totalQuantityIn - $totalQuantityOut;
                if ($remainingStock > 0) {
                        if ($first) {
                            $maxValue = $remainingStock;
                            $first = false;
                        }
                @endphp
                        <option value="{{ $batchId }}" data-quantity="{{ $remainingStock }}">
                            {{ $batchId }} - sisa stok: {{ $remainingStock }} ||
                                <strong>tanggal kadaluarsa: {{ $batches->first()->tanggal_kadaluarsa }}</strong>
                        </option>
                @php
                    }
                @endphp
            @endforeach
        </select>
        <label class="stok" for="stok">Stok</label><br>
        Stok Sekarang: {{ $pap->jumlah }}
        <input class="form-control" type="number" name="stokProdQuan" id="stokProdQuan" min="1" max="{{ $maxValue }}" value="1">

    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    function updateMaxValue(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var maxQuantity = selectedOption.getAttribute('data-quantity');
        document.getElementById('stokProdQuan').max = maxQuantity;
    }
    window.onload = function() {
        var selectElement = document.getElementById('batchProd');
        updateMaxValue(selectElement);
    }
</script>
    @endcan
