<!DOCTYPE html>
<html class="h-full" lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="">
        <title>QTimer - Academic Results Dashboard</title>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com/3.4.17"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'primary': '#4F46E5',
                            'success': '#10B981',
                            'accent': '#F59E0B',
                        }
                    }
                }
            }
        </script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Crimson+Text:wght@400;600&display=swap" rel="stylesheet">
        <style>
            [x-cloak] {
                display: none !important;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            html,
            body {
                height: 100%;
            }

            body {
                font-family: 'Inter', system-ui, sans-serif;
                background: #f9fafb;
                color: #1f2937;
            }

            .serif-heading {
                font-family: 'Crimson Text', serif;
            }

            /* Print Styles */
            @media print {
                body {
                    background: white;
                    margin: 0;
                    padding: 0;
                }

                .screen-only {
                    display: none !important;
                }

                .print-page {
                    page-break-after: always;
                    break-after: always;
                    margin: 0;
                    padding: 0;
                    min-height: 100%;
                }

                .print-page:last-child {
                    page-break-after: avoid;
                    break-after: avoid;
                }

                .no-page-break {
                    page-break-inside: avoid;
                    break-inside: avoid;
                }

                table {
                    border-collapse: collapse;
                    width: 100%;
                }

                tr {
                    page-break-inside: avoid;
                    break-inside: avoid;
                }

                @page {
                    size: A4;
                    margin: 1.5cm;
                }

                .print-header {
                    page-break-inside: avoid;
                }
            }

            /* Screen layout */
            .dashboard-container {
                max-width: 1400px;
                margin: 0 auto;
            }

            @media screen and (max-width: 768px) {
                .dashboard-container {
                    padding: 1rem;
                }

                .hidden-mobile {
                    display: none !important;
                }
            }

            .grade-badge {
                display: inline-block;
                padding: 0.25rem 0.75rem;
                border-radius: 4px;
                font-weight: 600;
                font-size: 0.875rem;
                text-align: center;
                min-width: 2.5rem;
            }

            .grade-a {
                background-color: #ecfdf5;
                color: #065f46;
            }

            .grade-b {
                background-color: #eff6ff;
                color: #0c4a6e;
            }

            .grade-c {
                background-color: #fffbeb;
                color: #92400e;
            }

            .grade-d {
                background-color: #fed7aa;
                color: #92400e;
            }

            .grade-f {
                background-color: #fee2e2;
                color: #991b1b;
            }

            table {
                font-size: 0.9375rem;
                line-height: 1.5;
            }

            th {
                padding: 0.75rem;
                text-align: left;
                font-weight: 600;
                background-color: #f3f4f6;
                border-bottom: 2px solid #e5e7eb;
                color: #374151;
            }

            td {
                padding: 0.75rem;
                border-bottom: 1px solid #e5e7eb;
            }

            tr:hover {
                background-color: #f9fafb;
            }

            .expandable-row {
                cursor: pointer;
                user-select: none;
            }

            .subject-breakdown {
                background-color: #f3f4f6;
                padding: 1rem;
            }

            .stat-box {
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                padding: 1.5rem;
                text-align: center;
            }

            .stat-value {
                font-size: 1.875rem;
                font-weight: 700;
                color: #4F46E5;
                margin: 0.5rem 0;
            }

            .stat-label {
                font-size: 0.875rem;
                color: #6b7280;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.025em;
            }

            .summary-card {
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .section-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: #111827;
                margin-bottom: 1rem;
                margin-top: 2rem;
                border-bottom: 2px solid #e5e7eb;
                padding-bottom: 0.75rem;
            }

            .header-section {
                background: white;
                border-bottom: 2px solid #e5e7eb;
                padding: 2rem 1.5rem;
                text-align: center;
                margin-bottom: 2rem;
            }

            .school-logo-placeholder {
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, #4F46E5, #7C3AED);
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1rem;
                color: white;
                font-weight: bold;
            }

            .exam-title {
                font-family: 'Crimson Text', serif;
                font-size: 2.25rem;
                font-weight: 600;
                color: #111827;
                margin: 1rem 0 0.5rem;
            }

            .exam-meta {
                font-size: 0.875rem;
                color: #6b7280;
                display: flex;
                justify-content: center;
                gap: 2rem;
                flex-wrap: wrap;
            }

            .meta-item {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .footer-section {
                margin-top: 3rem;
                padding-top: 2rem;
                border-top: 1px solid #d1d5db;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }

            .signature-box {
                border-top: 1px solid #374151;
                padding-top: 0.5rem;
                margin-top: 1.5rem;
                min-height: 2rem;
            }

            .stamp-area {
                border: 2px dashed #d1d5db;
                padding: 1rem;
                text-align: center;
                border-radius: 8px;
                min-height: 4rem;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #9ca3af;
                font-size: 0.875rem;
            }

            .ai-summary {
                background: #f0f9ff;
                border-left: 4px solid #4F46E5;
                padding: 1.5rem;
                margin: 2rem 0;
                border-radius: 4px;
            }

            .ai-summary-title {
                font-weight: 600;
                color: #0c4a6e;
                margin-bottom: 0.75rem;
            }

            .ai-summary-text {
                color: #334155;
                line-height: 1.6;
                font-size: 0.9375rem;
            }

            .page-number {
                text-align: center;
                color: #9ca3af;
                font-size: 0.875rem;
                margin-top: 1.5rem;
                padding-top: 1rem;
                border-top: 1px solid #e5e7eb;
            }

            .spinner {
                display: inline-block;
                width: 20px;
                height: 20px;
                border: 3px solid #e5e7eb;
                border-radius: 50%;
                border-top-color: #4F46E5;
                animation: spin 0.8s linear infinite;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            /* Screen Controls */
            .screen-controls {
                position: sticky;
                top: 0;
                z-index: 50;
                background: white;
                border-bottom: 1px solid #e5e7eb;
                padding: 1rem;
                display: flex;
                gap: 1rem;
                justify-content: space-between;
                align-items: center;
            }

            .btn {
                padding: 0.5rem 1rem;
                border-radius: 6px;
                border: none;
                cursor: pointer;
                font-weight: 500;
                font-size: 0.875rem;
                transition: all 0.2s;
            }

            .btn-primary {
                background: #4F46E5;
                color: white;
            }

            .btn-primary:hover {
                background: #4338ca;
            }

            .btn-secondary {
                background: #e5e7eb;
                color: #374151;
            }

            .btn-secondary:hover {
                background: #d1d5db;
            }

            .btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            .exam-selector {
                padding: 0.5rem;
                border: 1px solid #d1d5db;
                border-radius: 6px;
                font-size: 0.875rem;
            }

            .loading-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 300px;
                gap: 1rem;
                color: #6b7280;
            }
        </style>
    </head>

    <body class="h-full" x-data="resultsApp()" x-init="init()" x-cloak>

        <!-- Screen Controls -->
        <div class="screen-only screen-controls">
            <div>
                <h1 class="text-xl font-bold text-gray-800">QTimer Results Dashboard</h1>
            </div>
            <div class="flex items-center gap-4">
                <select class="exam-selector" x-model="selectedExamId" @change="loadResults()" v-if="exams.length > 0">
                    <option value="">Select Exam...</option>
                    <template x-for="exam in exams" :key="exam.id">
                        <option :value="exam.id" x-text="exam.title"></option>
                    </template>
                </select>
                <div class="flex items-center gap-2" x-show="loading">
                    <span class="spinner"></span>
                    <span class="text-sm text-gray-600">Loading...</span>
                </div>
                <button class="btn btn-primary" @click="printPage()" :disabled="!data || loading">
                    🖨️ Print
                </button>
                <button class="btn btn-primary" @click="exportPDF()" :disabled="!data || loading">
                    📄 PDF
                </button>
                <button class="btn btn-secondary" @click="refreshData()" :disabled="loading">
                    🔄 Refresh
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="dashboard-container">

            <!-- Loading State -->
            <template x-if="loading && !data">
                <div class="loading-container">
                    <div class="spinner"></div>
                    <p>Loading results...</p>
                </div>
            </template>

            <!-- Error State -->
            <template x-if="error && !loading">
                <div class="summary-card" style="background: #fee2e2; border-color: #fecaca;">
                    <p style="color: #991b1b; font-weight: 500;">❌ Error loading results</p>
                    <p style="color: #7f1d1d; font-size: 0.875rem; margin-top: 0.5rem;" x-text="error"></p>
                    <button class="btn btn-primary" style="margin-top: 1rem;" @click="refreshData()">Try Again</button>
                </div>
            </template>

            <!-- Results Display -->
            <template x-if="data && !loading">

                <!-- Print Pages Container -->
                <div id="print-content">

                    <!-- PAGE 1: Header & Summary -->
                    <div class="print-page">
                        <!-- Header -->
                        <div class="header-section print-header no-page-break">
                            {{-- <div class="school-logo-placeholder">
                                Q
                            </div> --}}
                            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;" x-text="schoolName"></div>
                            <div class="exam-title" x-text="data.exam.title"></div>
                            <div class="exam-meta">
                                <div class="meta-item">
                                    <span>📅</span>
                                    <span x-text="currentDate"></span>
                                </div>
                                <div class="meta-item">
                                    <span>📚</span>
                                    <span x-text="'Academic Year: ' + academicYear"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Statistics -->
                        <div style="margin: 2rem 0;">
                            <div class="section-title">Exam Overview</div>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                                <div class="stat-box no-page-break">
                                    <div class="stat-label">Total Students</div>
                                    <div class="stat-value" x-text="data.exam_stats.total_students"></div>
                                </div>
                                <div class="stat-box no-page-break">
                                    <div class="stat-label">Class Average</div>
                                    <div class="stat-value" x-text="data.exam_stats.exam_average.toFixed(1) + '%'"></div>
                                </div>
                                <div class="stat-box no-page-break">
                                    <div class="stat-label">Highest Score</div>
                                    <div class="stat-value" x-text="data.exam_stats.highest_score + '%'"></div>
                                </div>
                                <div class="stat-box no-page-break">
                                    <div class="stat-label">Lowest Score</div>
                                    <div class="stat-value" x-text="data.exam_stats.lowest_score + '%'"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Top 10 Leaderboard -->
                        <div class="no-page-break">
                            <div class="section-title">Top 10 Performers</div>
                            <table class="no-page-break">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Position</th>
                                        <th style="width: 50%;">Student Name</th>
                                        <th style="width: 20%;">Average (%)</th>
                                        <th style="width: 20%;">Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(student, idx) in data.students.slice(0, 10)" :key="student.student_id">
                                        <tr>
                                            <td style="font-weight: 600; color: #4F46E5;" x-text="idx + 1"></td>
                                            <td x-text="student.name"></td>
                                            <td style="text-align: right; font-weight: 500;" x-text="student.summary.average.toFixed(1)"></td>
                                            <td>
                                                <span class="grade-badge" :class="'grade-' + student.summary.grade.toLowerCase()" x-text="student.summary.grade"></span>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <!-- AI Performance Summary -->
                        <template x-if="aiSummary">
                            <div class="ai-summary no-page-break">
                                <div class="ai-summary-title">📊 AI Performance Analysis</div>
                                <div class="ai-summary-text prose dark:prose-invert" x-html="aiSummary"></div>
                            </div>
                        </template>
                    </div>

                    <!-- PAGE 2+: Full Results -->
                    <template x-for="(pageStudents, pageIdx) in paginatedStudents" :key="pageIdx">
                        <div class="print-page">
                            <div style="font-size: 0.75rem; color: #9ca3af; margin-bottom: 1.5rem; text-align: right;" x-text="'Page ' + (pageIdx + 2)"></div>

                            <div class="section-title" x-show="pageIdx === 0">Full Results</div>

                            <table>
                                <thead x-show="pageIdx === 0 || true">
                                    <tr>
                                        <th style="width: 8%;">Pos</th>
                                        <th style="width: 25%;">Student</th>
                                        <th style="width: 12%;">Total Q</th>
                                        <th style="width: 12%;">Attempted</th>
                                        <th style="width: 12%;">Correct</th>
                                        <th style="width: 15%;">Average (Rate)</th>
                                        <th style="width: 15%;">Average (Accuracy)</th>
                                        <th style="width: 8%;">Grade</th>
                                        <th style="width: 8%; text-align: center;">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="student in pageStudents" :key="student.student_id">
                                        <tr class="expandable-row no-page-break" @click="toggleExpand(student.student_id)">
                                            <td style="font-weight: 600; color: #4F46E5;" x-text="student.summary.position"></td>
                                            <td style="font-weight: 500;" x-text="student.name"></td>
                                            <td x-text="student.summary.total_questions"></td>
                                            <td x-text="student.summary.attempted"></td>
                                            <td x-text="student.summary.correct"></td>
                                            <td style="text-align: right; font-weight: 600; color: #374151;" x-text="student.summary.attempted > 0 ? (student.summary.correct / student.summary.total_questions * 100).toFixed(1) + '%' : '0.0%'"></td>
                                            <td style="text-align: right; font-weight: 600; color: #374151;" x-text="student.summary.average.toFixed(1)"></td>
                                            <td>
                                                <span class="grade-badge" :class="'grade-' + student.summary.grade.toLowerCase()" x-text="student.summary.grade"></span>
                                            </td>
                                            <td style="text-align: center; cursor: pointer; color: #4F46E5;" x-text="expandedStudents[student.student_id] ? '−' : '+'"></td>
                                        </tr>

                                        <!-- Subject Breakdown -->
                                        <template x-if="expandedStudents[student.student_id]">
                                            <tr class="no-page-break">
                                                <td style="padding: 0; border: none;" colspan="8">
                                                    <div class="subject-breakdown">
                                                        <table style="margin-top: 0.5rem;">
                                                            <thead>
                                                                <tr style="background: white;">
                                                                    <th style="background: white; font-size: 0.8rem; padding: 0.5rem;">Subject</th>
                                                                    <th style="background: white; font-size: 0.8rem; padding: 0.5rem; width: 10%;">Total Q</th>
                                                                    <th style="background: white; font-size: 0.8rem; padding: 0.5rem; width: 10%;">Attempted</th>
                                                                    <th style="background: white; font-size: 0.8rem; padding: 0.5rem; width: 10%;">Correct</th>
                                                                    <th style="background: white; font-size: 0.8rem; padding: 0.5rem; width: 12%;">Average (%)</th>
                                                                    <th style="background: white; font-size: 0.8rem; padding: 0.5rem; width: 8%;">Grade</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <template x-for="subject in student.subjects" :key="subject.subject_id">
                                                                    <tr>
                                                                        <td style="font-size: 0.875rem; font-weight: 500; padding: 0.5rem;" x-text="subject.title"></td>
                                                                        <td style="font-size: 0.875rem; padding: 0.5rem;" x-text="subject.total_questions"></td>
                                                                        <td style="font-size: 0.875rem; padding: 0.5rem;" x-text="subject.attempted"></td>
                                                                        <td style="font-size: 0.875rem; padding: 0.5rem;" x-text="subject.correct"></td>
                                                                        <td style="font-size: 0.875rem; padding: 0.5rem; font-weight: 600;" x-text="subject.average.toFixed(1)"></td>
                                                                        <td style="padding: 0.5rem;">
                                                                            <span class="grade-badge" style="font-size: 0.75rem; padding: 0.25rem 0.5rem; min-width: auto;" :class="'grade-' + subject.grade.toLowerCase()" x-text="subject.grade"></span>
                                                                        </td>
                                                                    </tr>
                                                                </template>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </template>
                                </tbody>
                            </table>

                            <!-- Page Footer -->
                            <div style="margin-top: 3rem; display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; font-size: 0.75rem; color: #6b7280;">
                                <div>
                                    <div style="font-weight: 600; margin-bottom: 0.25rem;" x-text="schoolName"></div>
                                    <div>Generated by QTimer</div>
                                </div>
                                <div style="text-align: right;">
                                    <div x-text="'Page ' + (pageIdx + 2)"></div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Final Page: Signatures -->
                    <div class="print-page">
                        <div style="margin-top: 5rem; page-break-before: always;">
                            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 3rem;">Official Certification</h3>

                            <div class="footer-section">
                                <div>
                                    <p style="font-weight: 500; margin-bottom: 1rem;">Principal Signature</p>
                                    <div class="signature-box"></div>
                                    <p style="margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;" x-text="principalName"></p>
                                    <p style="font-size: 0.875rem; color: #6b7280;">Principal</p>
                                </div>
                                <div>
                                    <p style="font-weight: 500; margin-bottom: 1rem;">School Stamp / Seal</p>
                                    <div class="stamp-area">
                                        School Stamp Area
                                    </div>
                                </div>
                            </div>

                            <div style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid #d1d5db; text-align: center; font-size: 0.75rem; color: #9ca3af;">
                                <p x-text="'This is an official record generated by QTimer on ' + currentDate"></p>
                                <p style="margin-top: 0.5rem;">Document ID: ' + documentId"></p>
                            </div>
                        </div>
                    </div>

                </div>
            </template>
        </div>

        <script>
            const defaultConfig = {
                school_name: 'QTimer',
                academic_year: '2025-2026',
                principal_name: 'QTimer',
                api_base_url: '/api/v1/qtimer',
                csrf_token: ''
            };

            let config = {
                ...defaultConfig
            };

            function resultsApp() {
                return {
                    // Config
                    schoolName: config.school_name || defaultConfig.school_name,
                    academicYear: config.academic_year || defaultConfig.academic_year,
                    principalName: config.principal_name || defaultConfig.principal_name,
                    apiBaseUrl: config.api_base_url || defaultConfig.api_base_url,
                    csrfToken: config.csrf_token || defaultConfig.csrf_token,

                    // State
                    exams: [],
                    selectedExamId: '',
                    data: null,
                    loading: false,
                    error: null,
                    expandedStudents: {},
                    aiSummary: '',
                    currentDate: '',
                    documentId: '',

                    // Computed
                    get paginatedStudents() {
                        if (!this.data) return [];
                        const studentsPerPage = 20;
                        const paginated = [];
                        for (let i = 0; i < this.data.students.length; i += studentsPerPage) {
                            paginated.push(this.data.students.slice(i, i + studentsPerPage));
                        }
                        return paginated;
                    },

                    // Initialize
                    async init() {
                        this.currentDate = new Date().toLocaleDateString('en-US', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        this.documentId = 'QT-' + Date.now();

                        // Initialize Element SDK
                        if (window.elementSdk) {
                            await window.elementSdk.init({
                                defaultConfig,
                                onConfigChange: async (newConfig) => {
                                    config = newConfig;
                                    this.schoolName = config.school_name || defaultConfig.school_name;
                                    this.academicYear = config.academic_year || defaultConfig.academic_year;
                                    this.principalName = config.principal_name || defaultConfig.principal_name;
                                    this.apiBaseUrl = config.api_base_url || defaultConfig.api_base_url;
                                    this.csrfToken = config.csrf_token || defaultConfig.csrf_token;
                                },
                                mapToCapabilities: (cfg) => ({
                                    recolorables: [{
                                        get: () => '#4F46E5',
                                        set: (v) => {
                                            window.elementSdk.setConfig({});
                                        }
                                    }],
                                    borderables: [],
                                    fontEditable: undefined,
                                    fontSizeable: undefined
                                }),
                                mapToEditPanelValues: (cfg) => new Map([
                                    ['school_name', cfg.school_name || defaultConfig.school_name],
                                    ['academic_year', cfg.academic_year || defaultConfig.academic_year],
                                    ['principal_name', cfg.principal_name || defaultConfig.principal_name],
                                    ['api_base_url', cfg.api_base_url || defaultConfig.api_base_url],
                                    ['csrf_token', cfg.csrf_token || defaultConfig.csrf_token]
                                ])
                            });
                        }

                        // Fetch exams list
                        await this.fetchExams();
                    },

                    // API Call
                    async apiCall(endpoint, options = {}) {
                        const url = `${this.apiBaseUrl}${endpoint}`;
                        const headers = {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        };

                        if (this.csrfToken) {
                            headers['X-CSRF-TOKEN'] = this.csrfToken;
                        }

                        try {
                            const response = await fetch(url, {
                                ...options,
                                headers: {
                                    ...headers,
                                    ...options.headers
                                }
                            });

                            if (!response.ok) {
                                throw new Error(`HTTP ${response.status}`);
                            }

                            return await response.json();
                        } catch (error) {
                            console.error('API Error:', error);
                            throw error;
                        }
                    },

                    // Fetch exams
                    async fetchExams() {
                        try {
                            this.error = null;
                            this.loading = true;
                            const data = await this.apiCall('/exams/all');
                            this.exams = data.exams || [];
                        } catch (error) {
                            this.error = 'Failed to load exams: ' + error.message;
                            console.error(error);
                        } finally {
                            this.loading = false;
                        }
                    },

                    // Load results
                    async loadResults() {
                        if (!this.selectedExamId) {
                            this.data = null;
                            this.error = 'Please select an exam';
                            return;
                        }

                        try {
                            this.error = null;
                            this.loading = true;
                            this.expandedStudents = {};

                            const data = await this.apiCall(`/exams/${this.selectedExamId}/results`);

                            // Sort by position
                            data.students = (data.students || []).sort((a, b) => {
                                return (a.summary?.position || 999) - (b.summary?.position || 999);
                            });

                            this.data = data;
                            this.generateAISummary();

                        } catch (error) {
                            this.error = 'Failed to load results: ' + error.message;
                            this.data = null;
                            console.error(error);
                        } finally {
                            this.loading = false;
                        }
                    },

                    async generateAISummary() {
                        if (!this.data) return;

                        const stats = this.data.exam_stats;

                        const prompt = `
                                    You are a Senior Academic Performance Analyst with over 15 years of experience in educational assessment, school performance evaluation, and student progress reporting.

                                    Your task is to generate a professional school-level performance report based strictly on the structured data provided below.

                                    EXAM DATA:
                                    ${JSON.stringify(this.data, null, 2)}

                                    ANALYSIS REQUIREMENTS:
                                    1. Provide an executive summary of overall performance.
                                    2. Interpret the exam average in academic context.
                                    3. Analyze the performance spread using:
                                    - Highest score
                                    - Lowest score
                                    - Score range (${stats.highest_score - stats.lowest_score})
                                    4. Comment on overall competitiveness and performance distribution.
                                    5. Highlight possible strengths and systemic weaknesses.
                                    6. Provide strategic academic recommendations for improvement.
                                    7. Maintain a formal institutional tone suitable for:
                                    - School board reports
                                    - Parent briefings
                                    - Administrative review

                                    OUTPUT FORMAT:

                                    - Return the report in HTML.
                                    - Use <strong> for bold headings (like Executive Summary), <em> for emphasis, <p> for paragraphs.
                                    - Include lists with <ul> / <li> if needed.
                                    - Make it ready to display in a browser with proper HTML formatting.
                                    - Avoid Markdown (**bold**) entirely.
                                    - Executive Summary
                                    - Performance Analysis
                                    - Distribution Insights
                                    - Institutional Observations
                                    - Strategic Recommendations

                                    Avoid repeating raw numbers unnecessarily.
                                    Write in clear, professional, analytical language.
                                    Do not invent data beyond what is provided.
                                    `;


                        try {
                            const response = await fetch('https://api.groq.com/openai/v1/chat/completions', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Authorization': `Bearer {{ config('services.GROQ_API_KEY') }}`
                                },
                                body: JSON.stringify({
                                    model: "llama-3.3-70b-versatile", // Or "mixtral-8x7b-32768"
                                    messages: [{
                                        role: "user",
                                        content: prompt
                                    }],
                                    temperature: 0.7,
                                    max_tokens: 150
                                })
                            });

                            const result = await response.json();

                            if (!response.ok) {
                                console.error("Groq API Error:", result.error?.message || "Unknown error");
                                this.aiSummary = "The AI service is currently unavailable.";
                                return;
                            }

                            if (result.choices && result.choices.length > 0) {
                                this.aiSummary = result.choices[0].message.content.trim();
                            } else {
                                this.aiSummary = "No summary was generated. Please try again.";
                            }

                        } catch (error) {
                            console.error("Network or Syntax Error:", error);
                            this.aiSummary = "Failed to connect to the AI service.";
                        }
                    },

                    // Toggle expand
                    toggleExpand(studentId) {
                        this.expandedStudents[studentId] = !this.expandedStudents[studentId];
                    },

                    // Print
                    printPage() {
                        window.print();
                    },

                    // Export PDF
                    exportPDF() {
                        alert('PDF export requires html2pdf library. For now, use "Print to PDF" from your browser.');
                        this.printPage();
                    },

                    // Refresh data
                    refreshData() {
                        if (this.selectedExamId) {
                            this.loadResults();
                        }
                    }
                };
            }
        </script>

    </body>

</html>
