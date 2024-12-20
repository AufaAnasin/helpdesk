@extends('layouts.app', ['pageSlug' => 'tickets'])

@section('content')
    <div class="container-fluid">
        <div class="row" style="display: flex; flex-direction: row;">
            {{-- for ongoing tickets --}}
            <div class="col-12">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary tickets-header">
                            <h4 class="card-title"><b>Ongoing Tickets 🚠</b></h4>
                            <a href="{{ route('inputticket') }}">
                                <button type="button" class="btn btn-success addticketbutton">
                                    <i class="tim-icons icon-simple-add"></i>
                                    Add Ticket
                                </button>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Reported by</th>
                                            <th>Title</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tickets as $ticket)
                                            <tr>
                                                <td class="text-center">{{ $ticket->id }}</td>
                                                <td>{{ $ticket->user_name }}</td>
                                                <td>{{ $ticket->title }}</td>
                                                <td>{{ $ticket->message }}</td>
                                                <td>
                                                    <span class="status-badge {{ strtolower($ticket->status) }}">
                                                        @if ($ticket->status == 'open')
                                                            Open
                                                        @elseif ($ticket->status == 'in_progress')
                                                            In Process
                                                        @elseif ($ticket->status == 'resolved')
                                                            Resolved
                                                        @elseif ($ticket->status == 'closed')
                                                            Closed
                                                        @else
                                                            Unknown Status
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    {{-- Button for ticket details modal --}}
                                                    <button type="button" class="btn btn-info btn-link btn-icon btn-sm"
                                                        onclick="openTicketDetailModal({{ json_encode($ticket) }})">
                                                        <i class="tim-icons icon-single-02"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-success btn-link btn-icon btn-sm">
                                                        <i class="tim-icons icon-settings"></i>
                                                    </button>
                                                    <form action="{{ route('tickets.destroy', $ticket->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-link btn-icon btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this ticket?');">
                                                            <i class="tim-icons icon-simple-remove"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No ongoing tickets found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- for finished tickets --}}
        </div>
    </div>

    {{-- Include the Ticket Detail Modal Component --}}
    @if ($tickets->isNotEmpty())
        <x-ticket-detail-modal :ticket="$tickets[0]" /> <!-- Pass a default ticket for the component -->
    @else
        <x-ticket-detail-modal :ticket="null" /> <!-- Pass null or handle accordingly -->
    @endif

    <script>
        function openTicketDetailModal(ticket) {
            const modal = document.getElementById('ticketDetailModal');
            document.getElementById('modalTicketTitle').textContent = ticket.title;
            document.getElementById('modalTicketMessage').textContent = ticket.message;

            // Set the ticket ID and status
            const ticketId = ticket.id;
            const ticketStatus = ticket.status;

            // Update the dropdown button text
            const dropdownButton = document.getElementById('dropdownMenuButton');
            dropdownButton.textContent = ticketStatus.charAt(0).toUpperCase() + ticketStatus.slice(1);
            dropdownButton.setAttribute('data-ticket-id', ticketId);

            // Clear previous images
            const modalTicketImages = document.getElementById('modalTicketImages');
            modalTicketImages.innerHTML = '';

            // Populate images
            if (ticket.images && ticket.images.length > 0) {
                ticket.images.forEach(image => {
                    const imgDiv = document.createElement('div');
                    imgDiv.style.position = 'relative';
                    imgDiv.style.margin = '5px';

                    const img = document.createElement('img');
                    img.src = `/storage/${image.image_path}`; // Adjust the path as necessary
                    img.style.width = '100px';
                    img.style.height = 'auto';
                    img.style.cursor = 'pointer';
                    img.onclick = function() {
                        openImageInNewTab(img.src); // Open image in new tab on click
                    };

                    imgDiv.appendChild(img);
                    modalTicketImages.appendChild(imgDiv);
                });
            } else {
                modalTicketImages.innerHTML = '<p>No images uploaded.</p>';
            }

            // Show the modal
            modal.style.display = 'block';
            modal.classList.add('show');
        }

        function closeTicketDetailModal() {
            const modal = document.getElementById('ticketDetailModal');
            modal.classList.remove('show'); // Remove the show class
            setTimeout(() => {
                modal.style.display = 'none'; // Hide the modal after the transition
            }, 300); // Match the duration of the transition
        }
    </script>
    <style>
        .tickets-header {
            display: flex;
            justify-content: space-between;
        }

        .addticketbutton {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            /* Makes it oval */
            color: white;
            /* Text color */
            font-weight: bold;
            /* Optional: make text bold */
        }

        .status-badge.open {
            background-color: #28a745;
            /* Green for Open */
        }

        .status-badge.in_progress {
            background-color: #ffc107;
            /* Yellow for In Process */
        }

        .status-badge.resolved {
            background-color: #007bff;
            /* Blue for Resolved */
        }

        .status-badge.closed {
            background-color: #dc3545;
            /* Red for Closed */
        }

        .status-badge.unknown {
            background-color: #6c757d;
            /* Gray for Unknown Status */
        }
    </style>
@endsection
