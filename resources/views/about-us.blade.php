<x-app-layout>
    <style>
        /* Spacing & Layout Constants */
        :root { 
            --section-spacing: 100px; 
            --primary-blue: #2563eb;
            --medical-teal: #0d9488;
            --emerald-600: #059669;
        }
        .py-section { padding-top: var(--section-spacing); padding-bottom: var(--section-spacing); }
        
        /* Hero Section */
        .about-hero { 
            background: radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.05) 0, transparent 50%), 
                        radial-gradient(at 100% 0%, rgba(13, 148, 136, 0.05) 0, transparent 50%),
                        linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 140px 0 100px; 
        }
        
        /* Custom Backgrounds for Teams */
        .bg-frontend-section {
            background: linear-gradient(180deg, #f8fafc 0%, #b9d8ff 100%);
            border-top: 1px solid #e2e8f0;
        }
        .bg-backend-section {
            background: linear-gradient(180deg, #b9d8ff 0%, #b9ffc2 100%);
            border-top: 1px solid #e2e8f0;
        }
        
        /* Table Styling */
        .table-custom { border-radius: 20px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border-collapse: separate; border-spacing: 0; }
        .table-custom thead { background: #0f172a; color: white; }
        .table-custom th { font-weight: 600; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.1em; padding: 1.25rem 1rem; text-align: center; vertical-align: middle; }
        .table-custom td { padding: 1.25rem 1rem; vertical-align: middle; color: #475569; border-bottom: 1px solid #f1f5f9; transition: background 0.2s ease; text-align: center; }
        .table-custom tr:hover td { background: #f8fafc; }
        .velocity-low { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .velocity-normal { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }
        
        /* Card Styling */
        .dev-card { 
            background: rgba(255, 255, 255, 0.8);
            border-radius: 28px; 
            border: 1px solid rgba(255, 255, 255, 0.4); 
            padding: 3rem 2rem; 
            transition: all 0.5s cubic-bezier(0.2, 1, 0.3, 1);
            height: 100%;
            min-height: 560px;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(12px)
        }
        .dev-card::before {
            content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
            background: linear-gradient(90deg, transparent, var(--primary-blue), transparent);
            opacity: 0; transition: opacity 0.3s ease;
        }
        .dev-card:hover { transform: translateY(-10px); box-shadow: 0 30px 60px -12px rgba(15, 23, 42, 0.12); border-color: #dbeafe; }
        .dev-card:hover::before { opacity: 1; }

        .dev-card-link {
            display: block;
            height: 100%;
            color: inherit;
        }

        .github-indicator {
            margin-top: auto;
            padding-top: 1.5rem;
            font-size: 0.85rem;
            color: #cbd5e1;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            border-top: 1px solid #f8fafc;
        }

        .github-text {
            font-family: sans-serif;
            text-transform: none;
            letter-spacing: 0;
        }

        .dev-card-link:hover .dev-card {
            border-color: var(--primary-blue);
            cursor: pointer;
        }

        .dev-card-link:hover .github-indicator {
            color: var(--primary-blue);
            transform: scale(1.2);
        }
        
        /* Badges & Chips */
        .role-badge { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.08em; padding: 6px 16px; border-radius: 30px; font-weight: 800; margin-bottom: 1.5rem; display: inline-block; }
        .bg-frontend { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .bg-backend { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

        .velocity-chip { padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.85rem; display: inline-block; }
        .velocity-high { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }

        /* Avatar Decoration */
        .avatar-container { 
            width: 130px; 
            height: 130px; 
            margin: 0 auto 2rem; 
            position: relative;
            background-color: #f1f5f9;
            border-radius: 40px;
        }
        .avatar-img { 
            width: 100%; height: 100%; border-radius: 40px; object-fit: cover; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); border: 4px solid white; 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .dev-card:hover .avatar-img { transform: scale(1.08) rotate(3deg); border-color: #eff6ff; }

        /* Task List Icon Decoration */
        .task-list {
            font-size: 0.9rem;
            padding: 2px 8px;
            background: #f1f5f9;
            border-radius: 4px;
            color: #546b8a;
            margin-right: 4px;
        }
        .task-list li { position: relative; padding-left: 1.5rem; word-wrap: break-word; overflow-wrap: break-word;}
        .task-list li::before {
            content: "→"; position: absolute; left: 0; color: var(--primary-blue); font-weight: bold; opacity: 0.5;
        }
    </style>

    <section class="about-hero text-center position-relative">
        <div class="container">
            <span class="badge px-4 py-2 rounded-pill small fw-bold mb-4 shadow-sm" 
                style="font-size: 0.75rem; background-color: #2563eb !important; color: #ffffff !important; display: inline-block;">ENGINEERING TEAM</span>
            <h1 class="display-4 fw-bold text-slate-900 mb-3 tracking-tight">Precision Medical AI Development</h1>
            <p class="text-lg text-slate-600 mx-auto" style="max-width: 750px; line-height: 1.8; font-weight: 450;">
                We are a high-performance team of AI Engineering students leveraging modern agile methodologies to build reliable clinical tools.
            </p>
        </div>
    </section>

    <section class="py-section border-top bg-white">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <div class="pe-lg-4">
                        <h2 class="h2 fw-bold text-slate-900 mb-4">Development Lifecycle</h2>
                        <p class="text-slate-600 mb-5 fs-6" style="line-height: 1.7;">
                            Our project followed a strict <strong>Agile Burndown</strong> trajectory. We maintained high velocity in early architectural phases and final system integration.
                        </p>
                        <div class="p-4 bg-emerald-50 rounded-4 border border-emerald-100 shadow-sm">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="h1 fw-bold text-emerald-600 mb-0">6.57</div>
                                </div>
                                <div class="col border-start border-emerald-200 ms-3 ps-3">
                                    <div class="text-xs text-emerald-700 fw-bold text-uppercase tracking-widest mb-1">Best Performance Metric</div>
                                    <div class="small text-slate-600 fw-bold uppercase tracking-wider">Peak Velocity<br><span class="text-emerald-500">Sprint 4 Integration</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="table-responsive rounded-4">
                        <table class="table table-custom mb-0 bg-white text-center align-middle">
                            <thead>
                                <tr>
                                    <th>Sprint</th>
                                    <th>Estimated Burndown</th>
                                    <th>Real Burndown</th>
                                    <th>Velocity</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                <tr>
                                    <td>1</td>
                                    <td>101 pts</td>
                                    <td>101 pts</td>
                                    <td><span class="velocity-chip velocity-normal">5.14</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>80.8 pts</td>
                                    <td>65 pts</td>
                                    <td><span class="velocity-chip velocity-low">0.80</span></td> </tr>
                                <tr>
                                    <td>3</td>
                                    <td>60.6 pts</td>
                                    <td>51 pts</td>
                                    <td><span class="velocity-chip velocity-low">1.14</span></td> </tr>
                                <tr>
                                    <td>4</td>
                                    <td>40.4 pts</td>
                                    <td>5 pts</td>
                                    <td><span class="velocity-chip velocity-high">6.57</span></td> </tr>
                                <tr>
                                    <td>5</td>
                                    <td>20.2 pts</td>
                                    <td><span class="text-emerald-600 fw-bold">0 pts</span></td>
                                    <td><span class="velocity-chip velocity-low">0.71</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 bg-slate-50 rounded-4 p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <h3 class="h5 fw-bold text-slate-800 mb-2">Product Burndown & Velocity Tracking</h3>
                            <p class="text-muted small">Visualizing development pace and task completion across sprints</p>
                        </div>

                        <div style="position: relative; height:450px; width:100%">
                            <canvas id="burndownChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-section bg-frontend-section">
        <div class="container text-center">
            <h2 class="h3 fw-bold text-slate-900 mb-5">Frontend & UI/UX Specialists</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 col-12">
                    <a href="https://github.com/tanaratsaehia" target="_blank" class="text-decoration-none dev-card-link" aria-label="GitHub Profile of Tanarat">
                        <div class="dev-card">
                            <div class="avatar-container">
                                <img src="{{ asset('images/team/Oil.jpg') }}" alt="Tanarat" class="avatar-img">
                            </div>
                            <span class="role-badge bg-frontend shadow-sm">Frontend & Ops</span>
                            <h4 class="h5 fw-bold text-slate-900 mb-3">Tanarat Saehia</h4>
                            <ul class="task-list text-start text-slate-600 small list-unstyled">
                                <li class="mb-2">UI Design, Page Layout & Auth Pages</li>
                                <li class="mb-2">Interactive ROI selection & Results page logic</li>
                                <li class="mb-2">Host DB service, Migrate DB & Docker</li>
                                <li class="mb-2">Auth service & Frontend functional test</li>
                                <li class="mb-2">Deployment</li>
                            </ul>
                            <div class="github-indicator">
                                <i class="fab fa-github"></i>
                                <span class="github-text">tanaratsaehia</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <a href="https://github.com/teabrf225" target="_blank" class="text-decoration-none dev-card-link" aria-label="GitHub Profile of teabrf225">
                        <div class="dev-card">
                            <div class="avatar-container">
                                <img src="{{ asset('images/team/Tae.jpg') }}" alt="Tanatorn" class="avatar-img">
                            </div>
                            <span class="role-badge bg-frontend shadow-sm">Frontend</span>
                            <h4 class="h5 fw-bold text-slate-900 mb-3">Tanatorn Boontem</h4>
                            <ul class="task-list text-start text-slate-600 small list-unstyled">
                                <li class="mb-2">Authenticated and Public Landing Pages</li>
                                <li class="mb-2">Global UI decoration & Aesthetic enhancements</li>
                                <li class="mb-2">UI Design, Upload page & About us page</li>
                                <li class="mb-2">Collaborative UI development for Inference Results page</li>
                                <li class="mb-2">Frontend functional test</li>
                            </ul>
                            <div class="github-indicator">
                                <i class="fab fa-github"></i>
                                <span class="github-text">teabrf225</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-section bg-backend-section">
        <div class="container text-center">
            <h2 class="h3 fw-bold text-slate-900 mb-5">Backend & AI Algorithm Engineers</h2>
            <div class="row g-4">
                <div class="col-lg-4 col-md-4 col-12">
                    <a href="https://github.com/Phinatkanin" target="_blank" class="text-decoration-none dev-card-link" aria-label="GitHub Profile of Phinatkanin">
                        <div class="dev-card">
                            <div class="avatar-container">
                                <img src="{{ asset('images/team/PP.jpg') }}" alt="Phinatkanin" class="avatar-img">
                            </div>
                            <span class="role-badge bg-backend shadow-sm">AI Algorithm Engineer</span>
                            <h4 class="h5 fw-bold text-slate-900 mb-3">Phinatkanin Phisitkul</h4>
                            <ul class="task-list text-start text-slate-600 small list-unstyled">
                                <li class="mb-2">One-class model & Domain check algorithm</li>
                                <li class="mb-2">Image registration & Change map algorithm</li>
                                <li class="mb-2">API Service & Backend functional test</li>
                            </ul>
                            <div class="github-indicator">
                                <i class="fab fa-github"></i>
                                <span class="github-text">Phinatkanin</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <a href="https://github.com/ArcAlter" target="_blank" class="text-decoration-none dev-card-link" aria-label="GitHub Profile of ArcAlter">
                        <div class="dev-card">
                            <div class="avatar-container">
                                <img src="{{ asset('images/team/Matt.jpg') }}" alt="Pakawat" class="avatar-img">
                            </div>
                            <span class="role-badge bg-backend shadow-sm">Backend Architect</span>
                            <h4 class="h5 fw-bold text-slate-900 mb-3">Pakawat Chuchotiros</h4>
                            <ul class="task-list text-start text-slate-600 small list-unstyled">
                                <li class="mb-2">Database Schema Design (ERD), Auth service & Normalization algorithm</li>
                                <li class="mb-2">Segment model & Crop algorithm</li>
                                <li class="mb-2">API Service to connect front-end</li>
                                <li class="mb-2">Backend functional test</li>
                            </ul>
                            <div class="github-indicator">
                                <i class="fab fa-github"></i>
                                <span class="github-text">ArcAlter</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <a href="https://github.com/krissanapong2005" target="_blank" class="text-decoration-none dev-card-link" aria-label="GitHub Profile of krissanapong2005">
                        <div class="dev-card">
                            <div class="avatar-container">
                                <img src="{{ asset('images/team/Big.jpg') }}" alt="Krissanapong" class="avatar-img">
                            </div>
                            <span class="role-badge bg-backend shadow-sm">System Engineer</span>
                            <h4 class="h5 fw-bold text-slate-900 mb-3">Krissanapong Songkramsong</h4>
                            <ul class="task-list text-start text-slate-600 small list-unstyled">
                                <li class="mb-2">API Service to connect front-end</li>
                                <li class="mb-2">Connect MySql to Backend Service</li>
                                <li class="mb-2">Backend functional test</li>
                            </ul>
                            <div class="github-indicator">
                                <i class="fab fa-github"></i>
                                <span class="github-text">krissanapong2005</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 border-top bg-white">
        <div class="container text-center">
            <p class="text-slate-400 small mb-0 fw-bold text-uppercase tracking-widest" style="font-size: 0.65rem;">
                Developed at College of Computing, Khon Kaen University • 2026
            </p>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('burndownChart').getContext('2d');
        
        const sprintLabels = ['Sprint 1', 'Sprint 2', 'Sprint 3', 'Sprint 4', 'Sprint 5', 'Sprint 6'];

        new Chart(ctx, {
            data: {
                labels: sprintLabels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Velocity (Performance)',
                        data: [5.14, 0.8, 1.14, 6.57, 0.71, 0],
                        borderColor: '#0d9488',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        stepped: true,
                        pointStyle: 'rectRot',
                        pointRadius: 6,
                        pointBackgroundColor: '#0d9488',
                        yAxisID: 'y_velocity'
                    },
                    {
                        type: 'line',
                        label: 'Real Burndown',
                        data: [101, 65, 51, 5, 0, null],
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.05)',
                        borderWidth: 4,
                        fill: true,
                        tension: 0.2,
                        yAxisID: 'y'
                    },
                    {
                        type: 'line',
                        label: 'Estimated (Plan)',
                        data: [101, 80.8, 60.6, 40.4, 20.2, 0],
                        borderColor: '#cbd5e1',
                        borderDash: [6, 4],
                        borderWidth: 2,
                        fill: false,
                        yAxisID: 'y'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 10,
                            font: { size: 12, weight: '600' }
                        }
                    },
                    tooltip: {
                        padding: 12,
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Remaining Story Points',
                            font: { weight: 'bold' }
                        },
                        beginAtZero: true
                    },
                    y_velocity: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        title: {
                            display: true,
                            text: 'Velocity (pts / week)',
                            font: { weight: 'bold' }
                        },
                        min: 0,
                        max: 15
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</x-app-layout>