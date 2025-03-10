@extends('layouts.app', ['pageSlug' => 'request-assets'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4>Preview Asset Requests</h4>
                        <div id="previewContainer"></div>
                        <div class="buttongroup">
                            <button class="btn btn-secondary" onclick="goBack()">Edit</button>
                            <button class="btn btn-primary" id="confirmSubmit">Confirm and Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let previewContainer = document.getElementById('previewContainer');
            let requests = JSON.parse(sessionStorage.getItem('assetRequests')) || [];

            if (requests.length === 0) {
                previewContainer.innerHTML = "<p>No requests found.</p>";
                return;
            }

            requests.forEach((request, index) => {
                previewContainer.innerHTML += `
                    <div>
                        <h5>Request ${index + 1}</h5>
                        <p><b>Asset Type:</b> ${request.asset_type}</p>
                        <p><b>Brand:</b> ${request.brand}</p>
                        <p><b>Product Name:</b> ${request.product_name}</p>
                        <p><b>Amount:</b> ${request.amount}</p>
                        <p><b>Notes:</b> ${request.notes}</p>
                        <hr>
                    </div>
                `;
            });

            document.getElementById('confirmSubmit').addEventListener('click', function() {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('assetsmanagement.submit') }}"; // ✅ Use correct route

                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = "{{ csrf_token() }}";
                form.appendChild(csrfInput);

                let dataInput = document.createElement('input');
                dataInput.type = 'hidden';
                dataInput.name = 'requests';
                dataInput.value = JSON.stringify(requests);
                form.appendChild(dataInput);

                document.body.appendChild(form);
                form.submit();
            });
        });

        function goBack() {
            window.history.back();
        }
    </script>
@endsection
