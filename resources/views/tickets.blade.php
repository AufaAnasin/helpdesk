@extends('layouts.app', ['pageSlug' => 'tickets'])

@section('content')
    <div class="container-fluid">
        <div class="row" style="display: flex; flex-direction: row;">
            {{-- for ongoing tickets --}}
            <div class="col-12">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Ongoing Tickets 🚠</h4>
                            <p>These tickets are currently being addressed by our support team and are in progress.</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>User ID</th>
                                            <th>Title</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tickets as $ticket)
                                            <tr>
                                                <td class="text-center">{{ $ticket->id }}</td>
                                                <td>{{ $ticket->user_id }}</td>
                                                <td>{{ $ticket->title }}</td>
                                                <td>{{ $ticket->message }}</td>
                                                <td>
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
                                        @endforeach
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
    <x-ticket-detail-modal :ticket="$tickets[0]" /> <!-- Pass a default ticket for the component -->

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

            // Store the ticket ID in a data attribute for later use
            dropdownButton.setAttribute('data-ticket-id', ticketId);

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
@endsection
