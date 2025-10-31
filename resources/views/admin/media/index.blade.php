@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="admin-page-title">
                <i class="fas fa-photo-video me-3"></i>
                Media Library
            </h2>
            <p class="admin-page-subtitle mb-0">
                Manage your images, videos, and documents
            </p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="fas fa-upload me-2"></i>
            Upload Files
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="admin-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-folder-open me-2"></i>
            All Media ({{ $media->total() }})
        </h5>
        <div class="btn-group">
            <button class="btn btn-sm btn-outline-light active" data-view="grid">
                <i class="fas fa-th"></i>
            </button>
            <button class="btn btn-sm btn-outline-light" data-view="list">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        @if($media->count() > 0)
            <div class="media-grid" id="mediaGrid">
                @foreach($media as $item)
                    <div class="media-item" data-id="{{ $item->id }}">
                        <div class="media-preview">
                            @if($item->type === 'image')
                                <img src="{{ $item->url }}" alt="{{ $item->title }}">
                            @elseif($item->type === 'video')
                                <div class="media-icon">
                                    <i class="fas fa-video fa-3x"></i>
                                </div>
                            @elseif($item->type === 'pdf')
                                <div class="media-icon">
                                    <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                </div>
                            @else
                                <div class="media-icon">
                                    <i class="fas fa-file fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="media-info">
                            <h6 class="media-title">{{ Str::limit($item->title, 30) }}</h6>
                            <small class="text-muted">{{ $item->formatted_size }}</small>
                        </div>
                        <div class="media-actions">
                            <button class="btn btn-sm btn-primary" onclick="copyUrl('{{ $item->url }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                            <a href="{{ $item->url }}" class="btn btn-sm btn-secondary" target="_blank">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <form action="{{ route('admin.media.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this file?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $media->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-photo-video fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No Media Files</h5>
                <p class="text-muted mb-4">Upload your first file to get started</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="fas fa-upload me-2"></i>
                    Upload Files
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-upload me-2"></i>
                    Upload Media
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select File</label>
                        <input type="file" class="form-control" name="file" id="fileInput" required>
                        <div class="form-text">Max size: 50MB. Supported: Images, Videos, PDFs, Documents</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title (Optional)</label>
                        <input type="text" class="form-control" name="title" id="titleInput">
                    </div>
                    <div id="uploadProgress" class="progress d-none mb-3">
                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="uploadFile()">
                    <i class="fas fa-upload me-2"></i>
                    Upload
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.page-header {
    background: white;
    border-radius: 15px;
    padding: 25px 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.admin-page-title {
    color: #2596be;
    font-weight: 700;
    font-size: 2rem;
    margin: 0;
}

.admin-page-subtitle {
    color: #6c757d;
    font-size: 1rem;
}

.admin-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.admin-card .card-header {
    background: linear-gradient(135deg, #2596be 0%, #4b95c4 100%);
    color: white;
    padding: 20px 25px;
    border: none;
}

.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.media-item {
    border: 1px solid #dee2e6;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.media-item:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.media-preview {
    height: 200px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.media-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.media-icon {
    color: #6c757d;
}

.media-info {
    padding: 12px;
    background: white;
}

.media-title {
    font-size: 0.9rem;
    margin: 0 0 5px 0;
    font-weight: 600;
}

.media-actions {
    padding: 10px;
    background: #f8f9fa;
    display: flex;
    gap: 5px;
    justify-content: center;
}
</style>
@endsection

@section('scripts')
<script>
function uploadFile() {
    const form = document.getElementById('uploadForm');
    const formData = new FormData(form);
    const progressBar = document.querySelector('#uploadProgress .progress-bar');
    const progressDiv = document.getElementById('uploadProgress');

    progressDiv.classList.remove('d-none');

    fetch('{{ route("admin.media.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        alert('Upload failed');
        progressDiv.classList.add('d-none');
    });
}

function copyUrl(url) {
    navigator.clipboard.writeText(url);
    alert('URL copied to clipboard!');
}
</script>
@endsection
