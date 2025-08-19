<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Logs;
use App\Models\Note_Share;
use App\Models\Notes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log as SystemLog;
use Illuminate\Support\Str; 


class NoteController extends Controller
{

    // View Notes Dashboard
    public function notesView()
    {
        $userId = Auth::id();

            $privateNotes = Notes::where('user_id', $userId)
                ->where('note_public', 'N')
                ->whereDoesntHave('shares') 
                ->latest()
                // ->take(3)
                ->get();

            $mySharedNotes = Notes::where('user_id', $userId)
                ->whereHas('shares')
                ->with(['shares.sharedWith'])
                ->latest()
                ->get();

            $receivedNotes = Note_Share::where('shared_with_user_id', $userId)
                ->with(['note.user'])
                ->latest()
                ->get();

            $myPublicNotes = Notes::where('user_id', $userId)
                ->where('note_public', 'Y')
                ->latest()
                ->get();

            $allPublicNotes = Notes::where('note_public', 'Y')
                ->where('user_id', '!=', $userId)
                ->latest()
                ->get();

            return view('notes.notes', compact(
                'privateNotes',
                'mySharedNotes',
                'receivedNotes',
                'myPublicNotes',
                'allPublicNotes'
        ));
    }

    // Get All User Id & Fullname Kecuali user yang Login
    public function getAllUser(Request $request){
        $currentUserId = $request->user()->user_id;
       
        $search = $request->get('search', '');
        
        $users = User::where('user_id', '!=', $currentUserId) 
                     ->where('username', 'like', "%{$search}%")
                     ->limit(20)
                     ->get(['user_id', 'username']);

        // format untuk Select2
        $results = $users->map(function($user) {
            return ['id' => $user->user_id, 'text' => $user->username];
        });

        return response()->json(['results' => $results]);
    }   

    // Validasi + Save Note's
    public function saveNote(Request $request){
        
        $validateNotes = $request->validate([
            'note_title'   => 'required|string|max:35',
            'note_content' => 'required|string|max:255',
            'note_public'  => 'required|in:private,shared,public',
            'shared_with_users' => 'required_if:note_public,shared|array',
            'shared_with_users.*' => 'exists:users,user_id',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx|max:5120',

        ]);

        // Log Info Hasil Validasi
        Log::info('Validasi Note', $validateNotes);
         // Debug log Laravel
        SystemLog::info('Validasi Note', $validateNotes);

    
        // Simpan Notes
        $note = Notes::create([
            'user_id' => Auth::id(),
            'dept_id' => Auth::user()->dept_id,
            'note_title' => $request->note_title,
            'note_content' => $request->note_content,
            'note_public' => $request->note_public === 'public' ? 'Y' : 'N',
        ]);

        // Cek Apkah Note Visibilitynya === Shared, jika shared maka
        if ($request->note_public === 'shared' && $request->has('shared_with_users')) {
            foreach ($request->shared_with_users as $userId) {
                Note_Share::create([
                    'notes_id' => $note->notes_id,
                    'shared_with_user_id' => $userId,
                    'note_public'=> $request->note_public === 'public' ? 'Y' : 'N',
                ]);
            }
        }

        if ($request->hasFile('attachments')) {

            // Buat folder per note
            $directory = "notes/{$note->notes_id}";
            Storage::disk('public')->makeDirectory($directory, 0755, true);

            foreach ($request->file('attachments') as $file) {

                // Generate nama unik
                $fileName = 'note_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Simpan file ke storage/app/public/notes/{note_id}
                $file->storeAs($directory, $fileName, 'public');

                // Simpan data ke DB
                Attachment::create([
                    'notes_id' => $note->notes_id,
                    'attachment_realname' => $file->getClientOriginalName(), 
                    'attachment_filename' => "$directory/$fileName",       
                    'file_type' => $file->getClientMimeType(),
                ]);
            }
        }

        // Tambahkan ke Logs
        Logs::create([
            'logs_id'     => (string) \Illuminate\Support\Str::uuid(),
            'user_id'     => Auth::id(),
            'action'      => 'Create Note',
            'description' => "Membuat note baru dengan ID {$note->notes_id} dan judul: {$note->note_title}",
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->header('User-Agent'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Note created successfully!',
            'note_id' => $note->notes_id
        ]);
    }

    // Save or Update Note
    public function updatePrivateNote(Request $request)
    {
        // Validasi input
        $request->validate([
            'note_title' => 'required|string|max:255',
            'note_content' => 'required|string|max:255',
            'notes_id' => 'required|string|exists:notes,notes_id'
        ]);

        $userId = $request->user()->user_id;

        // Cari note berdasarkan notes_id
        $note = Notes::where('notes_id', $request->notes_id)->firstOrFail();

        // Update note
        $note->update([
            'note_title' => $request->note_title,
            'note_content' => $request->note_content,
        ]);

        // Log user action ke tabel logs (gunakan model Eloquent)
        Logs::create([
            'logs_id' => Str::uuid()->toString(),
            'user_id' => $userId,
            'action' => 'Update Note',
            'description' => "Updated note: {$note->note_title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json([
            'success' => true,
            'note_id' => $note->notes_id,
            'message' => 'Note updated successfully'
        ]);
    }

    // Delete Note
    public function DeleteNote($noteId)
    {
        $note = Notes::where('notes_id', $noteId)->first();

        if (!$note) {
            return response()->json(['success' => false, 'message' => 'Note not found'], 404);
        }

        $note->delete();

        // Log aktivitas user
        Logs::create([
            'user_id' => Auth::user()?->user_id,
            'action' => 'Delete Note',
            'description' => "Deleted note: {$note->note_title}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully'
        ]);
    }

    // Get Comment Note
    public function getComments($noteId)
    {
        $comments = Comment::where('notes_id', $noteId)
            ->with('user') 
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($c) => [
                'user' => $c->user->fullname,
                'comment' => $c->comment_text,
                'created_at' => $c->created_at->diffForHumans()
            ]);

        return response()->json($comments);
    }

    // Upload Comment Note
    public function uploadComment(Request $request, $notes)
    {
        $request->validate([
            'comment' => 'required|string|max:255'
        ]);

        $note = Notes::findOrFail($notes);

        $comment = Comment::create([
            'comment_id' => Str::uuid(),
            'notes_id' => $note->notes_id,
            'user_id' => Auth::id(),
            'comment_text' => $request->comment
        ]);

        return response()->json([
            'user' => Auth::user()->fullname,
            'comment' => $comment->comment_text,
            'created_at' => $comment->created_at->format('d M Y H:i')
        ]);
    }







}
    