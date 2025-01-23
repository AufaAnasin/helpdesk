@extends('layouts.app', ['pageSlug' => 'register-assets'])

@section('content')

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    </head>

    <body>
        <div class="container-fluid">
            <div class="breadcumb">
                <p>Assets List <i class="tim-icons   icon-minimal-right"></i> Asset Detail </p>
            </div>
            <div class="row identity">
                <div class="col">
                    <div class="productSerialNumber">
                        <p>Product/Serial Number</p>
                        <h1 style="font-size: 32px;"><b>20230715-001-123</b></h1>
                    </div>
                </div>
                <div class="col">
                    <div class="productSerialNumber">
                        <p>Asset ID</p>
                        <h1 style="font-size: 32px;"><b>IT/H/7210</b></h1>
                    </div>
                </div>
            </div>
            <div class="row detail">
                <div class="col first-detail">
                    <div class="productSerialNumber">
                        <p>Type</p>
                        <span class="status-badge">
                            Software
                        </span>
                    </div>
                    <div class="productSerialNumber">
                        <p>Brand</p>
                        <h1 style="font-size: 24px;"><b>Lenovo</b></h1>
                    </div>
                    <div class="productSerialNumber">
                        <p>Product Name</p>
                        <h1 style="font-size: 24px;"><b>Thinkpad X1 Carbon</b></h1>
                    </div>
                </div>
                <div class="col first-detail">
                    <div class="productSerialNumber">
                        <p>Person In Charge</p>
                        <h1 style="font-size: 24px;"><b>Mathew Jackson</b></h1>
                    </div>
                    <div class="productSerialNumber">
                        <p>Hardware Location</p>
                        <h1 style="font-size: 24px;"><b>Document Control Room</b></h1>
                    </div>
                    <div class="productSerialNumber">
                        <p>Status</p>
                        <span class="status-badge">
                            Active
                        </span>
                    </div>
                </div>
            </div>
            <div class="timestampDetails">
                <div class="timestamp">
                    <p>Purchased on </p>
                    <p style="color: black;">DD/MM/YYYY</p>
                    <p>Borrowable</p>
                </div>
                <p>Rp. 432.000</p>
            </div>

            <div class="row additionalinfo">
                <div class="col-6">
                    <div class="form-floating">
                        <textarea class="form-control" style="padding: 0 10px;" placeholder="Leave a comment here" id="floatingTextarea2"
                            style="height: 100px" disabled></textarea>
                    </div>
                    <div class="additionalinfo-buttongroup">
                        <button style="margin-top: 10px;" type="button" class="btn btn-success">Edit</button>
                        <button style="margin-top: 10px;" type="button" class="btn btn-success">Borrow</button>
                    </div>
                </div>
                <div class="col-6">
                    <p>Additional Files</p>
                    <div class="files-group">
                        <div class="files-button">
                            <i class="tim-icons icon-attach-87"></i>
                            <p>filenameswithlonger.pdf</p>
                        </div>
                        <div class="files-button">
                            <i class="tim-icons icon-attach-87"></i>
                            <p>filenameswithlonger.pdf</p>
                        </div>
                        <div class="files-button">
                            <i class="tim-icons icon-attach-87"></i>
                            <p>filenameswithlonger.pdf</p>
                        </div>
                        <div class="files-button">
                            <i class="tim-icons icon-attach-87"></i>
                            <p>filenameswithlonger.pdf</p>
                        </div>
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
            background-color: rgb(195, 188, 188);
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
