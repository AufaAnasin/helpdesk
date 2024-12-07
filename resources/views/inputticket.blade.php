@extends('layouts.app', ['pageSlug' => 'inputticket'])

@section('content')
<div class="container">
        <div class="row">
            <div class="col">
                <p>Input Ticket</p>
                <div class="card">
                    <div class="card-body">1
                        <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" name="message" placeholder="Enter your message here" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="imageUpload">Upload Images (Max 7)</label>
                                <div id="drop-area" class="drop-area">
                                    <p>Drag & drop your images here or click to select</p>
                                    <input type="file" id="imageUpload" name="images[]" multiple accept="image/*" required style="display: none;">
                                </div>
                                <small class="form-text text-muted">You can upload up to 7 images.</small>
                            </div>

                            <div id="image-preview" class="image-preview"></div>
                            
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .drop-area {
            border: 2px dashed #2b3553;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            margin-top: 10px;
        }
        .drop-area.hover {
            border-color: #0056b3;
        }
        .image-preview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .image-preview div {
            position: relative; /* Position relative for absolute positioning of delete button */
            margin: 5px;
        }
        .image-preview img {
            width: 100px; /* Set the width of the preview images */
            height: auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .delete-btn {
            position: absolute; /* Position absolute to place it in the corner */
            top: 0;
            right: 0;
            background: red;
            color: white;
            border: none;
            border-radius: 50%; /* Make the button circular */
            cursor: pointer;
            width: 25px; /* Set width */
            height: 25px; /* Set height */
            padding: 0; /* Remove padding */
            font-size: 14px; /* Adjust font size */
            display: flex; /* Center the text */
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
        }
    </style>

    <script>
        const dropArea = document.getElementById('drop-area');
        const imageUpload = document.getElementById('imageUpload');
        const imagePreview = document.getElementById('image-preview');
        let selectedFiles = []; // Array to hold selected files

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        // Remove highlight when item is no longer hovering
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false);
        dropArea.addEventListener('click', () => imageUpload.click());

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight() {
            dropArea.classList.add('hover');
        }

        function unhighlight() {
            dropArea.classList.remove('hover');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            addFiles(files);
        }

        imageUpload.addEventListener('change', (e) => {
            const files = e.target.files;
            addFiles(files);
        });

        function addFiles(files) {
            if (selectedFiles.length + files.length > 7) {
                alert('You can only upload a maximum of 7 images.');
                return;
            }
            Array.from(files).forEach(file => {
                selectedFiles.push(file);
                displayImage(file);
            });
        }

        function displayImage(file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const imgContainer = document.createElement('div');
                const img = document.createElement('img');
                img.src = event.target.result;
                imgContainer.appendChild(img);

                // Create delete button
                const deleteBtn = document.createElement('button');
                deleteBtn.innerText = 'X';
                deleteBtn.className = 'delete-btn';
                deleteBtn.onclick = function() {
                    imgContainer.remove();
                    selectedFiles = selectedFiles.filter(f => f !== file); // Remove file from array
                };

                imgContainer.appendChild(deleteBtn);
                imagePreview.appendChild(imgContainer);
            }
            reader.readAsDataURL(file);
        }
    </script>
@endsection
