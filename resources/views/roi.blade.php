<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <div class="mb-10 p-6 bg-gray-50 rounded-lg border-l-4 border-blue-500">
                    <h2 class="text-xl font-bold mb-4">How to set your ROI</h2>
                    <ul class="list-decimal ml-5 space-y-2 text-gray-600">
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                        <li>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
                        <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</li>
                        <li>Duis aute irure dolor in reprehenderit in voluptate velit esse.</li>
                        <li>Excepteur sint occaecat cupidatat non proident, sunt in culpa.</li>
                    </ul>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="flex flex-col items-center">
                        <span class="mb-2 font-semibold text-gray-700">Source Image A</span>
                        <div class="relative border-2 border-dashed border-gray-300 cursor-crosshair overflow-hidden w-full bg-gray-100" id="container-1">
                            <img src="{{ session('image1_url') }}" 
                                alt="Test 1" 
                                class="w-full h-full object-contain select-none pointer-events-none">
                        </div>
                        <p class="mt-2 text-sm text-gray-500 font-mono">Coords: <span id="coords-1">None</span></p>
                    </div>

                    <div class="flex flex-col items-center">
                        <span class="mb-2 font-semibold text-gray-700">Source Image B</span>
                        <div class="relative border-2 border-dashed border-gray-300 cursor-crosshair overflow-hidden w-full bg-gray-100" id="container-2">
                            <img src="{{ session('image2_url') }}" 
                                alt="Test 2" 
                                class="w-full h-full object-contain select-none pointer-events-none">
                        </div>
                        <p class="mt-2 text-sm text-gray-500 font-mono">Coords: <span id="coords-2">None</span></p>
                    </div>
                </div>

                <div class="flex justify-center border-t pt-6 mb-6">
                    <button id="submit-roi" type="button" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Submit ROI Data
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
            box-shadow: 0 0 5px rgba(0,0,0,0.3);
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
                    
                    const xPx = e.clientX - rect.left;
                    const yPx = e.clientY - rect.top;

                    const xPercent = ((xPx / rect.width) * 100).toFixed(2);
                    const yPercent = ((yPx / rect.height) * 100).toFixed(2);

                    containers[index].x = xPercent;
                    containers[index].y = yPercent;

                    const existingDot = el.querySelector('.dot');
                    if (existingDot) existingDot.remove();

                    const dot = document.createElement('div');
                    dot.className = 'dot';
                    dot.style.left = `${xPx}px`;
                    dot.style.top = `${yPx}px`;
                    el.appendChild(dot);

                    display.innerText = `X: ${xPercent}%, Y: ${yPercent}%`;
                });
            });

            const submitBtn = document.getElementById('submit-roi');
            
            if (submitBtn) {
                submitBtn.addEventListener('click', async () => {
                    if (!containers[0].x || !containers[1].x) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Selection',
                            text: 'Please click on both images to set your ROI points before submitting.',
                            confirmButtonColor: '#3b82f6',
                        });
                        return;
                    }

                    const confirmResult = await Swal.fire({
                        title: 'Confirm Reference Points?',
                        text: "Do you want to start process?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Start',
                        cancelButtonText: 'Review again',
                        confirmButtonColor: '#22c55e',
                        cancelButtonColor: '#6b7280',
                    });

                    if (confirmResult.isConfirmed) {
                        Swal.fire({
                            title: 'Calculating...',
                            html: 'AI in progress please wait a moment.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        const payload = {
                            _token: '{{ csrf_token() }}',
                            image_a: { x: containers[0].x, y: containers[0].y },
                            image_b: { x: containers[1].x, y: containers[1].y }
                        };

                        try {
                            console.log('Final Payload:', payload);
                            
                            // --- SIMULATED API CALL ---
                            await new Promise((resolve) => setTimeout(resolve, 1500)); 
                            // const response = await fetch('/your-endpoint', {
                            //     method: 'POST',
                            //     headers: { 'Content-Type': 'application/json' },
                            //     body: JSON.stringify(payload)
                            // });
                            // if (!response.ok) throw new Error('Network error');
                            // ----------------------------

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                // text: 'Successfully.',
                                timer: 2500,
                                showConfirmButton: false,
                                toast: false,
                                position: 'center'
                            });
                            
                            // temporary navigation
                            window.location.href = 'home'

                        } catch (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Submission Failed',
                                text: 'There was an error saving your data. Please try again.',
                            });
                            console.error('Submission error:', error);
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>