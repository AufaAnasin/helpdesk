<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketImage;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each image
        ]);

        // Create a new ticket
        $ticket = Ticket::create([
            'user_id' => Auth::id(), // Get the currently logged-in user's ID
            'title' => $request->title,
            'message' => $request->message,
            'status' => 'open', // Default status
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store the image and get the path
                $path = $image->store('ticket_images', 'public'); // Store in public/ticket_images

                // Create a new TicketImage record
                TicketImage::create([
                    'ticket_id' => $ticket->id,
                    'image_path' => $path,
                ]);
            }
        }
        return redirect()->route('inputticket')->with('success', 'Ticket created successfully!');
    }

    public function index()
    {
        $tickets = Ticket::with('images')->get();
        return view('tickets', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::with('images')->findOrFail($id);
        return response()->json($ticket);
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('tickets.list')->with('success', 'Ticket deleted successfully!');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:open,in_progress,resolved,closed',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->status = $request->status;
        $ticket->save();

        return response()->json(['message' => 'Ticket status updated successfully.']);
    }
}
