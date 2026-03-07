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
                            <li><strong>Image 2 (Current):</strong> This is the latest scan to be compared against the reference image.</li>
                            <li>Ensure both images are in <strong>PNG or JPG</strong> format (Max <strong>9MB</strong> per file).</li>
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
                                                <div class="small text-muted">PNG, JPG (Max 9MB)</div>
                                                <div class="btn btn-outline-primary mt-3 px-5">BROWSE</div>
                                            </label>
                                        </div>
                                        <input type="file" name="images[]" id="image1" class="file-input" accept="image/*" style="opacity: 0; position: absolute; top:0; left:0; width:100%; height:100%; cursor:pointer;">
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
                                                <div class="small text-muted">PNG, JPG (Max 9MB)</div>
                                                <div class="btn btn-outline-primary mt-3 px-5">BROWSE</div>
                                            </label>
                                        </div>
                                        <input type="file" name="images[]" id="image2" class="file-input" accept=".png, .jpg, .jpeg" style="opacity: 0; position: absolute; top:0; left:0; width:100%; height:100%; cursor:pointer;">
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button class="btn btn-dark" type="submit" style="padding:12px 6rem; border-radius: 8px; font-weight: bold;">
                                    Submit
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
        
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });

        // NOTE: crypto.subtle.digest() only works over HTTPS (secure context).
        // Once you add HTTPS to your server, you can replace this entire function with:
        //
        //   async function getFileHash(file) {
        //       const arrayBuffer = await file.arrayBuffer();
        //       const hashBuffer = await crypto.subtle.digest('SHA-256', arrayBuffer);
        //       const hashArray = Array.from(new Uint8Array(hashBuffer));
        //       return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        //   }
        //
        // For now, we use a pure-JS SHA-256 that works on both HTTP and HTTPS.
        async function getFileHash(file) {
            const arrayBuffer = await file.arrayBuffer();
            const bytes = new Uint8Array(arrayBuffer);

            // Pure-JS SHA-256 (no Web Crypto API required)
            function sha256(data) {
                const K = [
                    0x428a2f98,0x71374491,0xb5c0fbcf,0xe9b5dba5,0x3956c25b,0x59f111f1,0x923f82a4,0xab1c5ed5,
                    0xd807aa98,0x12835b01,0x243185be,0x550c7dc3,0x72be5d74,0x80deb1fe,0x9bdc06a7,0xc19bf174,
                    0xe49b69c1,0xefbe4786,0x0fc19dc6,0x240ca1cc,0x2de92c6f,0x4a7484aa,0x5cb0a9dc,0x76f988da,
                    0x983e5152,0xa831c66d,0xb00327c8,0xbf597fc7,0xc6e00bf3,0xd5a79147,0x06ca6351,0x14292967,
                    0x27b70a85,0x2e1b2138,0x4d2c6dfc,0x53380d13,0x650a7354,0x766a0abb,0x81c2c92e,0x92722c85,
                    0xa2bfe8a1,0xa81a664b,0xc24b8b70,0xc76c51a3,0xd192e819,0xd6990624,0xf40e3585,0x106aa070,
                    0x19a4c116,0x1e376c08,0x2748774c,0x34b0bcb5,0x391c0cb3,0x4ed8aa4a,0x5b9cca4f,0x682e6ff3,
                    0x748f82ee,0x78a5636f,0x84c87814,0x8cc70208,0x90befffa,0xa4506ceb,0xbef9a3f7,0xc67178f2
                ];
                let h = [0x6a09e667,0xbb67ae85,0x3c6ef372,0xa54ff53a,0x510e527f,0x9b05688c,0x1f83d9ab,0x5be0cd19];
                const r = (x, n) => (x >>> n) | (x << (32 - n));
                const msgLen = data.length;
                const bitLen = msgLen * 8;
                const padded = new Uint8Array(((msgLen + 9 + 63) & ~63));
                padded.set(data);
                padded[msgLen] = 0x80;
                const dv = new DataView(padded.buffer);
                dv.setUint32(padded.length - 4, bitLen & 0xffffffff, false);
                dv.setUint32(padded.length - 8, Math.floor(bitLen / 0x100000000), false);
                for (let i = 0; i < padded.length; i += 64) {
                    const w = new Array(64);
                    for (let j = 0; j < 16; j++) w[j] = dv.getUint32(i + j * 4, false);
                    for (let j = 16; j < 64; j++) {
                        const s0 = r(w[j-15], 7) ^ r(w[j-15], 18) ^ (w[j-15] >>> 3);
                        const s1 = r(w[j-2], 17) ^ r(w[j-2], 19) ^ (w[j-2] >>> 10);
                        w[j] = (w[j-16] + s0 + w[j-7] + s1) >>> 0;
                    }
                    let [a,b,c,d,e,f,g,hh] = h;
                    for (let j = 0; j < 64; j++) {
                        const S1 = r(e,6)^r(e,11)^r(e,25);
                        const ch = (e&f)^(~e&g);
                        const temp1 = (hh + S1 + ch + K[j] + w[j]) >>> 0;
                        const S0 = r(a,2)^r(a,13)^r(a,22);
                        const maj = (a&b)^(a&c)^(b&c);
                        const temp2 = (S0 + maj) >>> 0;
                        hh=g; g=f; f=e; e=(d+temp1)>>>0; d=c; c=b; b=a; a=(temp1+temp2)>>>0;
                    }
                    h[0]=(h[0]+a)>>>0; h[1]=(h[1]+b)>>>0; h[2]=(h[2]+c)>>>0; h[3]=(h[3]+d)>>>0;
                    h[4]=(h[4]+e)>>>0; h[5]=(h[5]+f)>>>0; h[6]=(h[6]+g)>>>0; h[7]=(h[7]+hh)>>>0;
                }
                return h.map(v => v.toString(16).padStart(8, '0')).join('');
            }

            return sha256(bytes);
        }

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        function handleFileSelect(input, slotNum) {
            const file = input.files[0];
            const preview = document.getElementById(`preview-${slotNum}`);
            const placeholder = document.getElementById(`placeholder-${slotNum}`);
            const removeBtn = document.getElementById(`remove-${slotNum}`);
            const nameLabel = document.getElementById(`display-name-${slotNum}`);
            const sizeLabel = document.getElementById(`file-size-${slotNum}`);
            const slot = document.getElementById(`slot-${slotNum}`);
            const zone = document.getElementById(`zone-${slotNum}`);

            if (file) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File Type',
                        text: 'Please upload only PNG, JPG, or JPEG images.',
                        confirmButtonColor: '#d33'
                    });
                    input.value = "";
                    return;
                }
                if (file.size > maxSize) {
                    Swal.fire({ icon: 'error', title: 'File Too Large', text: 'Please select a file smaller than 9MB.' });
                    input.value = "";
                    return;
                }
                zone.classList.remove('is-invalid-zone');
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    nameLabel.textContent = file.name;
                    nameLabel.style.display = 'block';
                    sizeLabel.textContent = formatBytes(file.size);
                    sizeLabel.style.display = 'block';
                    placeholder.style.display = 'none';
                    removeBtn.style.display = 'block';
                    if (slotNum === 1) {
                        slot.classList.replace('col-12', 'col-md-6');
                        document.getElementById('slot-2').classList.remove('d-none');
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        function resetSlot(slotNum) {
            const input = document.getElementById(`image${slotNum}`);
            const preview = document.getElementById(`preview-${slotNum}`);
            const placeholder = document.getElementById(`placeholder-${slotNum}`);
            const removeBtn = document.getElementById(`remove-${slotNum}`);
            const nameLabel = document.getElementById(`display-name-${slotNum}`);
            const sizeLabel = document.getElementById(`file-size-${slotNum}`);
            const zone = document.getElementById(`zone-${slotNum}`);

            input.value = "";
            preview.src = "";
            preview.style.display = 'none';
            nameLabel.textContent = "";
            nameLabel.style.display = 'none';
            sizeLabel.textContent = "";
            sizeLabel.style.display = 'none';
            placeholder.style.display = 'block';
            removeBtn.style.display = 'none';
            zone.classList.remove('is-invalid-zone');

            if (slotNum === 1) {
                document.getElementById('slot-1').classList.replace('col-md-6', 'col-12');
                document.getElementById('slot-2').classList.add('d-none');
                resetSlot(2);
            }
        }

        document.getElementById('image1').addEventListener('change', function() { handleFileSelect(this, 1); });
        document.getElementById('image2').addEventListener('change', function() { handleFileSelect(this, 2); });
        document.getElementById('remove-1').addEventListener('click', (e) => { e.stopPropagation(); resetSlot(1); });
        document.getElementById('remove-2').addEventListener('click', (e) => { e.stopPropagation(); resetSlot(2); });

        document.getElementById('upload-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const input1 = document.getElementById('image1');
            const input2 = document.getElementById('image2');
            
            if (input1.files.length === 0 || input2.files.length === 0) {
                if (input1.files.length === 0) document.getElementById('zone-1').classList.add('is-invalid-zone');
                if (input2.files.length === 0) document.getElementById('zone-2').classList.add('is-invalid-zone');

                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Information',
                    text: 'Please upload images in both slots before submitting.',
                    confirmButtonColor: '#212529'
                });
                return;
            }

            Swal.fire({
                title: 'Verifying Data...',
                text: 'Please wait while we check your files.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            try {
                const hash1 = await getFileHash(input1.files[0]);
                const hash2 = await getFileHash(input2.files[0]);

                if (hash1 === hash2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Images Detected',
                        text: 'You cannot use the same image for both slots. Please select different images.',
                        confirmButtonColor: '#d33'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Uploading...',
                    text: 'Redirecting to ROI processing page, please wait.',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                
                this.submit();

            } catch (error) {
                console.error(error);
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Process Failed', 
                    text: 'Could not verify files. Please try again.' 
                });
            }
        });
    </script>
</x-app-layout>