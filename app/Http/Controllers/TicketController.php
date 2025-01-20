<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketImage;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\CommentImage;
use Flasher\Prime\FlasherInterface;

class TicketController extends Controller
{
    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'title' => 'required|string|max:255',
                'message' => 'required|string',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20480', // Validate each image
            ]);
    
            // Create a new ticket
            $ticket = Ticket::create([
                'user_id' => Auth::id(), // Get the currently logged-in user's ID
                'user_name' => Auth::user()->name,
                'title' => $request->title,
                'message' => $request->message,
                'status' => 'open', // Default status
                'priority' => $request->priority,
            ]);
    
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
    
            // Display success message
            flash()->options(['timeout' => 3000, 'position' => 'bottom-center'])->success('Your Ticket has been submitted.');
            return redirect()->route('inputticket');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            foreach ($e->validator->errors()->all() as $error) {
                flash()->options(['timeout' => 3000, 'position' => 'bottom-center'])->error($error);
            }
            return redirect()->route('inputticket')
                ->withErrors($e->validator)
                ->withInput(); // Redirect back with input data
        } catch (\Exception $e) {
            // Handle other exceptions
            flash()->options(['timeout' => 3000, 'position' => 'bottom-center'])->error('An error occurred: ' . $e->getMessage());
            return redirect()->route('inputticket');
        }
    }
    
    

    public function index()
    {
        $tickets = Ticket::with('images')->get();
        return view('tickets', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::with(['images', 'comments'])->findOrFail($id);
        return view('tickets.detail', compact('ticket'));
    }

    public function destroy($id)
    {
        // Find the ticket by ID or fail
        $ticket = Ticket::with('images')->findOrFail($id); // Eager load images
    
        // Delete associated images
        foreach ($ticket->images as $image) {
            // Construct the full path to the image
            $imagePath = public_path('storage/' . $image->image_path);
            
            // Check if the file exists and delete it
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the file
            }
        }
    
        // Delete the ticket
        $ticket->delete();
    
        // Flash message for successful deletion
        flash()->options(['timeout' => 3000, 'position' => 'bottom-center'])->info('Ticket has been deleted.');
        
        // Redirect to the tickets list
        return redirect()->route('tickets.list');
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

    public function userTickets()
    {
        // Get the currently logged-in user's ID
        $userId = Auth::id();
        // Retrieve tickets created by the logged-in user
        $tickets = Ticket::where('user_id', $userId)->with('images')->get();
        // Return the view with the tickets
        return view('usertickets', compact('tickets'));
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
        flash()->options(['timeout' => 3000, 'position' => 'bottom-center'])->info('Comment added.');
        return redirect()->route('tickets.list');
    }
}