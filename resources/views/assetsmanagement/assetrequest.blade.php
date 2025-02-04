@extends('layouts.app', ['pageSlug' => 'request-assets'])

@section('content')

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    </head>

    <body>
        <div class="card">
            <div class="card-body">
                <form>
                    @csrf
                    <h4>Request Assets</h4>
                    {{-- Asset Type      --}}
                    <div class="contentWrapper">
                        <div class="inputWrapper">
                            <div class="textContainer">
                                <h5><b>Asset Type</b></h5>
                                <p>Do deserunt do consectetur cupidatat anim commodo ea qui ani</p>
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
                    {{-- Asset Details      --}}
                    <div class="contentWrapper">
                        <div class="inputWrapper">
                            <div class="textContainer">
                                <h5><b>Asset Details</b></h5>
                                <p>Veniam magna id ut pariatur cillum veniam occaecat eu Conse.</p>
                            </div>
                            <div class="inputContainer">
                                <div class="form-group" >
                                    <label for="inputState">Brand</label>
                                    <select id="inputState" class="form-control" name="brand">
                                        <option selected>Microsoft</option>
                                        <option value="Zoom">Zoom</option>
                                        <option value="Foxit">Foxit</option>
                                        <option value="Autodesk">Autodesk</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Name</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="product_name" placeholder="Product Name..." required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Amount</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="Product Number..." required>
                                </div>
                                <div class="form-group">
                                    <label for="notes">Additional Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                </div>
                                <button type="button" style="width: 100%;" class="btn btn-success">Add Another Request</button>
                            </div>
                        </div>
                        {{-- <div class="borderLine"></div> --}}
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script>
        const toggleCheckbox = document.getElementById('toggle');
        const selectedValueInput = document.getElementById('selectedValue');
        const hardwareLocationField = document.getElementById('hardwareLocationField');

        // Initialize the hidden input with the default value
        selectedValueInput.value = 'Software';

        // Add event listener to the toggle button
        toggleCheckbox.addEventListener('change', () => {
            if (toggleCheckbox.checked) {
                selectedValueInput.value = 'Hardware';
                hardwareLocationField.style.display = 'block'; // Show Hardware Location field
                // isBorrowAbleCheckbox.style.display = 'block'; 
            } else {
                selectedValueInput.value = 'Software';
                hardwareLocationField.style.display = 'none'; // Hide Hardware Location field
                // isBorrowAbleCheckbox.style.display = 'none'; 
            }
        });


        // file upload 

        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');
        const maxFiles = 4;
        const maxSize = 5 * 1024 * 1024; // 5MB  

        function handleFiles(files) {
            if (fileList.children.length + files.length > maxFiles) {
                alert(`You can only upload a maximum of ${maxFiles} files.`);
                return;
            }

            for (let file of files) {
                if (file.size > maxSize) {
                    alert(`File ${file.name} exceeds the maximum size of 5MB.`);
                    continue;
                }
                addFileToList(file);
            }
        }

        function handleFileDrop(event) {
            event.preventDefault();
            const files = event.dataTransfer.files;
            handleFiles(files);
        }

        function addFileToList(file) {
            const listItem = document.createElement('li');
            listItem.textContent = file.name;
            fileList.appendChild(listItem);
        }

        // Optional: Clear file list on form reset  
        document.querySelector('form').addEventListener('reset', () => {
            fileList.innerHTML = '';
        });
    </script>
@endsection

<style>
    .form-group input {
        /* width: 10vw; */
    }

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
        margin-top: 5px;
    }

    .contentWrapper .textContainer h5 {
        margin-bottom: 0;
    }

    .contentWrapper .textContainer p {
        max-width: 332px;
    }

    .contentWrapper .inputContainer p {
        margin-bottom: 0;
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

    /* input file */
    .file-upload-area {
        border: 2px dashed #6c757d;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        margin-top: 10px;
    }

    .file-upload-area p {
        margin: 0;
        color: #343434;
    }

    .file-upload-area button {
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #343434;
        color: white;
        border: none;
        cursor: pointer;
    }

    .file-upload-area button:hover {
        background-color: #555;
    }

    #fileList {
        margin-top: 10px;
        list-style-type: none;
        padding: 0;
    }

    #fileList li {
        background: #f1f1f1;
        margin: 5px 0;
        padding: 10px;
        border-radius: 4px;
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
            width: 1000px;
            font-size: 12px;
        }
    }
</style>
