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
                            <p>These tickets are currently being addressed </br> by our support team and are
                                in progress.</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive"> <!-- Added table-responsive class -->
                                <table class="table w-100"> <!-- Added w-100 for full width -->
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
                                                <td>{{ $ticket->status }}</td>
                                                <td>
                                                    <button type="button" rel="tooltip"
                                                        class="btn btn-info btn-link btn-icon btn-sm">
                                                        <i class="tim-icons icon-single-02"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip"
                                                        class="btn btn-success btn-link btn-icon btn-sm">
                                                        <i class="tim-icons icon-settings"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip"
                                                        class="btn btn-danger btn-link btn-icon btn-sm">
                                                        <i class="tim-icons icon-simple-remove"></i>
                                                    </button>
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
@endsection
