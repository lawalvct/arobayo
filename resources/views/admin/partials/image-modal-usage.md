# How to Use the Image Selection Modal Partial

To add the reusable image selection modal to any admin page, follow these steps:

## 1. Include the Partial

Add this line anywhere in your Blade template (usually after your main form or at the bottom of the page):

```blade
{{-- In any admin page that needs image selection --}}
@include('admin.partials.image-modal')
```

## 2. Add the Image Input to Your Form

Use the following markup for any image input field that should trigger the modal:

```blade
<div class="input-group">
    <input type="text" class="form-control" name="image" id="myImageInput">
    <button type="button" class="btn btn-outline-secondary" onclick="selectImage('myImageInput')">
        <i class="fas fa-image"></i>
    </button>
</div>
```

-   Replace `myImageInput` with the actual ID of your input field if needed.
-   The `selectImage` function will open the modal and allow the user to pick an image, which will be inserted into the input field.

## Example Usage

```blade
<form>
    ...existing code...
    <div class="input-group">
        <input type="text" class="form-control" name="image" id="myImageInput">
        <button type="button" class="btn btn-outline-secondary" onclick="selectImage('myImageInput')">
            <i class="fas fa-image"></i>
        </button>
    </div>
    ...existing code...
</form>

@include('admin.partials.image-modal')
```

## Notes

-   You can use the modal in multiple places on the same page.
-   The modal and its JavaScript are fully reusable and will work with any input field you specify.
-   Make sure the partial is included only once per page.
