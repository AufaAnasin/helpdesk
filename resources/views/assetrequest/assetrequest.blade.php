@extends('layouts.app', ['pageSlug' => 'request-assets'])

@section('content')

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    </head>

    <body>
        <div class="card">
            <div class="card-body">
                <form id="assetRequestForm">
                    @csrf
                    <h4>Request Assets</h4>

                    <!-- Single Asset Type Section -->
                    <div class="contentWrapper">
                        <div class="inputWrapper">
                            <div class="textContainer">
                                <h5><b>Asset Type</b></h5>
                                <p>Select whether the asset is Software or Hardware.</p>
                            </div>
                            <div class="inputContainer">
                                <input type="checkbox" id="toggle" class="toggleCheckbox" />
                                <label for="toggle" class='toggleContainer'>
                                    <div>Software</div>
                                    <div>Hardware</div>
                                </label>
                                <input type="hidden" id="selectedValue" name="asset_type" value="Software">
                            </div>
                        </div>
                        <div class="borderLine"></div>
                    </div>

                    <!-- Asset Request Items Container -->
                    <div id="requestContainer">
                        <div class="requestItem">
                            <div class="contentWrapper">
                                <div class="inputWrapper">
                                    <div class="textContainer">
                                        <h5><b>Asset Details</b></h5>
                                        <p>Provide details about the requested asset.</p>
                                    </div>
                                    <div class="inputContainer">
                                        <div class="form-group">
                                            <label>Brand</label>
                                            <select class="form-control brand" name="brand_1" required>
                                                <option selected>Microsoft</option>
                                                <option value="Zoom">Zoom</option>
                                                <option value="Foxit">Foxit</option>
                                                <option value="Autodesk">Autodesk</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Product Name</label>
                                            <input type="text" class="form-control product_name" name="product_name_1"
                                                placeholder="Product Name..." required>
                                        </div>
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" class="form-control amount" name="amount_1"
                                                placeholder="Product Number..." required>
                                        </div>
                                        <div class="form-group">
                                            <label>Additional Notes</label>
                                            <textarea class="form-control notes" name="notes_1" rows="3"></textarea>
                                        </div>
                                        <div class="buttongroup">
                                            <button type="button" class="btn btn-success addRequest">Add Another
                                                Request</button>
                                            <button type="button" class="btn btn-danger removeRequest">
                                                <i class="tim-icons icon-trash-simple"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button at the Last Input Form -->
                    <div id="submitContainer" class="buttongroup">
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </body>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let requestCount = 1;
            const submitBtn = document.getElementById('submitBtn');
            const submitContainer = document.getElementById('submitContainer');
            const assetTypeInput = document.getElementById('selectedValue');
            const toggleCheckbox = document.getElementById('toggle');

            // Ensure asset type selection updates hidden input
            toggleCheckbox.addEventListener('change', function() {
                assetTypeInput.value = this.checked ? 'Hardware' : 'Software';
            });

            function checkFormCompletion() {
                let allFilled = true;
                document.querySelectorAll('.requestItem').forEach(item => {
                    item.querySelectorAll('input[required], select[required]').forEach(input => {
                        if (!input.value.trim()) {
                            allFilled = false;
                        }
                    });
                });
                submitBtn.disabled = !allFilled;
            }

            function attachValidationListeners() {
                document.querySelectorAll('.requestItem input[required], .requestItem select[required]').forEach(
                    input => {
                        input.addEventListener('input', checkFormCompletion);
                    });
            }

            function addRequestHandler(event) {
                event.preventDefault();
                requestCount++;

                let requestContainer = document.getElementById('requestContainer');
                let originalRequest = document.querySelector('.requestItem');
                let newRequest = originalRequest.cloneNode(true);

                newRequest.querySelectorAll('input, select, textarea').forEach(element => {
                    if (element.name) {
                        let nameParts = element.name.split('_');
                        let fieldName = nameParts[0];
                        element.name = fieldName + "_" + requestCount;
                        if (element.id) {
                            element.id = fieldName + "_" + requestCount;
                        }
                    }
                    if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                        element.value = ''; // Clear input values for new entry
                    }
                });

                requestContainer.appendChild(newRequest);
                requestContainer.appendChild(submitContainer);

                newRequest.querySelector('.addRequest').addEventListener('click', addRequestHandler);
                newRequest.querySelector('.removeRequest').addEventListener('click', removeRequestHandler);

                attachValidationListeners();
                checkFormCompletion();
            }

            function removeRequestHandler(event) {
                event.preventDefault();
                let requestItem = event.target.closest('.requestItem');
                if (document.querySelectorAll('.requestItem').length > 1) {
                    requestItem.remove();
                } else {
                    alert("At least one request is required.");
                }
                checkFormCompletion();
            }

            document.querySelector('.addRequest').addEventListener('click', addRequestHandler);
            document.querySelectorAll('.removeRequest').forEach(button => {
                button.addEventListener('click', removeRequestHandler);
            });

            attachValidationListeners();
            checkFormCompletion();

            // Form submission - Redirect to Preview Page
            document.getElementById('assetRequestForm').addEventListener('submit', function(event) {
                event.preventDefault();

                let assetType = assetTypeInput.value;
                let formData = [];

                document.querySelectorAll('.requestItem').forEach((item) => {
                    let request = {
                        asset_type: assetType, // ✅ Include asset type in request
                        brand: item.querySelector('.brand').value,
                        product_name: item.querySelector('.product_name').value,
                        amount: item.querySelector('.amount').value,
                        notes: item.querySelector('.notes').value
                    };
                    formData.push(request);
                });

                // Store form data in sessionStorage for preview
                sessionStorage.setItem('assetRequests', JSON.stringify(formData));

                // Redirect to the preview page
                window.location.href = "/request-assets/preview";
            });
        });
    </script>

    <style>
        .buttongroup {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .form-group input {}

        .inputWrapper {
            display: flex;
            flex-direction: row;
        }

        .textContainer {
            width: 100%;
        }

        .borderLine {
            width: 100%;
            height: 1px;
            background-color: white;
            margin-bottom: 20px;

        }

        .contentWrapper .textContainer h5 {
            margin-bottom: 0;
        }

        .contentWrapper .textContainer p {
            max-width: 332px;
        }

        .contentWrapper {
            display: flex;
            flex-direction: column;
            margin-top: 5px;
        }

        .inputContainer {
            margin-left: 20px;
            width: 100%;
        }

        .toggleContainer {
            position: relative;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            width: 262px;
            border: 3px solid #343434;
            border-radius: 6px;
            background: #343434;
            font-weight: bold;
            color: #343434;
            cursor: pointer;
        }

        .toggleContainer::before {
            content: '';
            position: absolute;
            width: 50%;
            height: 100%;
            left: 0%;
            border-radius: 6px;
            background: white;
            transition: all 0.3s;
        }

        .toggleCheckbox:checked+.toggleContainer::before {
            left: 50%;
        }

        .toggleContainer div {
            padding: 6px;
            text-align: center;
            z-index: 1;
        }

        .toggleCheckbox {
            display: none;
        }

        .toggleCheckbox:checked+.toggleContainer div:first-child {
            color: white;
            transition: color 0.3s;
        }

        .toggleCheckbox:checked+.toggleContainer div:last-child {
            color: #343434;
            transition: color 0.3s;
        }

        .toggleCheckbox+.toggleContainer div:first-child {
            color: #343434;
            transition: color 0.3s;
        }

        .toggleCheckbox+.toggleContainer div:last-child {
            color: white;
            transition: color 0.3s;
        }

        @media (max-width: 768px) {
            .inputWrapper {
                display: flex;
                flex-direction: column;
            }

            .inputContainer {
                margin-left: 0;
                margin-top: 10px;
            }

            .textContainer p {
                width: 100%;
                font-size: 12px;
            }
        }
    </style>
@endsection
