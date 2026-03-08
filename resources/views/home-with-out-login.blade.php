<x-guest-layout>
    <style>
        .hero-section { background: linear-gradient(to bottom, #ffffff, #f8fafc); padding: 80px 0; }
        .feature-icon { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 12px; margin-bottom: 1rem; }
        .nav-glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border-bottom: 1px solid #e2e8f0; }
        .workflow-container { 
        position: relative; 
        background: #ffffff; 
        border-radius: 24px; 
    }
    .workflow-step-item {
        position: relative;
        padding-bottom: 2.5rem;
        z-index: 1;
    }
    .workflow-step-item:not(:last-child)::after {
        content: "";
        position: absolute;
        left: 20px;
        top: 40px;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
        z-index: -1;
    }
    .step-icon {
        width: 40px; 
        height: 40px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        background-color: #f1f5f9 !important; 
        color: #475569 !important; 
    }

    .workflow-step-item:hover .step-icon {
        transform: scale(1.1);
        background-color: #2b6cb0 !important;
        color: #ffffff !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .workflow-step-item:last-child {
        padding-bottom: 0;
    }
    </style>

    <nav class="nav-glass sticky-top py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('welcome') }}" class="text-decoration-none d-flex align-items-center">
                <x-application-mark class="h-9 w-auto" />
                <span class="ms-2 fw-bold text-xl text-gray-900">
                    CXR <span class="text-primary text-blue-600">ChangeDetection</span>
                </span>
            </a>
            <div>
                @if (Route::has('login'))
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-600 text-decoration-none fw-medium me-4">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-dark px-4" style="border-radius: 8px;">Get Started</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-5 font-bold text-gray-900 mb-3" style="line-height: 1.2;">
                        AI-Powered Visualization for<br>
                        <span class="text-blue-600">Chest X-Ray Temporal Change Detection</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-5">
                        Assisting clinicians in evaluating subtle disease progression through automated image registration and temporal subtraction.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 py-3 shadow-sm" style="background-color: #3182ce; border: none; border-radius: 10px;">
                            Launch Clinical Analysis
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 d-none d-lg-block">
                    <div class="workflow-container p-5 shadow-xl border border-gray-100">
                        <div class="d-flex align-items-center mb-5">
                            <span class="badge bg-blue-100 text-blue-600 px-3 py-2 rounded-pill small fw-bold me-2">Workflow</span>
                            <h4 class="h6 fw-bold text-gray-900 mb-0">Analysis Pipeline</h4>
                        </div>
                        
                        <div class="workflow-step-item d-flex">
                            <div class="flex-shrink-0">
                                <div class="step-icon bg-blue-600 rounded-circle d-flex align-items-center justify-content-center">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                            </div>
                            <div class="ms-4">
                                <h5 class="small fw-bold text-gray-900 mb-1">1. Study Input</h5>
                                <p class="text-gray-500 mb-0" style="font-size: 0.85rem; line-height: 1.5;">
                                    Radiologists upload Reference and Target chest X-ray images in .png, .jpg, or .jpeg formats for comparison.
                                </p>
                            </div>
                        </div>

                        <div class="workflow-step-item d-flex">
                            <div class="flex-shrink-0">
                                <div class="step-icon bg-blue-600 rounded-circle d-flex align-items-center justify-content-center">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 4l2 2m15-2l-2 2m2 12l-2-2M4 18l2-2m0-10l8 8m-4-4l8-8"></path></svg>
                                </div>
                            </div>
                            <div class="ms-4">
                                <h5 class="small fw-bold text-gray-900 mb-1">2. Precision Registration</h5>
                                <p class="text-gray-500 mb-0" style="font-size: 0.85rem; line-height: 1.5;">
                                    Radiologists manually select corresponding anatomical landmarks on both images to initiate the AI-driven registration process.
                                </p>
                            </div>
                        </div>

                        <div class="workflow-step-item d-flex">
                            <div class="flex-shrink-0">
                                <div class="step-icon bg-green-500 rounded-circle d-flex align-items-center justify-content-center">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </div>
                            </div>
                            <div class="ms-4">
                                <h5 class="small fw-bold text-gray-900 mb-1">3. Subtraction Analysis</h5>
                                <p class="text-gray-500 mb-0" style="font-size: 0.85rem; line-height: 1.5;">
                                    Visualize the generated Temporal Subtraction Map to evaluate interval disease progression with AI assistance.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-4">
                    <div class="feature-icon bg-blue-100 text-blue-600">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="h5 font-bold mb-2">Zero-Retention Security</h3>
                    <p class="text-gray-500 small">We prioritize patient privacy. All uploaded imagery is processed in volatile memory and never stored permanently.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon bg-green-100 text-green-600">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="h5 font-bold mb-2">Real-time Comparison</h3>
                    <p class="text-gray-500 small">Instant alignment of Reference and target scans using state-of-the-art image registration algorithms.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon bg-orange-100 text-orange-600">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="h5 font-bold mb-2">Clinical Precision</h3>
                    <p class="text-gray-500 small">Engineered to highlight subtle changes in pulmonary opacities, interstitial markings, and infection progression.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-20 bg-gray-50 border-top my-5">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <h2 class="h4 font-bold text-gray-900 mb-5 mt-5">Research & Development</h2>
                    <div class="card border-0 shadow-sm p-5 hover-shadow-lg" style="border-radius: 24px; background: white;">
                        <div class="mb-4">
                            <div class="d-inline-flex p-3 bg-blue-50 rounded-circle mb-3 text-blue-600">
                                <x-application-mark class="h-9 w-auto" />
                            </div>
                            <h3 class="h5 font-bold text-gray-900 mb-1">Team Basic Research</h3>
                            <p class="text-gray-600">
                                Artificial Intelligence Students, College of Computing<br>
                                Khon Kaen University
                            </p>
                        </div>
                        <div class="p-3 rounded-lg bg-gray-50 border-start border-blue-600 border-4">
                            <p class="small text-gray-500 italic mb-0">
                                "Dedicated to advancing medical imaging through innovative Deep Learning solutions."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>