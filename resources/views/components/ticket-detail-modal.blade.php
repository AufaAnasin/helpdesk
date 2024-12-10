<!-- Ticket Detail Modal -->
<div id="ticketDetailModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" onclick="closeTicketDetailModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    <h6>Title:</h6>
                    <p id="modalTicketTitle" style="color: white;">{{ $ticket->title }}</p>
                    <h6>Message:</h6>
                    <p id="modalTicketMessage" style="color: white;">{{ $ticket->message }}</p>
                    <h6>Images:</h6>
                    <div id="modalTicketImages" class="d-flex flex-wrap">
                        @foreach ($ticket->images as $image)
                            <div style="position: relative; margin: 5px;">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                    style="width: 100px; height: auto; margin: 5px;">
                                <button onclick="openImageInNewTab('{{ asset('storage/' . $image->image_path) }}')"
                                    style="margin-top: 5px; background-color: rgba(0, 0, 0, 0.7); color: white; border: none; padding: 5px; border-radius: 5px;">
                                    View Full Screen
                                </button>
                            </div>
                        @endforeach
                        @if ($ticket->images->isEmpty())
                            <p>No images uploaded.</p>
                        @endif
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- This will be set dynamically in the JavaScript -->
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" onclick="changeTicketStatus('open')">Open</a>
                            <a class="dropdown-item" onclick="changeTicketStatus('in_progress')">In Progress</a>
                            <a class="dropdown-item" onclick="changeTicketStatus('resolved')">Resolved</a>
                            <a class="dropdown-item" onclick="changeTicketStatus('closed')">Closed</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
        margin: 100px auto;
        /* Center the modal */
        padding: 20px;
        border: none;
        /* Remove border */
        width: 50%;
        /* Adjust width as needed */
        max-width: 500px;
        /* Max width for larger screens */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Optional shadow */
        border-radius: 8px;
        /* Rounded corners */
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
        const ticketId = dropdownButton.getAttribute('data-ticket-id'); // Get the ticket ID from the button

        // Send an AJAX request to update the ticket status
        fetch(`/tickets/${ticketId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: status
                })
            })
            .then(response => {
                if (response.ok) {
                    // Update the UI to reflect the new status
                    dropdownButton.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    console.log("Ticket status changed to:", status);
                } else {
                    console.error("Failed to update ticket status");
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    }
</script>
