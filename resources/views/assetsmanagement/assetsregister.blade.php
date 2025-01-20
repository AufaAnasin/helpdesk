@extends('layouts.app', ['pageSlug' => 'register-assets'])

@section('content')

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    </head>

    <body>
        <div class="card">
            <div class="card-body">
                <h4>Register Assets</h4>
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
                            <input type="hidden" id="selectedValue" name="selectedValue" value="Software">
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
                            <div class="form-group">
                                <label for="inputState">Brand</label>
                                <select id="inputState" class="form-control">
                                    <option selected>Microsoft</option>
                                    <option>Zoom</option>
                                    <option>Foxit</option>
                                    <option>Autodesk</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product Name</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Product Name..." required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product Number</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Product Number..." required>
                            </div>
                        </div>
                    </div>
                    <div class="borderLine"></div>
                </div>
                {{-- Asset Timestamp --}}
                <div class="contentWrapper">
                    <div class="inputWrapper">
                        <div class="textContainer">
                            <h5><b>Assets Timestamp</b></h5>
                            <p>Veniam magna id ut pariatur cillum veniam occaecat eu Conse.</p>
                        </div>
                        <div class="inputContainer">
                            <label for="exampleInputEmail1">Dates Purchased</label>
                            <div class="input-group">

                                <div class="input-group-prepend">

                                    <div class="input-group-text">
                                        <i class="tim-icons icon-calendar-60"></i>
                                    </div>
                                </div>
                                <input type="date" class="form-control" placeholder="With Nucleo Icons">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Price</label>
                                <input type="number" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Price.." required>
                            </div>
                        </div>
                    </div>
                    <div class="borderLine"></div>
                </div>
                {{-- Additional Information --}}
                <div class="contentWrapper">
                    <div class="inputWrapper">
                        <div class="textContainer">
                            <h5><b>Additional Information</b></h5>
                            <p>Veniam magna id ut pariatur cillum veniam occaecat eu Conse.</p>
                        </div>
                        <div class="inputContainer">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Notes</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Person In Charge</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Person In Charge" required>
                            </div>
                            <div class="form-group" id="hardwareLocationField" style="display: none;">
                                <label for="hardwareLocation">Hardware Location</label>
                                <input type="text" class="form-control" id="hardwareLocation"
                                    placeholder="Enter Hardware Location">
                            </div>
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="fileUpload">Additional Files (Max 4 files, 5MB each)</label>
                                    <div id="fileUpload" class="file-upload-area" ondragover="event.preventDefault();"
                                        ondrop="handleFileDrop(event)">
                                        <p>Drag & drop files here or click to upload</p>
                                        <input type="file" id="fileInput" multiple accept=".jpg,.png,.pdf"
                                            style="display: none;" onchange="handleFiles(this.files)">
                                        <button type="button"
                                            onclick="document.getElementById('fileInput').click();">Choose Files</button>
                                    </div>
                                    <ul id="fileList"></ul>
                                </div>
                                {{-- please put File Upload Placeholder that can be drag and drop, with maximum 4 files and 5MB and also can see the list of file that already uploaded --}}
                            </div>
                            <div class="form-check" id="isBorrowAbleCheckbox" style="display: none;">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Is Borrowable?
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div style="display: flex; justify-content: flex-end;">
                                <button type="button" class="btn btn-info">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                isBorrowAbleCheckbox.style.display = 'block'; // Show Borrowable checkbox
            } else {
                selectedValueInput.value = 'Software';
                hardwareLocationField.style.display = 'none'; // Hide Hardware Location field
                isBorrowAbleCheckbox.style.display = 'none'; // Hide Borrowable checkbox
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
