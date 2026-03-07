<x-app-layout>
    <style>
        .hover-shadow:hover {
            transform: translateY(-2px);
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .workflow-step {
            border-bottom: 1px solid #edf2f7;
            padding-bottom: 1rem;
        }
        .workflow-step:last-child {
            border-bottom: none;
        }
    </style>

    <div class="py-12 bg-gray-50">
        <div class="container">
            <div class="row justify-content-center mb-3">
                <div class="col-12 col-lg-10 mt-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-1">
                                Web Application for Visualizing Chest X-Ray Temporal Changes
                            </h1>
                            <p class="text-lg text-gray-600 mb-0">
                                Welcome, <span class="fw-bold text-dark">Dr. {{ Auth::user()->name }}</span> | 
                                Clinical Decision Support: Temporal Analysis Terminal
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center g-4">
                <div class="col-12 col-lg-7">
                    <div class="card border-0 shadow-sm rounded-lg mb-4 p-4 bg-white overflow-hidden" style="border-left: 5px solid #3182ce !important;">
                        <div class="card-body">
                            <h2 class="text-2xl font-bold text-gray-800 mb-3">Start New Comparison</h2>
                            <p class="text-gray-600 mb-8" style="max-width: 500px;">
                                Ready to analyze temporal changes? Our AI engine will assist you in detecting subtle differences between scans to support your clinical decision.
                            </p>
                            
                            <a href="{{ route('upload-image.form') }}" class="btn btn-dark d-inline-flex align-items-center justify-content-center px-5 py-3 hover-shadow mt-3" style="font-size: 1.15rem; font-weight: bold; border-radius: 10px; background-color: #1a202c; border: none;">
                                <svg class="w-6 h-6 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 1H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Initiate Temporal Comparison
                            </a>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-lg h-100 p-3 bg-white">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="p-2 bg-green-100 rounded-circle me-3 text-green-600">
                                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <span class="font-bold text-gray-800">Zero-Retention</span>
                                </div>
                                <p class="small text-gray-500 mb-0">Images are processed in transient memory and are <strong>never stored</strong> in any permanent database.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-lg h-100 p-3 bg-white">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="p-2 bg-blue-100 rounded-circle me-3 text-blue-600">
                                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"></path></svg>
                                    </div>
                                    <span class="font-bold text-gray-800">Secure Transit</span>
                                </div>
                                <p class="small text-gray-500 mb-0">End-to-end encryption ensures patient imagery remains confidential throughout the session.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-lg bg-white mb-4">
                        <div class="card-body p-4">
                            <h3 class="font-bold text-lg mb-4 text-gray-800 border-bottom pb-2">Analysis Workflow</h3>
                            <div class="space-y-4">
                                <div class="workflow-step d-flex">
                                    <div class="bg-gray-100 text-gray-700 rounded-circle h-6 w-6 flex items-center justify-center me-3 shrink-0 small fw-bold" style="width:24px; height:24px;">1</div>
                                    <p class="small mb-0 text-gray-600"><strong>Upload:</strong> Provide Reference image (Past) and Target image scans.</p>
                                </div>
                                <div class="workflow-step d-flex pt-2">
                                    <div class="bg-gray-100 text-gray-700 rounded-circle h-6 w-6 flex items-center justify-center me-3 shrink-0 small fw-bold" style="width:24px; height:24px;">2</div>
                                    <p class="small mb-0 text-gray-600"><strong>Set ROI:</strong> Select landmarks for precise AI alignment.</p>
                                </div>
                                <div class="workflow-step d-flex pt-2">
                                    <div class="bg-gray-100 text-gray-700 rounded-circle h-6 w-6 flex items-center justify-center me-3 shrink-0 small fw-bold" style="width:24px; height:24px;">3</div>
                                    <p class="small mb-0 text-gray-600"><strong>Result:</strong> Analyze Change Map and download results.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-lg shadow-sm" style="background-color: #fffaf0; border-left: 4px solid #ed8936;">
                        <div class="d-flex align-items-center mb-2">
                            <svg class="me-2" width="18" height="18" fill="#ed8936" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-bold text-orange-800 small">Notice</span>
                        </div>
                        <p class="small text-orange-700 mb-0" style="line-height: 1.4;">
                            Data is not persistent. Please ensure you download the <strong>Analysis Result</strong> before closing your browser tab.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>