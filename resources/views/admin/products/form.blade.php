@extends('layouts.admin')
@section('content')
<div class="page-header">
    <h1>
        <i class="fas fa-box"></i>
        {{ $product->exists ? 'Sửa sản phẩm' : 'Thêm sản phẩm mới' }}
    </h1>
</div>

<div class="card">
    <form method="post" action="{{ $product->exists ? route('admin.products.update',$product) : route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        @if($product->exists)
        @method('PUT')
        @endif

        <div class="form-group">
            <label>Tên sản phẩm *</label>
            <input
                type="text"
                name="name"
                value="{{ old('name',$product->name) }}"
                placeholder="Nhập tên sản phẩm"
                required>
            @error('name')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>


        <div class="form-group">
            <label>Danh mục</label>
            <select name="category_id">
                <option value="">-- Chọn danh mục --</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id',$product->category_id)==$category->id)>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>


        <div class="form-group">
            <label>Giá *</label>
            <input
                type="number"
                step="0.01"
                name="price"
                value="{{ old('price',$product->price) }}"
                placeholder="0"
                required>
            @error('price')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>


        <div class="form-group">
            <label for="quillEditor">Mô tả</label>
            <textarea id="productDescription" name="description" rows="6" style="display:none;">{{ old('description',$product->description) }}</textarea>
            <div id="quillEditor" tabindex="0" role="textbox" aria-label="Trình soạn thảo mô tả sản phẩm" style="min-height:220px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; cursor: text; z-index: 1;"></div>
            <small style="color: #718096; font-size: 12px; display: block; margin-top: 8px;">
                Sử dụng trình soạn thảo Quill tự lưu trữ. Nội dung sẽ được lưu dưới dạng HTML.
            </small>
            @error('description')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <!-- WYSIWYG editor will be initialized for the description field -->

        <!-- Images Section -->
        <div style="border-top: 2px solid #e2e8f0; padding-top: 24px; margin-top: 24px;">
            <h3 style="margin-bottom: 20px; color: #1a202c; font-size: 16px;">
                <i class="fas fa-images"></i> Ảnh sản phẩm
            </h3>

            <div class="form-group">
                <label>Tải ảnh lên</label>
                <div id="dropZone" style="border: 2px dashed #cbd5e0; border-radius: 14px; padding: 36px 24px; text-align: center; background: linear-gradient(180deg, #f8fafc 0%, #edf2f7 100%); cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 42px; color: #48bb78; margin-bottom: 12px; display: block;"></i>
                    <p style="margin: 0; color: #2d3748; font-weight: 600; font-size: 15px;">
                        Bấm để tải lên hoặc kéo thả vào đây
                    </p>
                    <p style="margin: 6px 0 0 0; color: #718096; font-size: 13px;">
                        PNG, JPG, GIF tối đa 5MB mỗi ảnh
                    </p>
                    <input
                        type="file"
                        name="images_upload[]"
                        id="imageUpload"
                        multiple
                        accept="image/*"
                        style="display: none;">
                </div>
                @error('images_upload')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
                @error('images_upload.*')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
            </div>

            <div id="imagePreview" style="margin-top: 20px; display: grid; gap: 24px;">
                @if($product->images && count($product->images) > 0)
                <div>
                    <h4 style="color: #2d3748; margin-bottom: 12px; font-size: 14px; font-weight: 600;">
                        Ảnh hiện tại
                    </h4>
                    <div id="existingImagesGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 16px;">
                        @foreach($product->images as $image)
                        <div class="image-card" data-existing-image="{{ $image }}" style="position: relative; border-radius: 14px; overflow: hidden; background: white; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);">
                            <div style="aspect-ratio: 1; background: #edf2f7;">
                                <img src="{{ $image }}" alt="Ảnh sản phẩm" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            </div>
                            <div style="padding: 10px 12px; display: flex; justify-content: space-between; align-items: center; gap: 8px;">
                                <span style="font-size: 12px; color: #718096; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Ảnh đã lưu</span>
                                <button type="button" onclick="removeImage(this)" data-image="{{ urlencode($image) }}" style="border: none; background: #fed7d7; color: #c53030; width: 28px; height: 28px; border-radius: 999px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div>
                    <h4 style="color: #2d3748; margin-bottom: 12px; font-size: 14px; font-weight: 600;">
                        Ảnh tải lên mới
                    </h4>
                    <div id="newImagesPreview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 16px;"></div>
                    <p id="uploadHint" style="color: #718096; font-size: 13px; margin-top: 10px;">Chưa chọn tệp mới nào.</p>
                </div>
            </div>

            <div class="form-group" style="margin-top: 24px;">
                <label>Thêm ảnh bằng URL</label>
                <textarea
                    name="images_text"
                    rows="4"
                    placeholder="https://example.com/image1.jpg&#10;https://example.com/image2.jpg&#10;mỗi dòng một URL">{{ old('images_text', implode("\n", $product->images ?? [])) }}</textarea>
                <small style="color: #718096; font-size: 12px; display: block; margin-top: 8px;">
                    <i class="fas fa-info-circle"></i> Nhập URL ảnh, mỗi dòng một URL. Các ảnh này sẽ được gộp với ảnh tải lên.
                </small>
                @error('images_text')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input
                    type="checkbox"
                    name="is_featured"
                    id="is_featured"
                    value="1"
                    @checked(old('is_featured',$product->is_featured))
                >
                <label for="is_featured">Sản phẩm nổi bật</label>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input
                    type="checkbox"
                    name="is_active"
                    id="is_active"
                    value="1"
                    @checked(old('is_active',$product->exists ? $product->is_active : true))
                >
                <label for="is_active">Đang hoạt động</label>
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 32px;">
            <button type="submit" class="btn">
                <i class="fas fa-save"></i>
                {{ $product->exists ? 'Cập nhật sản phẩm' : 'Tạo sản phẩm' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                <i class="fas fa-times"></i>
                Hủy
            </a>
        </div>
    </form>
</div>

<script>
    let uploadedFiles = [];

    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZone');
        const imageUpload = document.getElementById('imageUpload');
        const imagePreview = document.getElementById('newImagesPreview');
        const uploadHint = document.getElementById('uploadHint');


        // Click to upload
        dropZone.addEventListener('click', () => imageUpload.click());

        // Drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            imageUpload.files = files;
            handleFiles(files);
        }

        imageUpload.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            uploadedFiles = Array.from(files);
            renderUploadPreview();
        }

        function renderUploadPreview() {
            imagePreview.innerHTML = '';
            uploadHint.style.display = uploadedFiles.length ? 'none' : 'block';

            uploadedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'image-card';
                    div.style.cssText = 'position: relative; border-radius: 14px; overflow: hidden; background: white; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);';
                    div.innerHTML = `
                        <div style="aspect-ratio: 1; background: #edf2f7;">
                            <img src="${e.target.result}" alt="Ảnh xem trước" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        </div>
                        <div style="padding: 10px 12px; display: flex; justify-content: space-between; align-items: center; gap: 8px;">
                            <span style="font-size: 12px; color: #718096; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${file.name}</span>
                            <button type="button" onclick="removeUpload(${index})" style="border: none; background: #fed7d7; color: #c53030; width: 28px; height: 28px; border-radius: 999px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    imagePreview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        window.renderUploadPreview = renderUploadPreview;
    });

    window.removeUpload = function(index) {
        uploadedFiles.splice(index, 1);
        const fileInput = document.getElementById('imageUpload');
        const dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
        window.renderUploadPreview();
    }

    window.removeImage = function(element) {
        if (confirm('Remove this image?')) {
            const image = element.dataset.image;
            const textarea = document.querySelector('textarea[name="images_text"]');
            let images = textarea.value.split('\n').filter(img => img.trim() !== '');
            images = images.filter(img => encodeURIComponent(img) !== image);
            textarea.value = images.join('\n');
            const card = element.closest('.image-card');
            if (card) {
                card.remove();
            }
        }
    }
</script>

<!-- Quill editor (free, no API key) -->
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const descriptionTextarea = document.getElementById('productDescription');
        const quillEditorDiv = document.getElementById('quillEditor');

        const quill = new Quill('#quillEditor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'header': 1
                    }, {
                        'header': 2
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['link', 'image', 'clean']
                ]
            }
        });

        const syncDescription = function() {
            if (descriptionTextarea) {
                descriptionTextarea.value = quill.root.innerHTML;
            }
        };

        if (descriptionTextarea && descriptionTextarea.value) {
            quill.clipboard.dangerouslyPasteHTML(descriptionTextarea.value);
        }

        quill.on('text-change', syncDescription);
        syncDescription();

        // On submit, copy editor HTML to the hidden textarea
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function() {
                syncDescription();
            });
        }

        // Improve focus UX: focus quill when its container or label is clicked
        if (quillEditorDiv) {
            quillEditorDiv.addEventListener('click', function() {
                quill.focus();
            });
            quillEditorDiv.addEventListener('focus', function() {
                quill.focus();
            });
        }
        const label = document.querySelector('label[for="quillEditor"]');
        if (label && quillEditorDiv) {
            label.addEventListener('click', function(e) {
                e.preventDefault();
                quill.focus();
            });
        }
    });
</script>

<style>
    /* Visual focus style for Quill editor */
    #quillEditor:focus {
        outline: none;
        box-shadow: 0 0 0 4px rgba(66, 153, 225, 0.15);
        border-color: #63b3ed;
    }
</style>
@endsection
