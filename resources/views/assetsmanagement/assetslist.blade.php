@extends('layouts.app', ['pageSlug' => 'assets-list'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <div class="textTitleContainer">
                        <h5>Assets Lists</h5>
                        <h5><b>Assets</b></h5>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-zoom-split"></i>
                            </div>
                        </div>
                        <input type="text" id="search-input" class="form-control" placeholder="Search by Category, Brand, Product name, Status, and PIC">
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table w-100">
                                    <thead>
                                        <tr>
                                            <th>Asset ID</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Product Name</th>
                                            <th>Status</th>
                                            <th>PIC</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assets as $asset)
                                            <tr>
                                                <td>{{ $asset->id }}</td>
                                                <td>{{ $asset->asset_type }}</td>
                                                <td>{{ $asset->brand }}</td>
                                                <td>{{ $asset->product_name }}</td>
                                                <td>
                                                    <span class="status-badge {{ strtolower($asset->status) }}">
                                                        @if ($asset->status == 'active')
                                                            Active
                                                        @elseif ($asset->status == 'inactive')
                                                            Inactive
                                                        @elseif ($asset->status == 'decommissioned')
                                                            Decommissioned
                                                        @else
                                                            Not Defined
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>{{ $asset->person_in_charge }}</td>
                                                <td class="td-actions text-right">
                                                    <div class="dropdown">
                                                        <button type="button" rel="tooltip" id="dropdownMenuButton"
                                                            data-toggle="dropdown" aria-haspopup="true" 
                                                            aria-expanded="false" class="btn btn-success btn-sm btn-icon">
                                                            <i class="tim-icons icon-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" 
                                                            aria-labelledby="dropdownMenuButton">
                                                            {{-- <a class="dropdown-item" href="{{ url(`/asset-detail?id=` . $asset->asset_id) }}">Detail</a> --}}
                                                            <a class="dropdown-item" href="{{ route('assetsmanagement.getDetailById', ['id' => $asset->id]) }}">Detail</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Title container styles */
        .textTitleContainer h5:nth-child(1) {
            margin-bottom: 0;
        }

        /* Dropdown adjustments */
        .dropdown {
            position: relative; /* Make dropdown relative to its parent */
        }

        .dropdown-menu {
            position: absolute !important; /* Allow dropdown to escape table overflow */
            z-index: 1050; /* Ensure it's above other content */
        }

        /* Table responsiveness */
        .table-responsive {
            overflow-x: auto; /* Preserve horizontal scrolling */
        }

        /* Badge styles for status */
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            color: white;
            font-weight: bold;
            background-color: red;
        }

        .status-badge.active {
            background-color: #28a745; /* Green for Active */
        }

        .status-badge.inactive {
            background-color: #ffc107; /* Yellow for Inactive */
        }

        .status-badge.decommissioned {
            background-color: #007bff; /* Blue for Decommissioned */
        }

        /* Prevent cell wrapping for dropdown actions */
        .td-actions {
            white-space: nowrap;
        }
    </style>

    <script>
        let debounceTimer;

        document.getElementById('search-input').addEventListener('input', function () {
            const query = this.value;

            // Clear the previous timer
            clearTimeout(debounceTimer);

            // Set a new timer
            debounceTimer = setTimeout(() => {
                fetchSearchResults(query); // Call the search function after 3 seconds
            }, 3000);
        });

        function fetchSearchResults(query) {
            const url = `{{ route('assetsmanagement.searchAssets') }}?search=${encodeURIComponent(query)}`;

            // Fetch the search results using AJAX
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('tbody');
                    tableBody.innerHTML = ''; // Clear the existing table rows

                    // Populate table with new rows
                    data.forEach(asset => {
                        const row = `
                            <tr>
                                <td>${asset.id}</td>
                                <td>${asset.asset_type}</td>
                                <td>${asset.brand}</td>
                                <td>${asset.product_name}</td>
                                <td>
                                    <span class="status-badge ${asset.status.toLowerCase()}">
                                        ${formatStatus(asset.status)}
                                    </span>
                                </td>
                                <td>${asset.person_in_charge}</td>
                                <td class="td-actions text-right">
                                    <div class="dropdown">
                                        <button type="button" rel="tooltip" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
                                            class="btn btn-success btn-sm btn-icon">
                                            <i class="tim-icons icon-settings"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" 
                                            aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('assetsmanagement.getDetailById', ['id' => $asset->id]) }}">Detail</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                })
                .catch(error => console.error('Error fetching search results:', error));
        }

        // Helper function to format status
        function formatStatus(status) {
            switch (status.toLowerCase()) {
                case 'active': return 'Active';
                case 'inactive': return 'Inactive';
                case 'decommissioned': return 'Decommissioned';
                default: return 'Not Defined';
            }
        }
    </script>
@endsection