@extends('layout.halaman_utama_admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/modalContent.css') }}" type="text/css">
@endsection

@section('konten')
    <div class="page-content">
        @if ($errors->has('error'))
            <div class="alert alert-danger">
                <p>{{ $errors->first('error') }}</p>
            </div>
        @endif

        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <form id="formBorrow" method="POST" action="{{ route('productpinjam.borrowProduct') }}">
            @csrf
            <label for="identityPinjam">Identitas peminjam</label>
            <select class="form-control" name="identityPinjam" id="identityPinjam" aria-describedby="identityHelp"
                onchange="saveSessionIdentity(this)">
                @foreach ($idPeminjam as $identityPeminjam)
                    <option value="{{ $identityPeminjam->id }}" data-idIdentity="{{ $identityPeminjam->id }}">
                        {{ $identityPeminjam->id . ' - ' . $identityPeminjam->nama }}
                    </option>
                @endforeach
            </select>
            <div class="form-group">
                <div class="form-prog-borrow">
                    <label for="idProd">ID produk</label>
                    <select class="form-control" name="idProd" id="idProd" aria-describedby="idHelp"
                        onchange="saveId(this)">
                        @foreach ($barangPinjam as $barangPinjam)
                            <option value="{{ $barangPinjam->id }}" data-idProd="{{ $barangPinjam->id }}"
                                data-total="{{ $barangPinjam->jumlah }}"
                                data-stokTersedia="{{ $barangPinjam->totalBarangDipinjam }}">
                                {{ $barangPinjam->id . ' - ' . $barangPinjam->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                    <div class="stokBorrow">
                        Stok Barang: <span id="stokTotalProd" name="stokTotalProd"></span><br>
                        Stok Yang Bisa Dipinjam: <span id="stokBorrowProd" name="stokBorrowProd"></span><br>
                        <label class="stok" for="stok">Total barang dipinjam</label>
                        <input class="form-control" type="number" name="stokProdQuan" id="stokProdQuan" min="1"
                            max="1" value="1">
                    </div>
                </div>
            </div>
            <input type="hidden" name="totProdBorrow" id="totProdBorrow">
            <input type="hidden" name="idIdentity" id="idIdentity">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" id="addInput" class="btn btn-secondary">Add Input</button>
        </form>
        <input type="hidden" name="totProd" id="totProd" value="{{ $totProd }}">
    </div>
@endsection

@section('javascript')
    <script>
        var form = document.getElementById('formBorrow');
        var idIdentityInput = document.getElementById('idIdentity');
        var idInput = document.getElementById('idProd');
        var formCount = 1;

        function saveSessionIdentity(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var idIdentity = selectedOption.getAttribute('data-idIdentity');
            sessionStorage.setItem('idIdentity', idIdentity);
        }

        function saveId(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var idProd = selectedOption.getAttribute('data-idProd');
            sessionStorage.setItem('idProd', idProd);

            var total = selectedOption.getAttribute('data-total');
            var stokTersedia = selectedOption.getAttribute('data-stokTersedia');

            var formGroup = $(selectElement).closest('.form-prog-borrow');

            var stokProdQuan = formGroup.find('input[type=number]')[0];
            var stokBorrowProd = formGroup.find('.stokBorrow > span')[1];
            var stokTotalProd = formGroup.find('.stokBorrow > span')[0];

            stokProdQuan.max = total - stokTersedia;
            stokBorrowProd.textContent = total - stokTersedia;
            stokTotalProd.textContent = total;
        }

        window.onload = function() {
            var selectElementID = document.getElementById('identityPinjam');
            var selectedOptionID = selectElementID.options[selectElementID.selectedIndex];
            var idIdentity = selectedOptionID.getAttribute('data-idIdentity');
            idIdentityInput.value = idIdentity;

            var selectElement = document.getElementById('idProd');
            var selectedOption = selectElement.options[selectElement.selectedIndex];

            var total = selectedOption.getAttribute('data-total');
            var stokTersedia = selectedOption.getAttribute('data-stokTersedia');

            // console.log(idIdentity);

            document.getElementById('stokProdQuan').max = total - stokTersedia;
            document.getElementById('stokTotalProd').textContent = total;
            document.getElementById('stokBorrowProd').textContent = total - stokTersedia;
        }

        form.addEventListener('submit', function() {
            var selectElementId = document.getElementById('identityPinjam');
            var selectedOptionid = selectElement.options[selectElement.selectedIndex];
            var idIdentity = selectedOption.getAttribute('data-idIdentity');
            idIdentityInput.value = idIdentity;

            var selectElementProd = document.getElementById('stokProdQuan');
            var selectedOptionProd = selectElement.options[selectElement.selectedIndex];
            var idProd = selectedOption.value;
            idInput.value = idProd;
        });

        var maxForms = document.getElementById('totProd').value;
        // console.log(document.getElementById('totProd').value);

        $('#addInput').click(function() {
            if (formCount < maxForms) {
                var clonedFormGroup = $('.form-prog-borrow').first().clone();
                clonedFormGroup.find('input, select, span').each(function() {
                    var originalName = $(this).attr('name');
                    $(this).attr('name', originalName + formCount);
                    var originalName = $(this).attr('id');
                    $(this).attr('id', originalName + formCount);
                });
                var selectedProductId = $('.form-prog-borrow').first().find('select[name="idProd"]').val();
                clonedFormGroup.find('select[name="idProd' + formCount + '"]').find('option[value="' +
                    selectedProductId + '"]').remove();

                clonedFormGroup.appendTo('.form-group');

                var selectElement = document.getElementById('idProd' + formCount);
                var selectedOption = selectElement.options[selectElement.selectedIndex];

                var total = selectedOption.getAttribute('data-total');
                var stokTersedia = selectedOption.getAttribute('data-stokTersedia');

                document.getElementById('stokProdQuan' + formCount).max = total - stokTersedia;
                document.getElementById('stokTotalProd' + formCount).textContent = total;
                document.getElementById('stokBorrowProd' + formCount).textContent = total - stokTersedia;

                formCount++;
                document.getElementById('formBorrow').totProdBorrow.value = formCount;
            } else {
                alert(
                    'Anda tidak dapat menambahkan lebih banyak barang. Jumlah form tidak boleh melebihi jumlah total barang.'
                );
            }
        });
    </script>
@endsection
