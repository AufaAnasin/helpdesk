<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketImage;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\CommentImage;

class TicketController extends Controller
{
    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each image
        ]);
        // Create a new ticket
        $ticket = Ticket::create([
            'user_id' => Auth::id(), // Get the currently logged-in user's ID
            'user_name' => Auth::user()->name,
            'title' => $request->title,
            'message' => $request->message,
            'status' => 'open', // Default status
        ]);

        // dd($ticket);

        // Handle image uploads
        if (!empty($request->images)) {
            foreach ($request->images as $image) {
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

    public function addComment(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'comment' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow multiple images
        ]);

        $ticket = Ticket::findOrFail($id);
        $comment = new Comment();
        $comment->ticket_id = $ticket->id;
        $comment->user_id = Auth::id();
        $comment->user_name = Auth::user()->name; // Get the user's name
        $comment->comment = $request->comment;
        $comment->save(); // Save the comment first

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('comment_images', 'public'); // Store in public/comment_images

                // Create a new CommentImage record
                CommentImage::create([
                    'comment_id' => $comment->id,
                    'image_path' => $path,
                ]);
            }
        }
        return response()->json(['success' => true, 'comment' => $comment->comment, 'user_name' => $comment->user_name]);
    }
}
