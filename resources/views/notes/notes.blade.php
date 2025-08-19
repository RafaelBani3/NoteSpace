@extends('layouts.app')

@section('title', 'NoteSpace')
@section('subtitle', 'Dashboard')

@section('content')

    <style>
        .section-spacing {
            margin-top: 2.5rem;
        }
        
        .note-card {
            background: #fff9c4;
            border-radius: 8px;
            box-shadow: 2px 4px 6px rgba(0, 0, 0, 0.15);
            padding: 16px;
            position: relative;
            transition: all 0.25s ease-in-out;
            transform: rotate(-1deg);
            height: 150px;
        }

        .note-card:nth-child(even) {
            transform: rotate(1.5deg);
        }

        .note-card:hover {
            transform: scale(1.05) rotate(0deg);
            box-shadow: 4px 8px 16px rgba(0, 0, 0, 0.25);
            z-index: 5;
        }

        .note-content h5 {
            color: #333;
        }

        .add-card {
            background: #e0e0e0 !important;
            cursor: pointer;
            transition: all 0.25s ease-in-out;
        }

        .add-card:hover {
            background: #d6d6d6 !important;
            transform: scale(1.08) rotate(0deg);
        }

        .note-actions {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            display: flex;
            gap: 8px;
            transition: opacity 0.3s ease-in-out;
            z-index: 10;
        }

        .note-card:hover .note-actions {
            opacity: 1;
        }

        .note-actions button {
            border: none;
            border-radius: 50%;
            padding: 6px 10px;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 1px 2px 5px rgba(0,0,0,0.2);
            transition: transform 0.2s ease;
        }

        .note-actions button:hover {
            transform: scale(1.2);
        }

        .btn-edit { background: #4caf50; color: white; }
        .btn-view { background: #2196f3; color: white; }
        .btn-delete { background: #f44336; color: white; }

    </style>

    <!-- Note Dashboard -->
        <div class="card shadow-sm border-0 rounded-3 mb-6">
            <div class="card-body">
                <!-- Greeting -->
                <div class="d-flex justify-content-between align-items-center mb-8">
                    <div>
                        <h1 class="fw-bold mb-1">
                            Hi, {{ Auth::user()->fullname }}!
                        </h1>
                        <small class="text-muted fs-5">
                            Have a nice day. Come on, write something today
                        </small>
                    </div>
                    <button class="btn btn-primary px-4 py-2 rounded-1 shadow-sm hover-scale" data-bs-toggle="modal" data-bs-target="#createNoteModal">
                        <i class="ki-duotone ki-add-files fs-1"></i> Create Note
                    </button>
                </div>

                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab_dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab_private">Private Notes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab_shared">Shared Notes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab_public">Public Notes</a>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content" id="myTabContent">

                    <!-- Dashboard -->
                    <div class="tab-pane fade show active" id="tab_dashboard" role="tabpanel">
                        <p class="text-muted">Dashboard Notes</p>
                    </div>

                    <!-- Private Notes -->
                    <div class="tab-pane fade" id="tab_private" role="tabpanel">
                        <h4 class="fw-bold mb-6">My Private Notes</h4>
                        <div class="row g-3">
                            @forelse($privateNotes as $note)
                                <div class="col-md-3">
                                    <div class="note-card cursor-pointer" 
                                        data-id="{{ $note->notes_id }}" 
                                        data-title="{{ $note->note_title }}" 
                                        data-content="{{ $note->note_content }}"
                                        data-created="{{ $note->created_at->format('d M Y') }}">

                                        <div class="note-content">
                                            <h5 class="fw-bold mb-1">{{ $note->note_title }}</h5>
                                            <small class="text-muted">Created: {{ $note->created_at->format('d M Y') }}</small>
                                            <p class="mt-2 text-truncate" style="max-width: 200px;">
                                                {{ $note->note_content }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">🚫 No private notes available yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Shared Notes Tab -->
                    <div class="tab-pane fade" id="tab_shared" role="tabpanel">

                        <!-- Notes You Shared -->
                        <h4 class="fw-bold mb-6">Notes You Shared</h4>
                        <div class="row g-3 mb-10">
                            @forelse($mySharedNotes as $note)
                                <div class="col-md-3">
                                    <div class="note-card p-3 rounded shadow-sm cursor-pointer" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalSharedNote"
                                        data-id="{{ $note->notes_id }}" 
                                        data-title="{{ $note->note_title }}" 
                                        data-content="{{ $note->note_content }}"
                                        data-created="{{ $note->created_at->format('d M Y') }}"
                                        data-attachments='@json($note->attachments)'>
                                        
                                        <h5 class="fw-bold mb-2">{{ $note->note_title }}</h5>
                                        <small class="text-muted">Created: {{ $note->created_at->format('d M Y') }}</small>
                                        <p class="mt-3 text-truncate" style="max-width: 200px;">
                                            {{ $note->note_content }}
                                        </p>
                                        
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">You haven't shared any notes yet.</p>
                            @endforelse
                        </div>

                        <!-- Notes Shared To You -->
                        <h4 class="fw-bold mb-6">Notes Shared To You</h4>
                        <div class="row g-3">
                            @forelse($receivedNotes as $share)
                                <div class="col-md-3">
                                    <div class="note-card p-3 rounded shadow-sm cursor-pointer" 
                                        style="background: #f1f8e9;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalReceivedNote"
                                        data-id="{{ $share->note->notes_id }}"
                                        data-title="{{ $share->note->note_title }}"
                                        data-content="{{ $share->note->note_content }}"
                                        data-user="{{ $share->note->user->fullname ?? 'Unknown User' }}"
                                        data-created="{{ $share->created_at->format('d M Y') }}"
                                        data-attachments='@json($share->note->attachments)'>

                                        <h5 class="fw-bold mb-2">{{ $share->note->note_title }}</h5>
                                        <small class="text-muted">Created by: {{ $share->note->user->fullname ?? 'Unknown User' }}</small><br>
                                        <small class="text-muted">Shared at: {{ $share->created_at->format('d M Y') }}</small>
                                        <p class="mt-3 text-truncate" style="max-width: 200px;">
                                            {{ $share->note->note_content }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No notes have been shared with you yet.</p>
                            @endforelse
                        </div>

                    </div>

                    <!-- Public Notes -->
                    <div class="tab-pane fade" id="tab_public" role="tabpanel">
                        
                        <h4 class="fw-bold mb-6">My Public Notes</h4>
                        <div class="row g-3 mb-10">
                            @forelse($myPublicNotes as $note)
                                <!-- My Public Notes -->    
                                <div class="col-md-3">
                                    <div class="note-card p-3 rounded shadow-sm note-item-my-public" 
                                        style="background: #fff3e0; cursor: pointer;"
                                        data-id="{{ $note->notes_id }}"
                                        data-title="{{ $note->note_title }}" 
                                        data-content="{{ $note->note_content }}"
                                        data-created="{{ $note->created_at->format('d M Y') }}"
                                        data-attachments='@json($note->attachments)'>

                                        <h5 class="fw-bold mb-2">{{ $note->note_title }}</h5>
                                        <small class="text-muted">Created: {{ $note->created_at->format('d M Y') }}</small>
                                        <p class="mt-3 text-truncate" style="max-width: 200px;">
                                            {{ $note->note_content }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">You don’t have any public notes yet.</p>
                            @endforelse
                        </div>

                        <h4 class="fw-bold mb-6">Public Notes From Others</h4>
                        <div class="row g-3">
                            @forelse($allPublicNotes as $note)
                                <!-- Public Notes From Others -->
                                <div class="col-md-3">
                                    <div class="note-card p-3 rounded shadow-sm note-item-other-public" 
                                        style="background: #ede7f6; cursor: pointer;"
                                        data-id="{{ $note->notes_id }}">
                                        <h5 class="fw-bold mb-2">{{ $note->note_title }}</h5>
                                        <small class="text-muted">Created by: {{ $note->user->fullname ?? 'Unknown User' }}</small>
                                        <p class="mt-3 text-truncate" style="max-width: 200px;">
                                            {{ $note->note_content }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No public notes from other users yet.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <!-- End Note Dashboard -->

    <!-- Modal Create Note -->
    <div class="modal fade" tabindex="-1" id="createNoteModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Create New Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="createNoteForm">
                        <!-- Note Title -->
                        <div class="mb-5">
                            <label class="form-label">Notes Title</label>
                            <input type="text" class="form-control form-control-solid" id="note_title" name="note_title" placeholder="Your notes title here.." maxlength="35" required/>
                        </div>

                        <!-- Note Content -->
                        <div class="mb-5">
                            <label class="form-label">Notes Content</label>
                            <textarea class="form-control form-control-solid" id="note_content" name="note_content" placeholder="Your notes content here.." rows="4" maxlength="255" required></textarea>
                        </div>

                        <!-- Note Visibility -->
                        <div class="mb-5">
                            <label class="form-label">Visibility</label>
                            <select class="form-select form-select-solid" id="noteVisibility" name="note_public" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" data-hide-search="true" required>
                                <option value="">Select an Option</option>
                                <option value="private">Private</option>
                                <option value="shared">Share with user</option>
                                <option value="public">Public</option>
                            </select>
                        </div>

                        <!-- Shared With Users (hidden by default) -->
                        <div class="mb-5" id="sharedWithUsersContainer" style="display: none;">
                            <label class="form-label">Select Users to Share With</label>
                            <select class="form-select form-select-solid" id="sharedWithUsers" name="shared_with_users[]" multiple="multiple" data-control="select2" data-placeholder="Select users to share">
                                <!-- Option By Ajax -->
                            </select>
                        </div>

                        <!--begin::Input group-->
                        <div class="fv-row">
                            <label class="form-label">Attachment</label>

                            <!--begin::Dropzone-->
                            <div class="dropzone" id="noteAttachmentsDropzone">
                                <!--begin::Message-->
                                <div class="dz-message needsclick">
                                    <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

                                    <!--begin::Info-->
                                    <div class="ms-4">
                                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                        <span class="fs-7 fw-semibold text-gray-500">Upload up to 5 files.</span>
                                    </div>
                                    <!--end::Info-->
                                </div>
                            </div>
                            <!--end::Dropzone-->
                        </div>
                        <!--end::Input group-->
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="createNoteForm" class="btn btn-primary">Save Note</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Private Notes -->
    <div class="modal fade" tabindex="-1" id="noteModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-3">
                
                <!-- Title -->
                <div class="modal-header flex-column align-items-start">
                    <label for="noteTitle" class="form-label fw-semibold text-muted mb-1">Note Title</label>
                    <div class="d-flex w-100">
                        <input type="text" id="noteTitle" 
                            class="form-control fs-3 fw-bold border-0 p-0 flex-grow-1" 
                            placeholder="Enter note title..." 
                            style="background: transparent; box-shadow: none;" />
                        <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"></i>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="modal-body">
                    <textarea id="noteContent" 
                            class="form-control border-0 fs-5" 
                            rows="12" 
                            placeholder="Start writing your note..." 
                            style="resize: none; background: transparent; box-shadow: none;"></textarea>
                    <small class="text-muted d-block mt-2" id="noteCreated"></small>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger px-4" id="deleteNote">Delete Note</button>
                    <button type="button" class="btn btn-success px-4" id="updatePrivateNote">Save Note</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Notes You Shared -->
    {{-- <div class="modal fade" id="modalSharedNote" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content border-0 shadow-lg rounded-3">

                <!-- Title -->
                <div class="modal-header flex-column align-items-start">
                    <label class="form-label fw-semibold text-muted mb-1">Note Title</label>
                    <div class="d-flex w-100">
                        <input type="text" id="sharedNoteTitle" 
                            class="form-control fs-3 fw-bold border-0 p-0 flex-grow-1" 
                            placeholder="Enter note title..." 
                            style="background: transparent; box-shadow: none;" />
                        <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"></i>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="modal-body">
                    <textarea id="sharedNoteContent" class="form-control border-0 fs-5" rows="10" 
                            placeholder="Start writing your note..." 
                            style="resize: none; background: #f9f9f9; padding: 12px; border-radius: 6px;"></textarea>
                </div>

                <!-- Attachments -->
                <div class="modal-body" id="sharedNoteAttachments">
                    <label class="form-label fw-semibold mb-2">Attachments:</label>
                    <div class="d-flex flex-wrap gap-2" id="sharedAttachmentsContainer">
                        <!-- Attachment cards akan di-render di sini -->
                    </div>
                </div>

                <small class="text-muted d-block mt-2 ms-3 px-5" id="sharedNoteCreated"></small>

                <div class="modal-footer d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-danger px-4" id="deleteSharedNote">Delete Note</button>
                    <button type="button" class="btn btn-success px-4" id="saveSharedNote">Save Note</button>
                </div>

            </div>
        </div>
    </div> --}}

    <!-- Modal: Notes You Shared -->
    <div class="modal fade" id="modalSharedNote" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content border-0 shadow-lg rounded-3">

                <!-- Title -->
                <div class="modal-header flex-column align-items-start">
                    <label class="form-label fw-semibold text-muted mb-1">Note Title</label>
                    <div class="d-flex w-100">
                        <input type="text" id="sharedNoteTitle" 
                            class="form-control fs-3 fw-bold border-0 p-0 flex-grow-1" 
                            placeholder="Enter note title..." 
                            style="background: transparent; box-shadow: none;" />
                        <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"></i>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Side -->
                        <div class="col-md-8 pe-3">
                            <textarea id="sharedNoteContent" class="form-control border-0 fs-5 mb-4" rows="10" 
                                    placeholder="Start writing your note..." 
                                    style="resize: none; background: #f9f9f9; padding: 12px; border-radius: 6px;"></textarea>

                            <!-- Attachments -->
                            <div id="sharedNoteAttachments">
                                <label class="form-label fw-semibold mb-2">Attachments:</label>
                                <div class="d-flex flex-wrap gap-2" id="sharedAttachmentsContainer">
                                    <!-- Attachment cards -->
                                </div>
                            </div>
                        </div>

                        <!-- Right Side (Comments) -->
                        <div class="col-md-4 border-start ps-3">
                            <h5 class="fw-bold mb-3">Comments</h5>
                            <div id="sharedNoteComments" class="mb-3" 
                                style="max-height: 280px; overflow-y: auto; background: #f9f9f9; padding: 10px; border-radius: 6px;">
                                <!-- Comments render here -->
                            </div>

                            <div class="d-flex">
                                <input type="text" id="sharedCommentInput" class="form-control me-2" placeholder="Write a comment...">
                                <button id="sendSharedComment" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <small class="text-muted d-block mt-2 ms-3 px-5" id="sharedNoteCreated"></small>
                <div class="modal-footer d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-danger px-4" id="deleteSharedNote">Delete Note</button>
                    <button type="button" class="btn btn-success px-4" id="saveSharedNote">Save Note</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal: Notes Shared To You -->
    <div class="modal fade" id="modalReceivedNote" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content border-0 shadow-lg rounded-3">

                <!-- Header -->
                <div class="modal-header flex-column align-items-start">
                    <label class="form-label fw-semibold text-muted mb-1">Note Title</label>
                    <div class="d-flex w-100">
                        <h3 id="receivedNoteTitle" class="form-control fs-3 fw-bold border-0 p-0 flex-grow-1 bg-transparent"></h3>
                        <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"></i>
                        </button>
                    </div>

                    <!-- User + Date -->
                    <div class="d-flex align-items-center gap-2 text-muted small mt-2">
                        <i class="bi bi-person-circle"></i>
                        <span id="receivedNoteUser"></span>
                        <span class="mx-2">•</span>
                        <i class="bi bi-calendar3"></i>
                        <span id="receivedNoteCreated"></span>
                    </div>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Side (Content + Attachments) -->
                        <div class="col-md-8 pe-3">
                            <textarea id="receivedNoteContent" class="form-control border-0 fs-5 mb-4" rows="10" 
                                placeholder="Start writing your note..." 
                                style="resize: none; background: #f9f9f9; padding: 12px; border-radius: 6px;" readonly></textarea>

                            {{-- <!-- Attachments -->
                            <div>
                                <label class="form-label fw-semibold mb-2">📎 Attachments</label>
                                <div class="d-flex flex-wrap gap-2" id="receivedAttachmentsContainer">
                                    <!-- Attachment cards -->
                                </div>
                            </div> --}}

                            <!-- Attachments -->
                            <div id="receivedAttachmentsContainer">
                                <label class="form-label fw-semibold mb-2">Attachments:</label>
                                <div class="d-flex flex-wrap gap-2" id="receivedAttachmentsContainer">
                                    <!-- Attachment cards -->
                                </div>
                            </div>
                        </div>

                        <!-- Right Side (Comments) -->
                        <div class="col-md-4 border-start ps-3">
                            <h5 class="fw-bold mb-3">Comments</h5>

                            <!-- Comments list -->
                            <div id="noteComments" class="mb-3"
                                style="max-height: 280px; overflow-y: auto; background: #f9f9f9; padding:10px; border-radius:6px;">
                                <!-- comment items render here -->
                            </div>

                            <!-- Input comment -->
                            <div class="d-flex">
                                <input type="text" id="newComment" class="form-control me-2" placeholder="Write a comment...">
                                <button class="btn btn-primary" id="sendComment">Send</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal My Public Note -->
    <div class="modal fade" id="modalMyPublicNote" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <!-- Header -->
                <div class="modal-header flex-column align-items-start">
                    <label class="form-label fw-semibold text-muted mb-1">Note Title</label>
                    <div class="d-flex w-100">
                        <input type="text" id="myPublicNoteTitle" class="form-control fs-3 fw-bold border-0 p-0 flex-grow-1" placeholder="Enter note title..." style="background: transparent; box-shadow: none;" />
                        <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"></i>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Left: Content & Attachments -->
                        <div class="col-md-8 pe-3">
                            <textarea id="myPublicNoteContent" class="form-control border-0 fs-5 mb-4" rows="10" placeholder="Start writing your note..." style="resize: none; background: #f9f9f9; padding: 12px; border-radius: 6px;"></textarea>
                            <div id="myPublicNoteAttachments">
                                <label class="form-label fw-semibold mb-2">Attachments:</label>
                                <div class="d-flex flex-wrap gap-2" id="myPublicAttachmentsContainer"></div>
                            </div>
                        </div>

                        <!-- Right: Comments -->
                        <div class="col-md-4 border-start ps-3">
                            <h5 class="fw-bold mb-3">Comments</h5>
                            <div id="myPublicNoteComments" class="mb-3" style="max-height: 280px; overflow-y: auto; background: #f9f9f9; padding: 10px; border-radius: 6px;"></div>
                            <div class="d-flex">
                                <input type="text" id="myPublicCommentInput" class="form-control me-2" placeholder="Write a comment...">
                                <button id="sendMyPublicComment" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <small class="text-muted d-block mt-2 ms-3 px-5" id="myPublicNoteCreated"></small>
                <div class="modal-footer d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-danger px-4" id="deleteMyPublicNote">Delete Note</button>
                    <button type="button" class="btn btn-success px-4" id="saveMyPublicNote">Save Note</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Public Note From Other --> 
    <div class="modal fade" id="modalPublicFromOthers" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content border-0 shadow-lg rounded-3">

                <!-- Title -->
                <div class="modal-header flex-column align-items-start">
                    <label class="form-label fw-semibold text-muted mb-1">Note Title</label>
                    <div class="d-flex w-100">
                        <input type="text" id="otherNoteTitle" 
                            class="form-control fs-3 fw-bold border-0 p-0 flex-grow-1" 
                            readonly
                            style="background: transparent; box-shadow: none;" />
                        <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"></i>
                        </button>
                    </div>
                </div>

                <!-- Content & Comments -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Left: Note Content -->
                        <div class="col-md-8 pe-3">
                            <textarea id="otherNoteContent" class="form-control border-0 fs-5 mb-4" rows="10" 
                                    readonly
                                    style="resize: none; background: #f5f5f5; padding: 12px; border-radius: 6px;"></textarea>

                            <!-- Attachments -->
                            <div id="otherNoteAttachments">
                                <label class="form-label fw-semibold mb-2">Attachments:</label>
                                <div class="d-flex flex-wrap gap-2" id="otherAttachmentsContainer">
                                    <!-- Attachment cards -->
                                </div>
                            </div>
                        </div>

                        <!-- Right: Comments -->
                        <div class="col-md-4 border-start ps-3">
                            <h5 class="fw-bold mb-3">Comments</h5>
                            <div id="otherNoteComments" class="mb-3" 
                                style="max-height: 280px; overflow-y: auto; background: #f9f9f9; padding: 10px; border-radius: 6px;">
                                <!-- Comments render here -->
                            </div>
                            <div class="d-flex">
                                <input type="text" id="otherCommentInput" class="form-control me-2" placeholder="Write a comment...">
                                <button id="sendOtherComment" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>

                <small class="text-muted d-block mt-2 ms-3 px-5" id="otherNoteCreated"></small>

                 <!-- Footer -->
                <div class="modal-footer d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-danger px-4" id="deleteMyPublicNote">Delete Note</button>
                    <button type="button" class="btn btn-success px-4" id="saveMyPublicNote">Save Note</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Jika User Pilih Untuk Sharing Notes dengan user lain -->
    <script>
        $(document).ready(function() {
            $('#sharedWithUsers').select2({
                width: '100%',
                placeholder: 'Select users to share',
                allowClear: true,
                ajax: {
                    url: "{{ route('users.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return { search: params.term }; 
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                }
            });


            $('#noteVisibility').on('change', function() {
                if ($(this).val() === 'shared') {
                    $('#sharedWithUsersContainer').show();
                } else {
                    $('#sharedWithUsersContainer').hide();
                    $('#sharedWithUsers').val(null).trigger('change');
                }
            });
        });
    </script>

    <!-- Maxlength Note Title & Content  -->
    <script>
        $('#note_title').maxlength({
            alwaysShow: true,
            threshold: 35,
            warningClass: "badge badge-primary",
            limitReachedClass: "badge badge-danger"
        });

        $('#note_content').maxlength({
            alwaysShow: true,
            threshold: 255,
            warningClass: "badge badge-primary",
            limitReachedClass: "badge badge-danger"
        });
    </script>

    <!-- Script Dropzone + Create New Notes-->
    <script>
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#noteAttachmentsDropzone", {
            autoProcessQueue: false,
            url: "https://keenthemes.com/scripts/void.php", 
            uploadMultiple: true,
            parallelUploads: 5,
            maxFiles: 5,
            maxFilesize: 5,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });

        // Handle submit form
        document.getElementById("createNoteForm").addEventListener("submit", function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            myDropzone.files.forEach((file, i) => {
                formData.append("attachments[]", file);
            });

            fetch("{{ route('notes.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(res => {
                if (res.status === 422) {
                    return res.json().then(err => { throw err; });
                }
                return res.json();
            })
            .then(data => {
                if (data.status === "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        timer: 700,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                    myDropzone.removeAllFiles();
                    e.target.reset();
                    document.getElementById("sharedWithUsersContainer").style.display = "none";
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: data.message || "Something went wrong"
                    });
                }
            })
            .catch(err => {
                if (err.errors) {
                    let messages = Object.values(err.errors).flat().join('<br>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: messages
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to save note. Please try again.'
                    });
                }
            });
        });

    </script>

    <!-- Script Private Note -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        
        let noteModal = new bootstrap.Modal(document.getElementById('noteModal'));
        let noteId = null;
        
  
        // Klik note-card untuk buka modal
        document.querySelectorAll("#tab_private .note-card").forEach(card => {
            card.addEventListener("click", function () {
                noteId = this.dataset.id; // notes_id dari database
                if (!noteId) return alert("Note ID not found!");

                document.getElementById("noteTitle").value = this.dataset.title || '';
                document.getElementById("noteContent").value = this.dataset.content || '';
                document.getElementById("noteCreated").innerText = "Created: " + (this.dataset.created || '-');
                noteModal.show();
            });
        });

        // Delete note
        const btnDelete = document.getElementById("deleteNote");

        // Initialisasi Route Delete
        const deleteNoteUrl = "{{ route('deleteNote', ['note' => 'NOTE_ID']) }}";

        btnDelete.addEventListener("click", function () {
        if (!noteId) return Swal.fire('Error', 'No note selected!', 'error');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
                if (result.isConfirmed) {
                    // Tombol jadi Please wait
                    btnDelete.innerText = "Please wait...";
                    btnDelete.disabled = true;

                    // Ganti NOTE_ID dengan noteId
                    const url = deleteNoteUrl.replace('NOTE_ID', noteId);

                    fetch(url, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire({
                            icon: data.success ? 'success' : 'error',
                            title: data.success ? 'Deleted!' : 'Failed!',
                            text: data.message,
                            timer: 500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete note!',
                            timer: 500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    });
                }
            });
        });
        
        // Update note dengan SweetAlert feedback
        const btnSave = document.getElementById("updatePrivateNote");

        btnSave.addEventListener("click", function () {
            if (!noteId) return Swal.fire('Error', 'No note selected!', 'error');

            const title = document.getElementById("noteTitle").value.trim();
            const content = document.getElementById("noteContent").value.trim();

            if (!title || !content) return Swal.fire('Error', 'Title and Content cannot be empty!', 'error');

            const originalText = btnSave.innerText;
            btnSave.innerText = "Please wait...";
            btnSave.disabled = true;

            setTimeout(() => {
                fetch(`/NoteSpace/UpdateNote`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        notes_id: noteId,
                        note_title: title,
                        note_content: content
                    })
                })
                .then(res => res.json())
                .then(data => {
                    setTimeout(() => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message,
                                timer: 800,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: 'Failed to update note!',
                                timer: 800,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        }
                    }, 800);
                })
                .catch(err => {
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error saving note!',
                            timer: 800,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    }, 800);
                });
            }, 700); 
        });
    });
    </script>

    <!-- Script Shared Note -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            let noteModal = new bootstrap.Modal(document.getElementById('modalSharedNote'));
            let noteId = null;
        
            // Helper untuk render attachments
            function renderAttachments(container, attachments) {
                const attachContainer = document.getElementById('sharedAttachmentsContainer');
                attachContainer.innerHTML = ''; // Clear previous

                attachments.forEach(file => {
                    let ext = file.attachment_filename.split('.').pop().toLowerCase();
                    let iconClass = 'bi-file-earmark'; // default generic file

                    if(['jpg','jpeg','png','gif'].includes(ext)) iconClass = 'bi-file-earmark-image';
                    else if(ext === 'pdf') iconClass = 'bi-file-earmark-pdf';
                    else if(['doc','docx'].includes(ext)) iconClass = 'bi-file-earmark-word';
                    else if(['xls','xlsx'].includes(ext)) iconClass = 'bi-file-earmark-excel';

                    let div = document.createElement('div');
                    div.className = 'attachment-card p-2 d-flex align-items-center gap-2 rounded shadow-sm';
                    div.style.background = '#e3f2fd';
                    div.style.minWidth = '180px';
                    div.innerHTML = `
                        <i class="bi ${iconClass} fs-4 text-primary"></i>
                        <span class="text-truncate" style="max-width: 100px;">${file.attachment_realname}</span>
                        <a href="/storage/${file.attachment_filename}" target="_blank" class="btn btn-sm btn-light ms-auto">Download</a>
                    `;
                    attachContainer.appendChild(div);
                });
            }

            //  Helper untuk render attachments khusus untuk modal Received
            function renderAttachmentsReceived(attachments) {
                const container = document.getElementById('receivedAttachmentsContainer');
                container.innerHTML = '';

                attachments.forEach(file => {
                    let ext = file.attachment_filename.split('.').pop().toLowerCase();
                    let iconClass = 'bi-file-earmark';

                    if(['jpg','jpeg','png','gif'].includes(ext)) iconClass = 'bi-file-earmark-image';
                    else if(ext === 'pdf') iconClass = 'bi-file-earmark-pdf';
                    else if(['doc','docx'].includes(ext)) iconClass = 'bi-file-earmark-word';
                    else if(['xls','xlsx'].includes(ext)) iconClass = 'bi-file-earmark-excel';

                    let div = document.createElement('div');
                    div.className = 'attachment-card p-2 d-flex align-items-center gap-2 rounded shadow-sm';
                    div.style.background = '#e3f2fd';
                    div.style.minWidth = '180px';
                    div.innerHTML = `
                        <i class="bi ${iconClass} fs-4 text-primary"></i>
                        <span class="text-truncate" style="max-width: 100px;">${file.attachment_realname}</span>
                        <a href="/storage/${file.attachment_filename}" target="_blank" class="btn btn-sm btn-light ms-auto">Download</a>
                    `;
                    container.appendChild(div);
                });
            }

            // Helper render comments
            function renderComments(comments) {
                const container = document.getElementById('sharedNoteComments');
                container.innerHTML = '';

                if (!comments.length) {
                    container.innerHTML = `<p class="text-muted">No comments yet.</p>`;
                    return;
                }

                comments.forEach(c => {
                    const div = document.createElement('div');
                    div.className = 'mb-2 p-2 bg-white rounded shadow-sm';
                    div.innerHTML = `<strong>${c.user}</strong>: ${c.comment}<br><small class="text-muted">${c.created_at}</small>`;
                    container.appendChild(div);
                });

                // Scroll ke comment terbaru
                container.scrollTop = container.scrollHeight;
            }

            // Load comments
            function loadComments() {
                if (!noteId) return;
                fetch(`/NoteSpace/notes/${noteId}/comments`)
                    .then(res => res.json())
                    .then(renderComments)
                    .catch(err => console.error(err));
            }

            // ===========================  
            // Notes You Shared Modal
            // ===========================
            const sharedNotes = document.querySelectorAll('#tab_shared .note-card.cursor-pointer');
            const modalShared = document.getElementById('modalSharedNote');

            sharedNotes.forEach(card => {
                card.addEventListener('click', function () {
                    noteId = card.dataset.id;

                    if (!noteId) return Swal.fire("Error", "Note ID not found!", "error");

                    document.getElementById('sharedNoteTitle').value = card.dataset.title;
                    document.getElementById('sharedNoteContent').value = card.dataset.content;
                    document.getElementById('sharedNoteCreated').innerText = `Created: ${card.dataset.created}`;

                    const attachments = JSON.parse(card.dataset.attachments || '[]');
                    renderAttachments(document.getElementById('sharedNoteAttachments'), attachments);

                    // load comments pas buka modal
                    loadComments();
                });
            });

            // Send comment
            document.getElementById("sendSharedComment").addEventListener("click", () => {
                const input = document.getElementById("sharedCommentInput");
                const commentText = input.value.trim();
                if (!commentText) return;

                fetch(`/NoteSpace/notes/${noteId}/comment`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ comment: commentText })
                })
                .then(res => res.json())
                .then(data => {
                    if (data && data.comment) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Comment Sent!',
                            text: 'Your comment has been uploaded.',
                            timer: 900,
                            showConfirmButton: false
                        });
                        input.value = "";
                        loadComments();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: 'Failed to send comment.',
                            timer: 900,
                            showConfirmButton: false
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to send comment.',
                        timer: 900,
                        showConfirmButton: false
                    });
                });
            });

            // Save Shared Note
            const btnSaveSharedNote = document.getElementById("saveSharedNote");

            btnSaveSharedNote.addEventListener("click", function () {
                if (!noteId) return Swal.fire('Error', 'No note selected!', 'error');

                const title = document.getElementById("sharedNoteTitle").value.trim();
                const content = document.getElementById("sharedNoteContent").value.trim();

                if (!title || !content) return Swal.fire('Error', 'Title and Content cannot be empty!', 'error');

                const originalText = btnSaveSharedNote.innerText;
                btnSaveSharedNote.innerText = "Please wait...";
                btnSaveSharedNote.disabled = true;

                setTimeout(() => {
                    fetch(`/NoteSpace/UpdateNote`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            notes_id: noteId,
                            note_title: title,
                            note_content: content
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        setTimeout(() => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.message,
                                    timer: 800,
                                    showConfirmButton: false
                                }).then(() => location.reload());
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: 'Failed to update note!',
                                    timer: 800,
                                    showConfirmButton: false
                                }).then(() => location.reload());
                            }
                        }, 800);
                    })
                    .catch(err => {
                        setTimeout(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error saving note!',
                                timer: 800,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        }, 800);
                    });
                }, 700); 
            });
            
            // Delete Shared Note
            const btnDeleteSharedNote = document.getElementById("deleteSharedNote");

            // Initialisasi Route Delete
            const deleteNoteUrl = "{{ route('deleteNote', ['note' => 'NOTE_ID']) }}";

            btnDeleteSharedNote.addEventListener("click", function () {
            if (!noteId) return Swal.fire('Error', 'No note selected!', 'error');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                    if (result.isConfirmed) {
                        // Tombol jadi Please wait
                        btnDeleteSharedNote.innerText = "Please wait...";
                        btnDeleteSharedNote.disabled = true;

                        // Ganti NOTE_ID dengan noteId
                        const url = deleteNoteUrl.replace('NOTE_ID', noteId);

                        fetch(url, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire({
                                icon: data.success ? 'success' : 'error',
                                title: data.success ? 'Deleted!' : 'Failed!',
                                text: data.message,
                                timer: 500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete note!',
                                timer: 500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        });
                    }
                });
            });

            // ===========================
            // END Notes You Shared Modal
            // ===========================

            // ===========================
            // Notes Shared To You Modal
            // ===========================
            const receivedNotesCards = document.querySelectorAll('#tab_shared .note-card[style*="background: #f1f8e9"]');
            const modalReceived = document.getElementById('modalReceivedNote');

            let activeNoteId = null; 

            receivedNotesCards.forEach(card => {
                card.addEventListener('click', () => {
                    activeNoteId = card.dataset.id; 

                    document.getElementById('receivedNoteTitle').innerText = card.dataset.title;
                    document.getElementById('receivedNoteContent').innerText = card.dataset.content;
                    document.getElementById('receivedNoteUser').innerText = `Created by: ${card.dataset.user}`;
                    document.getElementById('receivedNoteCreated').innerText = `Shared at: ${card.dataset.created}`;

                    const attachments = JSON.parse(card.dataset.attachments || '[]');
                    renderAttachmentsReceived(attachments);

                    // reset comment section ketika buka note baru
                    const commentContainer = document.getElementById('noteComments');
                    commentContainer.innerHTML = '';

                    // ============================
                    // Load comments dari server
                    // ============================
                    fetch(`/NoteSpace/notes/${activeNoteId}/comments`)
                        .then(res => res.json())
                        .then(comments => {
                            const commentContainer = document.getElementById('noteComments');
                            commentContainer.innerHTML = '';
                            comments.forEach(c => {
                                const div = document.createElement('div');
                                div.className = 'mb-2 p-2 bg-white rounded shadow-sm';
                                div.innerHTML = `<strong>${c.user}</strong>: ${c.comment} 
                                <br><small class="text-muted">${c.created_at}</small>`;
                                commentContainer.appendChild(div);
                            });
                        })
                        .catch(() => Swal.fire("Error", "Failed to load comments", "error"));
                });
            });


            // Send comment
            document.getElementById('sendComment').addEventListener('click', () => {
                const commentText = document.getElementById('newComment').value.trim();
                if (!commentText) return;

                if (!activeNoteId) {
                    Swal.fire("Error", "No note selected!", "error");
                    return;
                }

                fetch(`/NoteSpace/notes/${activeNoteId}/comment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ comment: commentText })
                })
                .then(res => res.json())
                .then(data => {
                    const div = document.createElement('div');
                    div.className = 'mb-2 p-2 bg-white rounded shadow-sm';
                    div.innerHTML = `<strong>${data.user}</strong>: ${data.comment} 
                    <br><small class="text-muted">${data.created_at}</small>`;
                    document.getElementById('noteComments').appendChild(div);
                    document.getElementById('newComment').value = '';

                    Swal.fire({
                        icon: 'success',
                        title: 'Comment added!',
                        timer: 900,               
                        showConfirmButton: false 
                    });
                })

                .catch(() => Swal.fire("Error", "Failed to send comment", "error"));
            });
        });

    </script>

    <!-- Script My Public Note -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let myPublicNoteId = null;
            const noteModal = new bootstrap.Modal(document.getElementById('modalMyPublicNote'));

            // Render comments
            function renderComments(comments) {
                const container = document.getElementById('myPublicNoteComments');
                container.innerHTML = '';
                if (!comments.length) {
                    container.innerHTML = `<p class="text-muted">No comments yet.</p>`;
                    return;
                }
                comments.forEach(c => {
                    const div = document.createElement('div');
                    div.className = 'mb-2 p-2 bg-white rounded shadow-sm';
                    div.innerHTML = `<strong>${c.user}</strong>: ${c.comment}<br><small class="text-muted">${c.created_at}</small>`;
                    container.appendChild(div);
                });
            }

            // Load comments
            function loadComments() {
                if (!myPublicNoteId) return;
                fetch(`/NoteSpace/notes/${myPublicNoteId}/comments`)
                    .then(res => res.json())
                    .then(renderComments)
                    .catch(err => console.error(err));
            }

            // Open modal
            document.querySelectorAll('.note-item-my-public').forEach(card => {
                card.addEventListener('click', () => {
                    myPublicNoteId = card.dataset.id;
                    document.getElementById('myPublicNoteTitle').value = card.dataset.title;
                    document.getElementById('myPublicNoteContent').value = card.dataset.content;
                    document.getElementById('myPublicNoteCreated').innerText = `Created: ${card.dataset.created}`;

                    // Attachments
                    const attachments = JSON.parse(card.dataset.attachments || '[]');
                    const attachContainer = document.getElementById('myPublicAttachmentsContainer');
                    attachContainer.innerHTML = '';
                    attachments.forEach(file => {
                        let ext = file.attachment_filename.split('.').pop().toLowerCase();
                        let iconClass = 'bi-file-earmark';
                        if(['jpg','jpeg','png','gif'].includes(ext)) iconClass = 'bi-file-earmark-image';
                        else if(ext === 'pdf') iconClass = 'bi-file-earmark-pdf';
                        else if(['doc','docx'].includes(ext)) iconClass = 'bi-file-earmark-word';
                        else if(['xls','xlsx'].includes(ext)) iconClass = 'bi-file-earmark-excel';

                        let div = document.createElement('div');
                        div.className = 'attachment-card p-2 d-flex align-items-center gap-2 rounded shadow-sm';
                        div.style.background = '#e3f2fd';
                        div.style.minWidth = '180px';
                        div.innerHTML = `<i class="bi ${iconClass} fs-4 text-primary"></i>
                            <span class="text-truncate" style="max-width: 100px;">${file.attachment_realname}</span>
                            <a href="/storage/${file.attachment_filename}" target="_blank" class="btn btn-sm btn-light ms-auto">Download</a>`;
                        attachContainer.appendChild(div);
                    });

                    loadComments();
                    noteModal.show();
                });
            });

            // Send Comment
            document.getElementById("sendMyPublicComment").addEventListener("click", () => {
                const input = document.getElementById("myPublicCommentInput");
                const comment = input.value.trim();
                if (!comment) return;

                fetch(`/NoteSpace/notes/${myPublicNoteId}/comment`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ comment })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.comment) {
                        Swal.fire({ icon: 'success', title: 'Comment Sent!', text: 'Uploaded.', timer: 900, showConfirmButton: false })
                        .then(() => {
                            input.value = "";
                            loadComments();
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Failed!', text: 'Failed to send comment.', timer: 900, showConfirmButton: false });
                    }
                })
                .catch(() => Swal.fire({ icon: 'error', title: 'Error!', text: 'Failed to send comment.', timer: 900, showConfirmButton: false }));
            });

            // Save Note
            document.getElementById("saveMyPublicNote").addEventListener("click", () => {
                const title = document.getElementById("myPublicNoteTitle").value.trim();
                const content = document.getElementById("myPublicNoteContent").value.trim();
                if (!title || !content) return Swal.fire('Error', 'Title & Content cannot be empty!', 'error');

                fetch(`/NoteSpace/UpdateNote`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ notes_id: myPublicNoteId, note_title: title, note_content: content })
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({ icon: data.success ? 'success' : 'error', title: data.success ? 'Saved!' : 'Failed!', text: data.message, timer: 900, showConfirmButton: false });
                    
                    if(data.success){
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: data.message,
                            timer: 900,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    }

                })
                .catch(() => Swal.fire({ icon: 'error', title: 'Error!', text: 'Failed to save note.', timer: 900, showConfirmButton: false }));
            });

            // Delete Note
            document.getElementById("deleteMyPublicNote").addEventListener("click", () => {
                if (!myPublicNoteId) return;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This note will be deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then(result => {
                    if (result.isConfirmed) {
                        fetch(`/NoteSpace/DeleteNote/${myPublicNoteId}`, {
                            method: "DELETE",
                            headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content }
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire({ icon: data.success ? 'success' : 'error', title: data.success ? 'Deleted!' : 'Failed!', text: data.message, timer: 900, showConfirmButton: false });
                            if(data.success){
                                const card = document.querySelector(`.note-item[data-id='${myPublicNoteId}']`);
                                if(card) card.remove();
                                noteModal.hide();
                            }
                        });
                    }
                });
            });

        });
    </script>

    <!-- Script Public Notes from others -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let otherNoteId = null;
            const noteModal = new bootstrap.Modal(document.getElementById('modalPublicFromOthers'));

            // Render attachments
            function renderAttachments(containerId, attachments){
                const container = document.getElementById(containerId);
                container.innerHTML = '';
                attachments.forEach(file => {
                    let ext = file.attachment_filename.split('.').pop().toLowerCase();
                    let iconClass = 'bi-file-earmark';
                    if(['jpg','jpeg','png','gif'].includes(ext)) iconClass = 'bi-file-earmark-image';
                    else if(ext==='pdf') iconClass = 'bi-file-earmark-pdf';
                    else if(['doc','docx'].includes(ext)) iconClass = 'bi-file-earmark-word';
                    else if(['xls','xlsx'].includes(ext)) iconClass = 'bi-file-earmark-excel';

                    let div = document.createElement('div');
                    div.className = 'attachment-card p-2 d-flex align-items-center gap-2 rounded shadow-sm';
                    div.style.background = '#e3f2fd';
                    div.style.minWidth = '180px';
                    div.innerHTML = `
                        <i class="bi ${iconClass} fs-4 text-primary"></i>
                        <span class="text-truncate" style="max-width: 100px;">${file.attachment_realname}</span>
                        <a href="/storage/${file.attachment_filename}" target="_blank" class="btn btn-sm btn-light ms-auto">Download</a>
                    `;
                    container.appendChild(div);
                });
            }

            // Render comments
            function renderComments(comments){
                const container = document.getElementById('otherNoteComments');
                container.innerHTML = '';
                if(!comments.length){
                    container.innerHTML = `<p class="text-muted">No comments yet.</p>`;
                    return;
                }
                comments.forEach(c => {
                    const div = document.createElement('div');
                    div.className = 'mb-2 p-2 bg-white rounded shadow-sm';
                    div.innerHTML = `<strong>${c.user}</strong>: ${c.comment}<br><small class="text-muted">${c.created_at}</small>`;
                    container.appendChild(div);
                });
            }

            // Load comments
            function loadComments(){
                if(!otherNoteId) return;
                fetch(`/NoteSpace/notes/${otherNoteId}/comments`)
                    .then(res => res.json())
                    .then(renderComments)
                    .catch(err => console.error(err));
            }

            // Click note to open modal
            document.querySelectorAll('.note-item-other-public').forEach(card => {
                card.addEventListener('click', () => {
                    if(!card.dataset.id) return;
                    otherNoteId = card.dataset.id;
                    document.getElementById('otherNoteTitle').value = card.querySelector('h5').innerText;
                    document.getElementById('otherNoteContent').value = card.querySelector('p').innerText;
                    document.getElementById('otherNoteCreated').innerText = `Created by: ${card.querySelector('small').innerText}`;

                    // Render attachments jika ada
                    const attachments = JSON.parse(card.dataset.attachments || '[]');
                    renderAttachments('otherAttachmentsContainer', attachments);

                    loadComments();
                    noteModal.show();
                });
            });

            // Send comment
            document.getElementById('sendOtherComment').addEventListener('click', () => {
                const input = document.getElementById('otherCommentInput');
                const comment = input.value.trim();
                if(!comment) return;

                fetch(`/NoteSpace/notes/${otherNoteId}/comment`, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ comment })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.comment){
                        Swal.fire({
                            icon: 'success',
                            title: 'Comment Sent!',
                            text: 'Your comment has been uploaded.',
                            timer: 900,
                            showConfirmButton: false
                        });
                        input.value = '';
                        loadComments();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: 'Failed to send comment.',
                            timer: 900,
                            showConfirmButton: false
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to send comment.',
                        timer: 900,
                        showConfirmButton: false
                    });
                });
            });
        });
    </script>

@endsection
