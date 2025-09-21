@props(['message' => session('success'), 'documentsUploaded' => session('documents_uploaded', false)])

@if($message)
<!-- Success Modal Component -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header bg-success text-white border-0" style="border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold" id="successModalLabel">
                    <i class="fas fa-check-circle me-2"></i>
                    Registration Successful
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <div class="mx-auto mb-3" style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                        <i class="fas fa-user-check text-success" style="font-size: 40px;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Thank You!</h4>
                    <p class="text-muted mb-0">{{ $message }}</p>
                </div>

                @if($documentsUploaded)
                <div class="alert alert-info" role="alert">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-file-upload text-primary" style="font-size: 24px;"></i>
                        </div>
                        <div class="text-start">
                            <h6 class="fw-bold mb-1">Documents Received</h6>
                            <p class="mb-0 small">Your documents have been uploaded successfully and will be reviewed by our team.</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="alert alert-light border mt-3 text-start">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-info-circle text-primary" style="font-size: 24px;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">What's Next?</h6>
                            <p class="mb-0 small">Our team will review your registration and contact you within 2-3 business days. Check your email for updates.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-primary px-4 py-2" data-bs-dismiss="modal">
                    <i class="fas fa-check me-2"></i>
                    Got it
                </button>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2">
                    <i class="fas fa-home me-2"></i>
                    Return to Home
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Auto-display script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    console.log('Success modal component loaded');
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
});
</script>
@endif
