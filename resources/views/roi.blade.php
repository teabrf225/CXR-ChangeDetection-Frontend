<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">

                <div class="mb-10 p-6 bg-gray-50 rounded-lg border-l-4 border-blue-500">
                    <h2 class="text-xl font-bold mb-4">How to set your ROI</h2>
                    <ul class="list-decimal ml-5 space-y-2 text-gray-600">
                        <li><strong>Reference Point</strong> Click a clear anatomical landmark (e.g., shoulder bone) in
                            Image A.</li>
                        <li><strong>Identical Match</strong> Click the <b>same</b> landmark in Image B. Accuracy here
                            is vital for contrast adjustment.</li>
                        <li><strong>Visual Verification</strong> Ensure both ROI boxes align with the same body
                            structure in both frames.</li>
                        <li><strong>Analyze</strong> Click "Submit" to synchronize pixel intensity and start AI
                            processing.</li>
                    </ul>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="flex flex-col items-center">
                        <span class="mb-2 font-semibold text-gray-700">Source Image A</span>
                        <div class="relative border-2 border-dashed border-gray-300 cursor-crosshair overflow-hidden w-full bg-gray-100"
                            id="container-1">
                            <img src="{{ 'data:image/jpeg;base64,' . session('image1_base64', 'https://demofree.sirv.com/nope-not-here.jpg') }}"
                                alt="Test 1" class="w-full h-full object-contain select-none pointer-events-none">
                        </div>
                        <p class="mt-2 text-sm text-gray-500 font-mono">Coords (center): <span id="coords-1">None</span>
                        </p>
                    </div>

                    <div class="flex flex-col items-center">
                        <span class="mb-2 font-semibold text-gray-700">Source Image B</span>
                        <div class="relative border-2 border-dashed border-gray-300 cursor-crosshair overflow-hidden w-full bg-gray-100"
                            id="container-2">
                            <img src="{{ 'data:image/jpeg;base64,' . session('image2_base64', 'https://demofree.sirv.com/nope-not-here.jpg') }}"
                                alt="Test 2" class="w-full h-full object-contain select-none pointer-events-none">
                        </div>
                        <p class="mt-2 text-sm text-gray-500 font-mono">Coords (center): <span id="coords-2">None</span>
                        </p>
                    </div>
                </div>

                <div class="flex justify-center border-t pt-6 mb-6">
                    <button id="submit-roi" type="button"
                        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .dot {
            width: 15px;
            height: 15px;
            background-color: #00ff5e;
            border: 0px solid white;
            border-radius: 50%;
            position: absolute;
            transform: translate(-50%, -50%);
            pointer-events: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const containers = [
                { id: 'container-1', coordsId: 'coords-1', x: null, y: null },
                { id: 'container-2', coordsId: 'coords-2', x: null, y: null }
            ];

            containers.forEach((item, index) => {
                const el = document.getElementById(item.id);
                const display = document.getElementById(item.coordsId);

                if (!el) return;

                el.addEventListener('click', (e) => {
                    const rect = el.getBoundingClientRect();
                    const expandPx = 10;

                    const clickX = e.clientX - rect.left;
                    const clickY = e.clientY - rect.top;

                    const xMin = Math.max(0, clickX - expandPx);
                    const yMin = Math.max(0, clickY - expandPx);
                    const xMax = Math.min(rect.width, clickX + expandPx);
                    const yMax = Math.min(rect.height, clickY + expandPx);

                    const roi = {
                        x1: (xMin / rect.width).toFixed(4),
                        y1: (yMin / rect.height).toFixed(4),
                        x2: (xMax / rect.width).toFixed(4),
                        y2: (yMax / rect.height).toFixed(4)
                    };

                    containers[index].roi = roi;

                    const existingBox = el.querySelector('.roi-box');
                    if (existingBox) existingBox.remove();

                    const box = document.createElement('div');
                    box.className = 'roi-box';
                    box.style.position = 'absolute';
                    box.style.left = `${xMin}px`;
                    box.style.top = `${yMin}px`;
                    box.style.width = `${xMax - xMin}px`;
                    box.style.height = `${yMax - yMin}px`;
                    box.style.border = '2px solid red';
                    box.style.pointerEvents = 'none';

                    el.appendChild(box);

                    const centerX = (clickX / rect.width).toFixed(4);
                    const centerY = (clickY / rect.height).toFixed(4);

                    display.innerText = `X: ${centerX}, Y: ${centerY}`;
                });
            });

            const submitBtn = document.getElementById('submit-roi');

            if (submitBtn) {
                submitBtn.addEventListener('click', async () => {
                    if (!containers[0].roi || !containers[1].roi) {
                        Swal.fire({ icon: 'warning', title: 'Missing ROI', text: 'Please click on both images to set your ROI.' });
                        return;
                    }

                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

                    Swal.fire({     
                        title: 'AI Processing...',
                        html: 'Analyzing images please wait a moment',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    try {
                        const response = await fetch("{{ route('ai.analyze') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                image1_base64: "{{ session('image1_base64') }}",
                                image2_base64: "{{ session('image2_base64') }}",
                                roi: {
                                    target: {
                                        xy_start: [parseFloat(containers[0].roi.x1), parseFloat(containers[0].roi.y1)],
                                        xy_end: [parseFloat(containers[0].roi.x2), parseFloat(containers[0].roi.y2)]
                                    },
                                    source: {
                                        xy_start: [parseFloat(containers[1].roi.x1), parseFloat(containers[1].roi.y1)],
                                        xy_end: [parseFloat(containers[1].roi.x2), parseFloat(containers[1].roi.y2)]
                                    }
                                }
                            })
                        });

                        const result = await response.json();

                        if (response.ok && result.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Analysis Complete',
                                text: 'Redirecting to results...',
                                timer: 1500,
                                showConfirmButton: false
                            });

                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('results.show') }}";

                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = "{{ csrf_token() }}";
                            form.appendChild(csrfInput);

                            const fields = ['image_source', 'image_target', 'image_changeMap'];
                            fields.forEach(fieldName => {
                                if (result[fieldName]) {
                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = fieldName;
                                    input.value = result[fieldName];
                                    form.appendChild(input);
                                }
                            });

                            document.body.appendChild(form);
                            form.submit();

                        } else {
                            throw new Error(result.message || 'AI processing failed.');
                        }

                    } catch (error) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');

                        Swal.fire({ icon: 'error', title: 'Error', text: error.message });
                        console.error('Deployment Error:', error);
                    }
                });
            }
        });
    </script>
</x-app-layout>