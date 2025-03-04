@extends('layouts.app', ['pageSlug' => 'tickets'])
@section('content')

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    </head>

    <body>
        <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    <div class="ticketTitleHead">
                        <div class="ticketTitleContainer">
                            <h4 id="modalTicketId" style="color: white;"><b>[Ticket #{{ $ticket->id }}]</b></h4>

                            <h4 id="modalTicketTitle"> {{ $ticket->title }}</h4>
                        </div>
                        <div class="buttontitlegroup">
                            <div>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-ticket-id="{{ $ticket->id }}" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        @if ($ticket->status == 'open')
                                            Open
                                        @elseif ($ticket->status == 'in_progress')
                                            In Progress
                                        @elseif ($ticket->status == 'resolved')
                                            Resolved
                                        @elseif ($ticket->status == 'closed')
                                            Closed
                                        @endif
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); changeTicketStatus('open')">Open</a>
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); changeTicketStatus('in_progress')">In
                                            Progress</a>
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); changeTicketStatus('resolved')">Resolved</a>
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); changeTicketStatus('closed')">Closed</a>
                                    </div>
                                    <span class="priority-badge {{ strtolower($ticket->priority) }}">
                                        @if ($ticket->priority == 'low')
                                            Low
                                        @elseif ($ticket->priority == 'medium')
                                            Medium
                                        @elseif ($ticket->priority == 'high')
                                            High
                                        @elseif ($ticket->priority == 'verry_high')
                                            Very High
                                        @else
                                            Unknown Priority
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6>Details</h6>
                    <p id="modalTicketMessage" style="color: white;">{{ $ticket->message }}</p>
                    <div id="modalTicketImages" class="d-flex flex-wrap">
                        @foreach ($ticket->images as $image)
                            <div style="position: relative; margin: 5px;">
                                <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        style="width: 100px; height: 100px; margin: 5px; cursor: pointer;">
                                </a>
                            </div>
                        @endforeach
                        @if ($ticket->images->isEmpty())
                            <p>No images uploaded.</p>
                        @endif
                    </div>
                    <div class="border-line"></div>
                    <h5><b>Comments</b></h5>
                    <div class="commentWrapper">
                        <form action="{{ route('tickets.addComment', $ticket->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="commentUserDetails">
                                <img class="avatar" src="{{ asset('black') }}/img/default-avatar.png" alt="">
                                <p><b>{{ auth()->user()->name }}</b></p>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="message" name="comment" placeholder="Enter your message here" required></textarea>
                            </div>
                            <div class="commentButtonGroup">
                                <div class="form-group" style="margin-top: 5px;">
                                    <input style="border: 1px solid red;" type="file" id="imageUpload" name="images[]"
                                        accept="image/*" multiple onchange="previewImages()"><i
                                        class="tim-icons icon-image-02"></i></input>
                                </div>
                                <div class="sendimagebutton">
                                    <div class="buttonwrapper">
                                        <div class="buttonGroup">
                                            <button type="submit" class="btn btn-success btn-sm btn-round btn-icon">
                                                <i class="tim-icons icon-send"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="imagePreview" class="d-flex flex-wrap"></div>
                        </form>
                    </div>
                    <div>
                        {{-- {{ dd($ticket->comments) }} <!-- This will dump the comments and stop execution --> --}}
                        @if ($ticket->comments->isEmpty())
                            <div class="noComments" style="margin-top: 10px; text-align: center;">
                                <p style="color: white;">No comments yet</p>
                            </div>
                        @else
                            @foreach ($ticket->comments as $comment)
                                <div class="commentWrapper"
                                    style="border: 1px solid #32325d; margin: 10px 0; display: flex; justify-content: space-between;">
                                    <div class="commentUserWrapper">
                                        <div class="commentUserDetails">
                                            <img class="avatar" src="{{ asset('black') }}/img/default-avatar.png"
                                                alt="">
                                            <p><b>{{ $comment->user_name }}</b></p>
                                            <p style="color: #5e72e4; ">{{ $comment->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <p style="margin:0 35px; color: white;">
                                            {{ $comment->comment }}</p>
                                    </div>
                                    <div class="commentImageWrapper">
                                        @foreach ($comment->images as $commentimages)
                                            <a href="{{ asset('storage/' . $commentimages->image_path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $commentimages->image_path) }}"
                                                    alt=""
                                                    style="height: 60px; width: 60px; margin: 5px; cursor; pointer;">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </body>


    <style>
        .dropdown {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .priority-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            /* Oval shape */
            color: white;
            font-weight: bold;
            text-align: center;
            /* Bold text */
        }

        .priority-badge.low {
            background-color: #28a745;
            /* Green for Low */
        }

        .priority-badge.medium {
            background-color: #ffc107;
            /* Yellow for Medium */
            color: #212529;
            /* Dark text for contrast */
        }

        .priority-badge.high {
            background-color: #fd7e14;
            /* Orange for High */
        }

        .priority-badge.verry_high {
            background-color: #dc3545;
            /* Red for Very High */
        }

        .priority-badge.unknown {
            background-color: #6c757d;
            /* Gray for Unknown */
        }

        .commentButtonGroup {
            display: flex;
            justify-content: space-between;
            margin: 0 10px;
            /* border: 1px solid red; */
        }

        .listOfComments p {
            color: white;

        }

        #imagePreview {
            display: flex;
            flex-wrap: wrap;
        }

        #imagePreview div {
            position: relative;
            margin: 5px;
        }

        .buttonwrapper {
            display: flex;
            align-items: center;
            /* Align items vertically */
        }

        .buttonGroup {
            margin-left: 5px;
            /* Add space between the upload button and the submit button */
        }

        .buttonGroup button {
            margin-bottom: 12px;
        }

        #imageUpload {
            margin-right: 10px;
            /* Add space between the upload button and the icon */
        }

        .commentUserDetails p b {
            color: white;
        }

        .commentWrapper {
            border: 1px solid #5e72e4;
            padding: 10px;
            border-radius: 18px;
        }

        .commentUserDetails {
            display: flex;
            gap: 5px;
        }

        .ticketNumberWrapper {
            color: white;
            border: 1px solid #5e72e4;
            padding: 0;
        }

        .ticketTitle {
            display: flex;
            gap: 5px;
        }

        .ticketTitleHead {
            display: flex;
            justify-content: space-between;
        }

        .borderline {
            height: 5px;
            width: 100%;
            max-height: 5px;
            background-color: #aaa;
        }

        .buttontitlegroup {
            display: flex;
            justify-content: space-between;
        }

        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.8);
            /* Dark background with opacity */
            opacity: 0;
            /* Start hidden */
            transition: opacity 0.3s ease;
            /* Transition for fade effect */
        }

        .modal.show {
            display: block;
            /* Show modal */
            opacity: 1;
            /* Fully visible */
        }

        .modal-content {
            background-color: transparent;
            /* Transparent */
            margin: 80px auto;
            /* Center the modal */
            padding: 20px;
            border: none;
            /* Remove border */
            width: 100%;
            /* Adjust width as needed */
            max-width: 1000px;
            /* Max width for larger screens */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Optional shadow */
            border-radius: 8px;
            /* Rounded corners */
            overflow-x: hidden;
            transform: translateY(-30px);
            /* Start slightly above */
            transition: transform 0.3s ease;
            /* Transition for slide effect */
        }

        .modal.show .modal-content {
            transform: translateY(0);
            /* Slide down to original position */
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            background: none;
            border: none;
        }

        .close:hover,
        .close:focus {
            color: white;
            text-decoration: none;
        }
    </style>

    <script>
        function closeTicketDetailModal() {
            const modal = document.getElementById('ticketDetailModal');
            modal.classList.remove('show'); // Remove the show class
            setTimeout(() => {
                modal.style.display = 'none'; // Hide the modal after the transition
            }, 300); // Match the duration of the transition
        }

        function openImageInNewTab(src) {
            window.open(src, '_blank'); // Open the image in a new tab
        }

        function changeTicketStatus(status) {
            const dropdownButton = document.getElementById('dropdownMenuButton');
            const ticketId = dropdownButton.getAttribute('data-ticket-id'); // Get the ticket ID

            // Send an AJAX request to update the ticket status
            fetch(`/tickets/${ticketId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status
                    })
                })
                .then(response => {
                    if (response.ok) {
                        // Update the UI to reflect the new status
                        let formattedStatus = status.replace('_', ' ').replace(/\b\w/g, (l) => l.toUpperCase());
                        dropdownButton.textContent = formattedStatus;
                        console.log("Ticket status changed to:", formattedStatus);
                    } else {
                        console.error("Failed to update ticket status");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        }

        function previewImages() {
            const previewContainer = document.getElementById('imagePreview');
            const files = document.getElementById('imageUpload').files;

            // Clear previous previews
            previewContainer.innerHTML = '';

            // Limit to 7 images
            const maxImages = 7;
            const totalImages = files.length > maxImages ? maxImages : files.length;

            for (let i = 0; i < totalImages; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imageDiv = document.createElement('div');
                    imageDiv.style.position = 'relative';
                    imageDiv.style.margin = '5px';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';

                    const deleteButton = document.createElement('button');
                    deleteButton.innerHTML = '&times;';
                    deleteButton.style.position = 'absolute';
                    deleteButton.style.top = '0';
                    deleteButton.style.right = '0';
                    deleteButton.style.background = 'red'; // Set background color to red
                    deleteButton.style.border = 'none';
                    deleteButton.style.color = 'white'; // Change text color to white for contrast
                    deleteButton.style.cursor = 'pointer';
                    deleteButton.style.borderRadius = '50%'; // Make it rounded
                    deleteButton.style.width = '20px'; // Set width
                    deleteButton.style.height = '20px'; // Set height
                    deleteButton.style.display = 'flex'; // Center the icon
                    deleteButton.style.alignItems = 'center'; // Center vertically
                    deleteButton.style.justifyContent = 'center'; // Center horizontally

                    deleteButton.onclick = function() {
                        // Remove the image from the preview
                        imageDiv.remove();
                        // Remove the file from the input
                        const dataTransfer = new DataTransfer();
                        for (let j = 0; j < files.length; j++) {
                            if (j !== i) {
                                dataTransfer.items.add(files[j]);
                            }
                        }
                        document.getElementById('imageUpload').files = dataTransfer.files;
                    };

                    imageDiv.appendChild(img);
                    imageDiv.appendChild(deleteButton);
                    previewContainer.appendChild(imageDiv);
                };

                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
