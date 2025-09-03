<!-- Image Selection Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row" id="imageGrid">
                    <!-- Images will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentImageInput = null;

function selectImage(inputId) {
    currentImageInput = inputId;
    // In a real implementation, you would load images from the gallery
    // For now, we'll just show some sample paths
    const sampleImages = [
        '/images/slider/slide1.jpg',
        '/images/slider/slide2.jpg',
        '/images/slider/slide3.jpg',
        '/storage/uploads/slides/sample1.jpg',
        '/storage/uploads/slides/sample2.jpg',
        '/images/gallery/gallery1.jpg',
        '/images/gallery/gallery2.jpg',
        '/storage/uploads/gallery/image1.jpg',
        '/storage/uploads/gallery/image2.jpg',
        '/images/about/history.jpg'
    ];

    const imageGrid = document.getElementById('imageGrid');
    imageGrid.innerHTML = '';

    sampleImages.forEach(imagePath => {
        const imageHtml = `
            <div class="col-md-4 mb-3">
                <div class="card" style="cursor: pointer;" onclick="selectImagePath('${imagePath}')">
                    <img src="${imagePath}" class="card-img-top" alt="Image" style="height: 150px; object-fit: cover;" onerror="this.src='/images/placeholder.jpg'">
                    <div class="card-body p-2">
                        <small class="text-muted">${imagePath.split('/').pop()}</small>
                    </div>
                </div>
            </div>
        `;
        imageGrid.insertAdjacentHTML('beforeend', imageHtml);
    });

    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}

function selectImagePath(imagePath) {
    if (currentImageInput) {
        document.getElementById(currentImageInput).value = imagePath;

        // Trigger change event to update any preview images
        const inputElement = document.getElementById(currentImageInput);
        if (inputElement) {
            inputElement.dispatchEvent(new Event('change'));
        }
    }

    const modal = bootstrap.Modal.getInstance(document.getElementById('imageModal'));
    modal.hide();
}

// Optional: Function to add custom image paths dynamically
function addCustomImagePath(imagePath) {
    const imageGrid = document.getElementById('imageGrid');
    const imageHtml = `
        <div class="col-md-4 mb-3">
            <div class="card" style="cursor: pointer;" onclick="selectImagePath('${imagePath}')">
                <img src="${imagePath}" class="card-img-top" alt="Image" style="height: 150px; object-fit: cover;" onerror="this.src='/images/placeholder.jpg'">
                <div class="card-body p-2">
                    <small class="text-muted">${imagePath.split('/').pop()}</small>
                </div>
            </div>
        </div>
    `;
    imageGrid.insertAdjacentHTML('beforeend', imageHtml);
}
</script>
