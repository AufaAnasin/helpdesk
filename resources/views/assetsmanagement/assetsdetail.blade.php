@extends('layouts.app', ['pageSlug' => 'assets-list'])

@section('content')

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    </head>

    <body>
        <div class="container-fluid">
            <div class="breadcumb">
                <p><a href="{{ route('assetsmanagement.assetslist') }}">Asset List</a> <i class="tim-icons   icon-minimal-right"></i> Asset Detail </p> 
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
                    <div class="productSerialNumber">
                        <p>Person In Charge</p>
                        <h1 style="font-size: 24px;"><b>{{ $asset->person_in_charge }}</b></h1>
                    </div>
                    <div class="productSerialNumber">
                        @if ($asset->asset_type == 'Hardware')
                            <p>Hardware Location</p>
                            <h1 style="font-size: 24px;"><b>{{ $asset->hardware_location }}</b></h1>
                        @endif
                    </div>
                    <div class="productSerialNumber">
                        <p>Status</p>
                        <span class="status-badge">
                            @if ($asset->status == 'active')
                                Active
                            @elseif ($asset->status == 'inactive')
                                Inactive
                            @else
                                Decommisioned
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="timestampDetails">
                <div class="timestamp">
                    <p>Purchased on </p>
                    <p><b style="font-weight: 600;">{{ $asset->date_purchased }}</b></p>
                    <p>
                        @if ($asset->is_borrowable == 0)
                            Not Borrowable
                        @elseif ($asset->is_borrowable == 1)
                            Borrowable
                        @endif
                    </p>
                </div>
                <p>Rp. {{ $asset->price }}</p>
            </div>

            <div class="row additionalinfo">
                <div class="col-6">
                    <div class="form-floating">
                        <textarea class="form-control" style="padding: 0 10px;" placeholder="{{ $asset->notes }}" id="floatingTextarea2"
                            style="height: 100px" disabled></textarea>
                    </div>
                    <div class="additionalinfo-buttongroup">

                        <a href={{ route('assetsmanagement.assetsedit', ['id'=>$asset->id]) }}>
                            <button style="margin-top: 10px;" type="button" class="btn btn-success">Edit</button>
                        </a>



                        @if ($asset->is_borrowable == 1)
                            <button style="margin-top: 10px;" type="button" class="btn btn-success">Borrow</button>
                        @endif
                    </div>
                </div>
                <div class="col-6">
                    <p>Additional Files</p>
                    <div class="files-group">
                        @if ($asset->uploaded_files)
                            @foreach ($asset->uploaded_files as $additionalfiles)
                                <a href="{{ asset('storage/' . $additionalfiles) }}" target="_blank">
                                    <div class="files-button">
                                        <i class="tim-icons icon-attach-87"></i>
                                        <p>Additional Files</p>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            No Additional Files.
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </body>

    <style>
        .files-button p {
            font-size: 8px;
            color: black;
            margin-top: 10px;
        }

        .additionalinfo-buttongroup {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .additionalinfo {
            display: flex;
            flex-wrap: wrap;
            margin-top: 21px;
        }

        .col-6 {
            width: 50%;
            padding: 0 10px;
        }

        /* Additional custom styles */
        .files-group {
            display: flex;
            flex-wrap: wrap;
            /* Allow file buttons to wrap */
            gap: 10px;
            /* Add spacing between buttons */
        }

        .files-button {
            /* flex: 1 1 calc(50% - 10px); */
            /* Take up half of the row minus the gap */
            background-color: #f1f1f1;
            padding: 10px;
            border: 1px solid #ccc;

            box-sizing: border-box;
            width: 127px;
            height: 81px;
        }

        .timestamp {
            display: flex;
            gap: 4px;
        }

        .timestampDetails {
            background-color: #32325d;
            margin-top: 33px;
            display: flex;
            align-content: center;
            padding: 17px 12px;
            justify-content: space-between;
            border-radius: 8px;

        }

        .timestampDetails p {
            margin: 0;
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

            .additionalinfo-buttongroup {
                display: flex;
                flex-direction: column;
            }

            .col-6 {
                flex: 0 0 100%;
                /* Make columns full-width */
                max-width: 100%;
                /* Ensure the width doesn't exceed the container */
            }

            .files-button {
                flex: 1 1 100%;
                /* Buttons take full width on small screens */
            }


            .timestamp {
                display: flex;
                flex-direction: column;
            }

            .additionalinfo {
                display: flex;
                flex-direction: column;
            }
        }
    </style>
@endsection
