<!-- Image Selection Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="imagePickerStatus" class="mb-3"></div>
                <div class="row g-3" id="imageGrid">
                    <!-- Uploaded media images will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.image-picker-card {
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.image-picker-card:hover {
    border-color: #2596be !important;
    box-shadow: 0 8px 24px rgba(37, 150, 190, 0.18);
    transform: translateY(-2px);
}
</style>

<script>
let currentImageInput = null;
let cachedSelectableMedia = null;

const mediaLibraryUrl = @json(route('admin.media.index', ['ajax' => 1]));
const mediaUploadUrl = @json(route('admin.media.index'));

function selectImage(inputId) {
    currentImageInput = inputId;

    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('imageModal'));
    modal.show();
    loadSelectableMedia();
}

async function loadSelectableMedia(forceRefresh = false) {
    if (cachedSelectableMedia && !forceRefresh) {
        renderSelectableMedia(cachedSelectableMedia);
        return;
    }

    setImagePickerStatus(`
        <div class="alert alert-info mb-0">
            <i class="fas fa-spinner fa-spin me-2"></i>
            Loading uploaded images...
        </div>
    `);
    document.getElementById('imageGrid').innerHTML = '';

    try {
        const response = await fetch(mediaLibraryUrl, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error('Media request failed');
        }

        const data = await response.json();
        cachedSelectableMedia = Array.isArray(data.media) ? data.media : [];
        renderSelectableMedia(cachedSelectableMedia);
    } catch (error) {
        setImagePickerStatus(`
            <div class="alert alert-danger mb-0">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Could not load media. Please refresh the page and try again.
            </div>
        `);
    }
}

function renderSelectableMedia(mediaItems) {
    const imageGrid = document.getElementById('imageGrid');
    imageGrid.innerHTML = '';

    if (!mediaItems.length) {
        setImagePickerStatus(`
            <div class="alert alert-warning mb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span>
                    <i class="fas fa-image me-2"></i>
                    No uploaded images are available yet.
                </span>
                <a href="${mediaUploadUrl}" class="btn btn-sm btn-primary">
                    <i class="fas fa-upload me-1"></i>
                    Upload Media
                </a>
            </div>
        `);
        return;
    }

    setImagePickerStatus(`
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <small class="text-muted">${mediaItems.length} uploaded image${mediaItems.length === 1 ? '' : 's'} available</small>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="loadSelectableMedia(true)">
                <i class="fas fa-sync-alt me-1"></i>
                Refresh
            </button>
        </div>
    `);

    mediaItems.forEach(mediaItem => {
        const imageUrl = mediaItem.url || '';
        const imageTitle = mediaItem.title || mediaItem.filename || getImageFileName(imageUrl) || 'Uploaded image';

        const column = document.createElement('div');
        column.className = 'col-md-4 col-sm-6';

        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'card h-100 w-100 text-start border image-picker-card';
        button.addEventListener('click', () => selectImagePath(imageUrl));

        const image = document.createElement('img');
        image.src = imageUrl;
        image.className = 'card-img-top';
        image.alt = imageTitle;
        image.style.height = '150px';
        image.style.objectFit = 'cover';
        image.onerror = function() {
            this.src = '/images/placeholder.jpg';
        };

        const cardBody = document.createElement('div');
        cardBody.className = 'card-body p-2';

        const title = document.createElement('div');
        title.className = 'fw-semibold small text-truncate';
        title.textContent = imageTitle;

        const details = document.createElement('small');
        details.className = 'text-muted d-block text-truncate';
        details.textContent = mediaItem.size ? formatFileSize(mediaItem.size) : getImageFileName(imageUrl);

        const selectText = document.createElement('small');
        selectText.className = 'text-primary fw-semibold d-block mt-1';
        selectText.textContent = 'Select image';

        cardBody.appendChild(title);
        cardBody.appendChild(details);
        cardBody.appendChild(selectText);
        button.appendChild(image);
        button.appendChild(cardBody);
        column.appendChild(button);
        imageGrid.appendChild(column);
    });
}

function selectImagePath(imagePath) {
    if (currentImageInput) {
        const inputElement = document.getElementById(currentImageInput);
        if (inputElement) {
            inputElement.value = imagePath;
            inputElement.dispatchEvent(new Event('input', { bubbles: true }));
            inputElement.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }

    const modal = bootstrap.Modal.getInstance(document.getElementById('imageModal'));
    if (modal) {
        modal.hide();
    }
}

// Optional: Function to add custom image paths dynamically
function addCustomImagePath(imagePath) {
    cachedSelectableMedia = cachedSelectableMedia || [];
    cachedSelectableMedia.unshift({
        url: imagePath,
        title: getImageFileName(imagePath),
        filename: getImageFileName(imagePath)
    });
    renderSelectableMedia(cachedSelectableMedia);
}

function setImagePickerStatus(html) {
    document.getElementById('imagePickerStatus').innerHTML = html;
}

function getImageFileName(imagePath) {
    return imagePath ? imagePath.split('/').pop() : '';
}

function formatFileSize(bytes) {
    const size = Number(bytes);

    if (!size) {
        return '';
    }

    if (size >= 1073741824) {
        return `${(size / 1073741824).toFixed(2)} GB`;
    }

    if (size >= 1048576) {
        return `${(size / 1048576).toFixed(2)} MB`;
    }

    if (size >= 1024) {
        return `${(size / 1024).toFixed(2)} KB`;
    }

    return `${size} bytes`;
}
</script>
