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
            <div class="row justify-content-md-center">
                <div class="col col-lg-6 my-3 alert alert-warning text-center" role="alert">
                    <strong>รูปที่ส่งให้โมเดล ผลลัพธ์ที่ได้ใช้เพื่อประกอบการตัดสินใจเท่านั้น</strong>
                </div>
            </div>
            <div class="card m-md-4 p-4 shadow-sm">
                <form id="upload-form" action="#" method="post" enctype="multipart/form-data">
                    @csrf
                    <div id="slots-container" class="row justify-content-center g-3">
                        <div id="slot-1" class="col-12 transition-all">
                            <div class="drop-zone rounded p-3 text-center" id="zone-1">
                                <button type="button" class="btn-remove btn btn-danger" id="remove-1">✕</button>
                                <img id="preview-1" src="" class="preview-img">
                                <div id="display-name-1" class="file-name-label fw-bold"></div>
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
                                <div id="placeholder-2">
                                    <label for="image2" class="d-block mb-0" style="cursor:pointer;">
                                        <img src="{{ asset('images/upload_clone_icon.png') }}" class="rounded mx-auto d-block" style="max-height: 3.5rem;">
                                        <div class="fs-5 fw-bold mt-2">Upload Image 2</div>
                                        <div class="small text-muted">PNG, JPG (Max 9MB)</div>
                                        <div class="btn btn-outline-primary mt-3 px-5">BROWSE</div>
                                    </label>
                                </div>
                                <input type="file" name="images[]" id="image2" class="file-input" accept="image/*" style="opacity: 0; position: absolute; top:0; left:0; width:100%; height:100%; cursor:pointer;">
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-dark" type="submit" style="padding:12px 6rem; border-radius: 8px; font-weight: bold;">
                            Submit Both Images
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const maxSize = 9 * 1024 * 1024;

        async function getFileHash(file) {
            const arrayBuffer = await file.arrayBuffer();
            const hashBuffer = await crypto.subtle.digest('SHA-256', arrayBuffer);
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        }

        function handleFileSelect(input, slotNum) {
            const file = input.files[0];
            const preview = document.getElementById(`preview-${slotNum}`);
            const placeholder = document.getElementById(`placeholder-${slotNum}`);
            const removeBtn = document.getElementById(`remove-${slotNum}`);
            const nameLabel = document.getElementById(`display-name-${slotNum}`);
            const slot = document.getElementById(`slot-${slotNum}`);
            const zone = document.getElementById(`zone-${slotNum}`);

            if (file) {
                if (file.size > maxSize) {
                    Swal.fire({ icon: 'error', title: 'ไฟล์ใหญ่เกินไป', text: 'กรุณาเลือกไฟล์ขนาดไม่เกิน 9MB' });
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
            const zone = document.getElementById(`zone-${slotNum}`);

            input.value = "";
            preview.src = "";
            preview.style.display = 'none';
            nameLabel.textContent = "";
            nameLabel.style.display = 'none';
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
                    title: 'ข้อมูลไม่ครบถ้วน',
                    text: 'กรุณาอัปโหลดรูปภาพให้ครบทั้ง 2 ช่อง',
                    confirmButtonColor: '#212529'
                });
                return;
            }

            Swal.fire({
                title: 'กำลังตรวจสอบข้อมูล...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            try {
                const hash1 = await getFileHash(input1.files[0]);
                const hash2 = await getFileHash(input2.files[0]);

                if (hash1 === hash2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'รูปภาพซ้ำกัน',
                        text: 'คุณไม่สามารถใช้รูปภาพเดียวกันทั้ง 2 ช่องได้ กรุณาเลือกรูปที่ต่างกัน',
                        confirmButtonColor: '#d33'
                    });
                    return;
                }

                Swal.fire({
                    title: 'กำลังอัปโหลด...',
                    text: 'กรุณารอสักครู่ขณะนี้ระบบส่งรูปภาพไปยังหน้า ROI',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                document.getElementById('upload-form').submit();

            } catch (error) {
                console.error(error);
                Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'ไม่สามารถตรวจสอบไฟล์ได้ กรุณาลองใหม่อีกครั้ง' });
            }
        });
    </script>
</x-app-layout>