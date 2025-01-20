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
                                            <th>Priority</th>
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
                                                </td>
                                                <td>
                                                    {{-- Button for ticket details modal --}}
                                                    {{-- ticket detail button --}}
                                                    <button type="button" class="btn btn-info btn-link btn-icon btn-sm"
                                                        onclick="goToTicketDetail({{ $ticket->id }})">
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
        function goToTicketDetail(ticketId) {
            // Redirect to the ticket detail page
            window.location.href = '{{ url('/tickets') }}/' + ticketId;
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
        .priority-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            /* Oval shape */
            color: white;
            font-weight: bold;
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
