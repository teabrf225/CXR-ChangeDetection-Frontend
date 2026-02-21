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
                            <img src="https://www.meddean.luc.edu/lumen/meded/medicine/pulmonar/cxr/atlas/images/71bl.jpg" 
                                alt="Test 1" 
                                class="w-full h-full object-contain select-none pointer-events-none">
                        </div>
                        <p class="mt-2 text-sm text-gray-500 font-mono">Coords: <span id="coords-1">None</span></p>
                    </div>

                    <div class="flex flex-col items-center">
                        <span class="mb-2 font-semibold text-gray-700">Source Image B</span>
                        <div class="relative border-2 border-dashed border-gray-300 cursor-crosshair overflow-hidden w-full bg-gray-100" id="container-2">
                            <img src="https://litfl.com/wp-content/uploads/2018/05/CXR-CASE-150-CXR-LITFL.jpg" 
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

                el.addEventListener('click', (e) => {
                    const rect = el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    containers[index].x = ((x / rect.width) * 100).toFixed(2);
                    containers[index].y = ((y / rect.height) * 100).toFixed(2);

                    const existingDot = el.querySelector('.dot');
                    if (existingDot) existingDot.remove();

                    const dot = document.createElement('div');
                    dot.className = 'dot';
                    dot.style.left = `${x}px`;
                    dot.style.top = `${y}px`;
                    el.appendChild(dot);

                    display.innerText = `X: ${containers[index].x}%, Y: ${containers[index].y}%`;
                });
            });

            document.getElementById('submit-roi').addEventListener('click', async () => {
                const payload = {
                    image_1_coords: { x: containers[0].x, y: containers[0].y },
                    image_2_coords: { x: containers[1].x, y: containers[1].y },
                    _token: '{{ csrf_token() }}'
                };

                if (!containers[0].x || !containers[1].x) {
                    alert('Please select a point on both images first!');
                    return;
                }

                console.log('Sending to backend:', payload);

                // mockup the API call
                try {
                    // const response = await fetch('/api/save-roi', {
                    //     method: 'POST',
                    //     headers: { 'Content-Type': 'application/json' },
                    //     body: JSON.stringify(payload)
                    // });
                    alert('Data prepared for backend!');
                } catch (error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>
</x-app-layout>