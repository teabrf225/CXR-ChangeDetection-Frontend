<x-app-layout>
    <style>
        .transition-all { transition: all 0.5s ease; }
        .drop-zone { 
            position: relative; height: 280px; display: flex; flex-direction: column;
            align-items: center; justify-content: center; overflow: hidden; 
            background-color: #f8f9fa; border: 2px dashed #ccc;
        }
        .preview-img { max-height: 180px; width: auto; max-width: 100%; object-fit: contain; display: none; border-radius: 5px; margin-bottom: 8px; }
        .file-name-label { font-size: 0.85rem; color: #555; max-width: 90%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: none; }
        .btn-remove { position: absolute; top: 10px; right: 10px; z-index: 10; display: none; border-radius: 50%; width: 28px; height: 28px; padding: 0; }
        .is-invalid-zone { border-color: #dc3545 !important; background-color: #fff5f5; }
    </style>

    <div class="py-12">
        <div class="container">
            
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="mb-4 p-4 warning-card rounded-lg shadow-sm">
                        <div class="d-flex align-items-center">
                            <svg class="me-2" width="20" height="20" fill="#ed8936" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <strong style="color: #9c4221;">Important Medical Disclaimer</strong>
                        </div>
                        <p class="mt-2 mb-0" style="font-size: 0.9rem; color: #4a5568;">
                            The uploaded images will be processed by our AI model. Please note that the analysis results are intended for <strong>decision support only</strong> and should not be used as a standalone medical diagnosis.
                        </p>
                    </div>

                    <div class="mb-1 p-6 instruction-card rounded-lg shadow-sm">
                        <h2 class="text-xl font-bold mb-4" style="font-size: 1.5rem; color: #2d3748;">How to upload Chest X-Ray images</h2>
                        <ul class="ml-5 space-y-2" style="list-style-type: decimal; color: #4a5568; line-height: 1.6;">
                            <li>Please upload <strong>two distinct</strong> Chest X-Ray images for comparison.</li>
                            <li><strong>Image 1 (Reference):</strong> This must be the earlier scan (past record) used as the baseline.</li>
                            <li><strong>Image 2 (Target):</strong> This is the latest scan to be compared against the reference image.</li>
                            <li>Ensure both images are in <strong>PNG, JPG or JPEG</strong> format (Max <strong>9MB</strong> per file).</li>
                            <li>Verify that the images are clear and correctly oriented for the best analysis results.</li>
                        </ul>
                    </div>

                    <div class="row justify-content-center mt-4">
                        <div class="col-12 col-lg-10 px-my-4">
                            @if(session('error'))
                                <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger shadow-sm">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card p-4 shadow-sm border-0">
                        <form id="upload-form" action="{{ route('upload.images.process') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div id="slots-container" class="row justify-content-center g-3">
                                <div id="slot-1" class="col-12 transition-all">
                                    <div class="drop-zone rounded p-3 text-center" id="zone-1">
                                        <button type="button" class="btn-remove btn btn-danger" id="remove-1">✕</button>
                                        <img id="preview-1" src="" class="preview-img">
                                        <div id="display-name-1" class="file-name-label fw-bold"></div>
                                        <div id="file-size-1" class="small text-muted" style="display: none;"></div>
                                        <div id="placeholder-1">
                                            <label for="image1" class="d-block mb-0" style="cursor:pointer;">
                                                <img src="{{ asset('images/upload_clone_icon.png') }}" class="rounded mx-auto d-block" style="max-height: 3.5rem;">
                                                <div class="fs-5 fw-bold mt-2">Upload Image 1</div>
                                                <div class="small text-muted">PNG, JPG or JPEG (Max 9MB)</div>
                                                <div class="btn btn-outline-primary mt-3 px-5">BROWSE</div>
                                            </label>
                                        </div>
                                        <input type="file" name="images[]" id="image1" class="file-input" accept=".png, .jpg, .jpeg" style="opacity: 0; position: absolute; top:0; left:0; width:100%; height:100%; cursor:pointer;">
                                    </div>
                                </div>

                                <div id="slot-2" class="col-md-6 d-none transition-all">
                                    <div class="drop-zone rounded p-3 text-center" id="zone-2">
                                        <button type="button" class="btn-remove btn btn-danger" id="remove-2">✕</button>
                                        <img id="preview-2" src="" class="preview-img">
                                        <div id="display-name-2" class="file-name-label fw-bold"></div>
                                        <div id="file-size-2" class="small text-muted" style="display: none;"></div>
                                        <div id="placeholder-2">
                                            <label for="image2" class="d-block mb-0" style="cursor:pointer;">
                                                <img src="{{ asset('images/upload_clone_icon.png') }}" class="rounded mx-auto d-block" style="max-height: 3.5rem;">
                                                <div class="fs-5 fw-bold mt-2">Upload Image 2</div>
                                                <div class="small text-muted">PNG, JPG or JPEG (Max 9MB)</div>
                                                <div class="btn btn-outline-primary mt-3 px-5">BROWSE</div>
                                            </label>
                                        </div>
                                        <input type="file" name="images[]" id="image2" class="file-input" accept=".png, .jpg, .jpeg" style="opacity: 0; position: absolute; top:0; left:0; width:100%; height:100%; cursor:pointer;">
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button class="btn btn-dark" type="submit" style="padding:12px 6rem; border-radius: 8px; font-weight: bold;">
                                    Start Analysis
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const maxSize = 9 * 1024 * 1024;
        
        // Anti-back cache reload
        window.addEventListener('pageshow', (e) => { 
            if (e.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.reload(); 
            }
        });

        async function getFileIdentity(file) {
            if (window.isSecureContext && window.crypto && window.crypto.subtle) {
                try {
                    const arrayBuffer = await file.arrayBuffer();
                    const hashBuffer = await window.crypto.subtle.digest('SHA-256', arrayBuffer);
                    const hashArray = Array.from(new Uint8Array(hashBuffer));
                    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
                } catch (e) {
                    console.warn("Crypto failed, using metadata fallback.");
                }
            }
            return `fb_${file.name}_${file.size}_${file.lastModified}`;
        }

        function formatBytes(bytes) {
            if (bytes === 0) return '0 Bytes';
            const i = Math.floor(Math.log(bytes) / Math.log(1024));
            const sizes = ['Bytes', 'KB', 'MB'];
            return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
        }

        async function handleFileSelect(input, slotNum) {
            const file = input.files[0];
            if (!file) return;

            // Validation: Type & Size
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({ icon: 'error', title: 'Invalid Format', text: 'Please upload JPG or PNG.' });
                input.value = ""; return;
            }
            if (file.size > maxSize) {
                Swal.fire({ icon: 'error', title: 'File Too Large', text: 'Max 9MB per image.' });
                input.value = ""; return;
            }

            // Preview UI Update
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = document.getElementById(`preview-${slotNum}`);
                preview.src = e.target.result;
                preview.style.display = 'block';
                
                document.getElementById(`display-name-${slotNum}`).textContent = file.name;
                document.getElementById(`display-name-${slotNum}`).style.display = 'block';
                
                document.getElementById(`file-size-${slotNum}`).textContent = formatBytes(file.size);
                document.getElementById(`file-size-${slotNum}`).style.display = 'block';
                
                document.getElementById(`placeholder-${slotNum}`).style.display = 'none';
                document.getElementById(`remove-${slotNum}`).style.display = 'block';
                document.getElementById(`zone-${slotNum}`).classList.remove('is-invalid-zone');

                // Dynamic Slot Transition
                if (slotNum === 1) {
                    const s1 = document.getElementById('slot-1');
                    const s2 = document.getElementById('slot-2');
                    s1.classList.replace('col-12', 'col-md-6');
                    s2.classList.remove('d-none');
                }
            };
            reader.readAsDataURL(file);
        }

        function resetSlot(slotNum) {
            const input = document.getElementById(`image${slotNum}`);
            input.value = "";
            
            document.getElementById(`preview-${slotNum}`).style.display = 'none';
            document.getElementById(`preview-${slotNum}`).src = "";
            document.getElementById(`display-name-${slotNum}`).style.display = 'none';
            document.getElementById(`file-size-${slotNum}`).style.display = 'none';
            
            document.getElementById(`placeholder-${slotNum}`).style.display = 'block';
            document.getElementById(`remove-${slotNum}`).style.display = 'none';
            document.getElementById(`zone-${slotNum}`).classList.remove('is-invalid-zone');

            if (slotNum === 1) {
                document.getElementById('slot-1').classList.replace('col-md-6', 'col-12');
                document.getElementById('slot-2').classList.add('d-none');
                resetSlot(2);
            }
        }

        // Event Listeners
        document.getElementById('image1').addEventListener('change', function() { handleFileSelect(this, 1); });
        document.getElementById('image2').addEventListener('change', function() { handleFileSelect(this, 2); });
        document.getElementById('remove-1').addEventListener('click', (e) => { e.stopPropagation(); resetSlot(1); });
        document.getElementById('remove-2').addEventListener('click', (e) => { e.stopPropagation(); resetSlot(2); });

        // Submit with Final Verification
        document.getElementById('upload-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const input1 = document.getElementById('image1');
            const input2 = document.getElementById('image2');

            if (!input1.files[0] || !input2.files[0]) {
                if (!input1.files[0]) document.getElementById('zone-1').classList.add('is-invalid-zone');
                if (!input2.files[0]) document.getElementById('zone-2').classList.add('is-invalid-zone');
                Swal.fire({ icon: 'warning', title: 'Incomplete', text: 'Please upload both Reference and Target images.' });
                return;
            }

            Swal.fire({ 
                title: 'Verifying Images...', 
                allowOutsideClick: false, 
                didOpen: () => Swal.showLoading() 
            });

            try {
                const id1 = await getFileIdentity(input1.files[0]);
                const id2 = await getFileIdentity(input2.files[0]);

                if (id1 === id2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Detected',
                        text: 'Reference and Target images cannot be the same file.',
                    });
                    return;
                }
                this.submit();
            } catch (error) {
                this.submit();
            }
        });
    </script>
</x-app-layout>