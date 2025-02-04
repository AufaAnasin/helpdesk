@extends('layouts.app', ['pageSlug' => 'assets-list'])

@section('content')

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>

<body>
    <div class="container-fluid">
        <div class="breadcumb">
            <p><a href="{{ route('assetsmanagement.assetslist') }}">Asset List</a> <i
                    class="tim-icons icon-minimal-right"></i> <a
                    href={{ route('assetsmanagement.getDetailById', ['id' => $asset->id]) }}>Asset Detail</a> <i
                    class="tim-icons icon-minimal-right"></i> Asset Edit</p>
        </div>
        <div class="row identity">
            <div class="col">
                <div class="productSerialNumber">
                    <p>Product/Serial Number</p>
                    <h1 style="font-size: 32px;"><b>{{ $asset->product_number }}</b></h1>
                </div>
            </div>
            <div class="col">
                <div class="productSerialNumber">
                    <p>Asset ID</p>
                    <h1 style="font-size: 32px;"><b>{{ $asset->id }}</b></h1>
                </div>
            </div>
        </div>
        <div class="row detail">
            <div class="col first-detail">
                <div class="productSerialNumber">
                    <p>Type</p>
                    <span class="status-badge">
                        {{ $asset->asset_type }}
                    </span>
                </div>
                <div class="productSerialNumber">
                    <p>Brand</p>
                    <h1 style="font-size: 24px;"><b>{{ $asset->brand }}</b></h1>
                </div>
                <div class="productSerialNumber">
                    <p>Product Name</p>
                    <h1 style="font-size: 24px;"><b>{{ $asset->product_name }}</b></h1>
                </div>
            </div>
            <div class="col first-detail">
                <div class="inputContainer">
                    <form action="{{ route('assetsmanagement.updateAssets', ['id' => $asset->id]) }}" method="POST">
                        @csrf
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="active" {{ $asset->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $asset->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="decommissioned" {{ $asset->status == 'decommissioned' ? 'selected' : '' }}>
                                Decommissioned</option>
                        </select>
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="personInCharge">Person In Charge</label>
                            <input type="text" class="form-control" id="personInCharge" name="person_in_charge"
                                placeholder="currently: {{ $asset->person_in_charge }}">
                        </div>
                        @if ($asset->asset_type == 'Hardware')
                            <div class="form-group">
                                <label for="hardwareLocation">Hardware Location</label>
                                <input type="text" class="form-control" id="hardwareLocation" name="hardware_location"
                                    placeholder="Enter Hardware Location">
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ $asset->notes }}</textarea>
                        </div>

                        <!-- ✅ Fix: Ensure "Is Borrowable" checkbox updates properly -->
                        <div class="form-check" id="isBorrowAbleCheckbox">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="is_borrowable" name="is_borrowable" value="1"
                                    {{ $asset->is_borrowable ? 'checked' : '' }}>
                                Is Borrowable?
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        
                        <!-- Hidden input (JavaScript will set value) -->
                        <input type="hidden" id="hidden_is_borrowable" name="is_borrowable_hidden" value="{{ $asset->is_borrowable }}">

                        <div class="button-group">
                            <a href={{ route('assetsmanagement.getDetailById', ['id' => $asset->id]) }}>
                                <button type="button" class="btn btn-danger">Cancel</button>
                            </a>
                            <button type="submit" class="btn btn-info" style="margin-left: 5px;">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row history">
            <div class="col">
                <h6><b>Edit History List</b></h6>
                <div class="card">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th>Person In Charge</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th class="text-right">Edited By</th>
                                <th class="text-center">Edited At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td class="text-center">{{ $log->id }}</td>
                                    <td>{{ $log->person_in_charge }}</td>
                                    <td>{{ $log->status }}</td>
                                    <td>{{ $log->notes }}</td>
                                    <td class="text-right">{{ $log->editor->name ?? 'Unknown' }}</td>
                                    <td class="text-right">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
<style>
    .button-group {
        display: flex;
        justify-content: flex-end;
    }

    .inputContainer {
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        color: rgb(68, 68, 68);
        font-weight: bold;
        background-color: rgb(195, 188, 188);
    }

    .breadcumb {
        margin-bottom: 34px;
    }

    .first-detail {
        display: flex;
        gap: 31px;
    }

    @media (max-width: 412px) {
        .col-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .timestamp {
            display: flex;
            flex-direction: column;
        }

        .additionalinfo {
            display: flex;
            flex-direction: column;
        }

        .productSerialNumber b {
            font-size: 18px;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let checkbox = document.getElementById("is_borrowable");
        let hiddenInput = document.getElementById("hidden_is_borrowable");

        checkbox.addEventListener("change", function () {
            if (checkbox.checked) {
                hiddenInput.value = 1;
            } else {
                hiddenInput.value = 0;
            }
        });
    });
</script>
@endsection