<x-app-layout>
    <style>
        .result-zone { 
            position: relative; 
            min-height: 350; 
            aspect-ratio: 4 / 5;
            display: flex; 
            flex-direction: column;
            align-items: center; 
            justify-content: center; 
            overflow: hidden; 
            background-color: #f8f9fa; 
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0px;
        }

        .result-img { 
            width: 100%;
            height: 85%;
            object-fit: contain;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }
        .result-zone:hover .result-img {
            transform: scale(1.02);
        }

        .file-name-label { 
            font-size: 0.85rem; 
            color: #4a5568; 
            max-width: 95%; 
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis; 
            margin-top: 12px; 
            font-weight: 600;
            background: #edf2f7;
            padding: 2px 10px;
            border-radius: 20px;
        }
    </style>

    <div class="py-12">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-11">
                    
                    <div class="card p-3 shadow-sm border-0 rounded-lg bg-white">
                        <h1 class="fs-3 font-bold mb-4 text-center" style="color: #1a202c;">Analysis Comparison Result</h1>

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

                        <div class="row g-3 justify-content-center">
                            
                            <div class="col-12 col-md-4 text-center">
                                <div class="section-title text-primary">Reference</div>
                                <div class="result-zone shadow-sm">
                                    <img src="{{ session('image1_url', 'https://demofree.sirv.com/nope-not-here.jpg') }}" 
                                         class="result-img" id="reference_image">
                                </div>
                                <div class="file-name-label">
                                    {{ session('image1_filename', 'reference_image.jpg') }}
                                </div>
                            </div>

                            <div class="col-12 col-md-4 text-center">
                                <div class="section-title text-success">Target</div>
                                <div class="result-zone shadow-sm">
                                    <img src="{{ session('image2_url', 'https://demofree.sirv.com/nope-not-here.jpg') }}" 
                                         class="result-img" id="target_image">
                                </div>
                                <div class="file-name-label">
                                    {{ session('image2_filename', 'target_image.jpg') }}
                                </div>
                            </div>

                            <div class="col-12 col-md-4 text-center">
                                <div class="section-title text-danger">Change Map</div>
                                <div class="result-zone shadow-sm" style="background-color: #fff5f5; border-color: #feb2b2;">
                                    <img src="{{ session('image_change_map_url','https://demofree.sirv.com/nope-not-here.jpg') }}" 
                                         class="result-img" style="opacity: 0.8;" id="changemap_image">
                                    <div class="badge bg-danger position-absolute bottom-0 w-100 py-2" style="border-radius: 0;">
                                        CHANGE DETECTED
                                    </div>
                                </div>
                                <div class="small text-muted mt-2 italic">AI generated visual difference</div>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-5 pt-4 border-top">
                            
                            <a href="{{ route('upload-image.form') }}" class="btn btn-outline-secondary d-inline-flex align-items-center mb-3 mb-md-0" style="padding: 10px 2.5rem; border-radius: 8px; font-weight: 600;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                                <span>Back to Uploads</span>
                            </a>

                            <button id="download-zip" type="button" class="btn btn-dark d-inline-flex align-items-center" style="padding: 12px 4rem; border-radius: 8px; font-weight: bold; background-color: #212529;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-download me-2" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                </svg>
                                <span>Download</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('download-zip').addEventListener('click', async function() {
            Swal.fire({
                title: 'Preparing your files...',
                html: 'Please wait while we bundle your images.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            const zip = new JSZip();
            const images = [
                { id: 'reference_image', name: '01_reference' },
                { id: 'target_image', name: '02_target' },
                { id: 'changemap_image', name: '03_change_map' }
            ];

            let fileCount = 0;

            try {
                for (const imgObj of images) {
                    const el = document.getElementById(imgObj.id);
                    if (!el || !el.src) continue;

                    if (el.src.startsWith('data:image')) {
                        const parts = el.src.split(',');
                        const extension = parts[0].split(';')[0].split('/')[1] || 'jpg';
                        zip.file(`${imgObj.name}.${extension}`, parts[1], {base64: true});
                        fileCount++;
                    } else {
                        try {
                            const response = await fetch(el.src);
                            const blob = await response.blob();
                            const extension = blob.type.split('/')[1] || 'jpg';
                            zip.file(`${imgObj.name}.${extension}`, blob);
                            fileCount++;
                        } catch (e) { console.error(`Failed to fetch ${el.src}`, e); }
                    }
                }

                if (fileCount === 0) throw new Error("No images available");

                const content = await zip.generateAsync({type: "blob"});
                saveAs(content, `analysis-${new Date().getTime()}.zip`);

                Swal.fire({
                    icon: 'success',
                    title: 'Download Started!',
                    text: 'Your ZIP file has been generated successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });

            } catch (err) {
                console.error("Zip error:", err);
                Swal.fire({
                    icon: 'error',
                    title: 'Download Failed',
                    text: 'Could not generate ZIP file. Please try again.',
                });
            }
        });
    </script>
</x-app-layout>