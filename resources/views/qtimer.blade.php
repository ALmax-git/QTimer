<!doctype html>
<html class="h-full" lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>QTimer - Computer Based Test</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com/3.4.17"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'system-ui', 'sans-serif'],
                        },
                        colors: {
                            surface: {
                                light: '#f8fafc',
                                dark: '#0f172a'
                            }
                        }
                    }
                }
            }
        </script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
        <style>
            [x-cloak] {
                display: none !important;
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .dark .glass-card {
                background: rgba(30, 41, 59, 0.7);
                border: 1px solid rgba(71, 85, 105, 0.3);
            }

            .question-btn {
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .question-btn:hover {
                transform: translateY(-1px);
            }

            .fade-in {
                animation: fadeIn 0.3s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(8px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .pulse-ring {
                animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes pulse-ring {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }
            }

            .option-card {
                transition: all 0.2s ease;
            }

            .option-card:hover {
                transform: translateX(4px);
            }

            .timer-critical {
                animation: timer-pulse 1s ease-in-out infinite;
            }

            @keyframes timer-pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.6;
                }
            }

            .skeleton {
                background: linear-gradient(90deg, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
                background-size: 200% 100%;
                animation: skeleton-loading 1.5s infinite;
            }

            .dark .skeleton {
                background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%);
                background-size: 200% 100%;
            }

            @keyframes skeleton-loading {
                0% {
                    background-position: 200% 0;
                }

                100% {
                    background-position: -200% 0;
                }
            }
        </style>
        <style>
            body {
                box-sizing: border-box;
            }
        </style>
    </head>

    <body class="h-full bg-slate-50 font-sans transition-colors duration-300 dark:bg-slate-900" x-data="qtimerApp()" x-init="init()"><!-- Theme Toggle & Header -->
        <header class="glass-card fixed left-0 right-0 top-0 z-50 border-b border-slate-200/50 dark:border-slate-700/50">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between"><!-- Logo -->
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/25">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold text-slate-800 dark:text-white" x-text="appTitle">QTimer</h1>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->name }}</p>
                        </div>
                    </div><!-- Status & Controls -->
                    <div class="flex items-center gap-4"><!-- Server Status -->
                        <div class="hidden items-center gap-2 rounded-full px-3 py-1.5 sm:flex" :class="serverIsLive ? 'bg-emerald-100 dark:bg-emerald-900/30' : 'bg-amber-100 dark:bg-amber-900/30'"><span class="h-2 w-2 rounded-full" :class="serverIsLive ? 'bg-emerald-500 pulse-ring' : 'bg-amber-500'"></span> <span class="text-xs font-medium" :class="serverIsLive ? 'text-emerald-700 dark:text-emerald-400' : 'text-amber-700 dark:text-amber-400'" x-text="serverIsLive ? 'Connected' : 'Reconnecting...'"></span>
                        </div><!-- Theme Toggle -->
                        {{-- Quit/Exit --}}
                        <button class="rounded-xl bg-slate-100 p-2.5 transition-colors hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700" @click="quitExam()">
                            <svg class="h-5 w-5 text-slate-600" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg></button>
                        <button class="rounded-xl bg-slate-100 p-2.5 transition-colors hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700" @click="toggleTheme()">
                            <svg class="h-5 w-5 text-slate-600" x-show="!darkMode" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <svg class="h-5 w-5 text-amber-400" x-show="darkMode" x-cloak fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg></button>
                    </div>
                </div>
            </div>
        </header><!-- Main Content -->
        <main class="min-h-full px-4 pb-8 pt-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl"><!-- Loading State -->
                <template x-if="loading && !exam">
                    <div class="fade-in">
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <template x-for="i in 3">
                                <div class="glass-card rounded-2xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50">
                                    <div class="skeleton mb-4 h-6 w-3/4 rounded-lg"></div>
                                    <div class="skeleton mb-6 h-4 w-1/2 rounded-lg"></div>
                                    <div class="skeleton h-10 w-full rounded-xl"></div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template><!-- Exam List Screen -->
                <template x-if="currentScreen === 'list' && !loading">
                    <div class="fade-in">
                        <div class="mb-8">
                            <h2 class="mb-2 text-2xl font-bold text-slate-800 dark:text-white">Available Exams</h2>
                            <p class="text-slate-500 dark:text-slate-400">Select an exam to begin your assessment</p>
                        </div>
                        <template x-if="exams.length === 0">
                            <div class="glass-card rounded-2xl p-12 text-center shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50">
                                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-800">
                                    <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-lg font-semibold text-slate-700 dark:text-slate-300">No Exams Available</h3>
                                <p class="text-slate-500 dark:text-slate-400">Check back later for upcoming assessments</p><button class="mt-6 rounded-xl bg-indigo-500 px-6 py-2.5 font-medium text-white transition-colors hover:bg-indigo-600" @click="fetchExams()"> Refresh </button>
                            </div>
                        </template>
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <template x-for="exam in exams" :key="exam.id">
                                <div class="glass-card group rounded-2xl p-6 shadow-xl shadow-slate-200/50 transition-all duration-300 hover:shadow-2xl dark:shadow-slate-900/50">
                                    <div class="mb-4 flex items-start justify-between">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/25 transition-transform group-hover:scale-110">
                                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <template x-if="exam.is_mock"><span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-700 dark:bg-amber-900/30 dark:text-amber-400"> Mock Test </span>
                                        </template>
                                    </div>
                                    <h3 class="mb-2 text-lg font-semibold text-slate-800 dark:text-white" x-text="exam.title"></h3>
                                    <div class="mb-6 space-y-2">
                                        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg><span x-text="formatDate(exam.start_time)"></span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg><span x-text="formatDuration(exam.finish_time - exam.start_time)"></span>
                                        </div>
                                    </div><button class="w-full rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-3 font-medium text-white shadow-lg shadow-indigo-500/25 transition-all hover:from-indigo-600 hover:to-purple-700 hover:shadow-xl hover:shadow-indigo-500/30 disabled:cursor-not-allowed disabled:opacity-50" @click="startExam(exam.id)" :disabled="loading"> <span x-show="!examLoading[exam.id]">Start Exam</span> <span class="flex items-center justify-center gap-2" x-show="examLoading[exam.id]">
                                            <svg class="h-5 w-5 animate-spin" fill="none" viewbox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                            </svg> Loading... </span> </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </template><!-- Exam Screen -->
                <template x-if="currentScreen === 'exam'">
                    <div class="fade-in">
                        <div class="grid gap-6 lg:grid-cols-[1fr_320px]"><!-- Main Question Area -->
                            <div class="space-y-6"><!-- Exam Header -->
                                <div class="glass-card rounded-2xl p-4 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50">
                                    <div class="flex flex-wrap items-center justify-between gap-4">
                                        <div>
                                            <h2 class="text-xl font-bold text-slate-800 dark:text-white" x-text="exam.title"></h2>
                                            <p class="text-sm text-slate-500 dark:text-slate-400">Question <span x-text="currentQuestionIndex + 1"></span> of <span x-text="flatQuestions.length"></span></p>
                                        </div><!-- Timer -->
                                        <div class="flex items-center gap-3 rounded-xl px-4 py-2" :class="remainingTime <= 300 ? 'bg-rose-100 dark:bg-rose-900/30 timer-critical' : 'bg-slate-100 dark:bg-slate-800'">
                                            <svg class="h-5 w-5" :class="remainingTime <= 300 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-600 dark:text-slate-400'" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg><span class="font-mono text-lg font-bold" :class="remainingTime <= 300 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-800 dark:text-white'" x-text="formatTime(remainingTime)"></span>
                                        </div>
                                    </div>
                                </div><!-- Subject Tabs -->
                                <div class="glass-card rounded-2xl p-2 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50">
                                    <div class="scrollbar-hide flex gap-1 overflow-x-auto pb-1">
                                        <template x-for="subject in subjects" :key="subject.id"><button class="flex-shrink-0 rounded-xl px-4 py-2.5 text-sm font-medium transition-all" @click="switchSubject(subject.id)" :class="currentSubjectId === subject.id ?
                                            'bg-indigo-500 text-white shadow-lg shadow-indigo-500/25' :
                                            'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"> <span x-text="subject.title"></span> <span class="ml-1.5 text-xs opacity-75" x-text="'(' + subject.questions.length + ')'"></span> </button>
                                        </template>
                                    </div>
                                </div><!-- Question Card -->
                                <div class="glass-card min-h-[400px] rounded-2xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50">
                                    <template x-if="currentQuestion">
                                        <div class="fade-in"><!-- Question Text -->
                                            <div class="mb-6">
                                                <div class="mb-4 flex items-start gap-4"><span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-lg font-bold text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400" x-text="currentQuestionIndex + 1"></span>
                                                    <p class="pt-1.5 text-lg leading-relaxed text-slate-800 dark:text-white" x-text="currentQuestion.text"></p>
                                                </div><!-- Question Image -->
                                                <template x-if="currentQuestion.image">
                                                    <div class="mt-4 overflow-hidden rounded-xl bg-slate-100 dark:bg-slate-800"><img class="mx-auto h-auto max-w-full" :src="currentQuestion.image" :alt="'Question ' + (currentQuestionIndex + 1) + ' image'" loading="lazy" onerror="console.error('Image failed to load:', this.src); this.style.display='none';">
                                                    </div>
                                                </template>
                                            </div><!-- Options -->
                                            <div class="space-y-3">
                                                <template x-for="(option, idx) in currentQuestion.options" :key="option.id"><button class="option-card w-full rounded-xl border-2 p-4 text-left transition-all" @click="selectAnswer(currentQuestion.id, option.id)" :class="selectedAnswers[currentQuestion.id] === option.id ?
                                                    'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' :
                                                    'border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 bg-white dark:bg-slate-800/50'">
                                                        <div class="flex items-center gap-4"><span class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg text-sm font-bold transition-colors" :class="selectedAnswers[currentQuestion.id] === option.id ?
                                                            'bg-indigo-500 text-white' :
                                                            'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400'" x-text="String.fromCharCode(65 + idx)"></span> <span class="text-slate-700 dark:text-slate-300" x-text="option.option"></span>
                                                        </div>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div><!-- Navigation Buttons -->
                                <div class="glass-card rounded-2xl p-4 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50">
                                    <div class="flex items-center justify-between gap-4"><button class="flex items-center gap-2 rounded-xl bg-slate-100 px-5 py-2.5 font-medium text-slate-700 transition-colors hover:bg-slate-200 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700" @click="prevQuestion()" :disabled="currentQuestionIndex === 0">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                            </svg> Previous </button>
                                        <div class="flex items-center gap-2"><button class="rounded-xl px-4 py-2.5 text-slate-500 transition-colors hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800" @click="clearAnswer()" x-show="selectedAnswers[currentQuestion?.id]"> Clear </button> <button class="rounded-xl bg-emerald-500 px-5 py-2.5 font-medium text-white shadow-lg shadow-emerald-500/25 transition-all hover:bg-emerald-600" @click="showSubmitModal = true"> Submit Exam </button>
                                        </div><button class="flex items-center gap-2 rounded-xl bg-indigo-500 px-5 py-2.5 font-medium text-white shadow-lg shadow-indigo-500/25 transition-all hover:bg-indigo-600 disabled:cursor-not-allowed disabled:opacity-50" @click="nextQuestion()" :disabled="currentQuestionIndex === flatQuestions.length - 1"> Next
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg></button>
                                    </div>
                                </div>
                            </div><!-- Sidebar - Question Navigator -->
                            <div class="h-fit space-y-4 lg:sticky lg:top-24"><!-- Progress Card -->
                                <div class="glass-card rounded-2xl p-5 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50">
                                    <h3 class="mb-3 text-sm font-semibold text-slate-800 dark:text-white">Progress</h3>
                                    <div class="mb-3 flex items-center gap-4">
                                        <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-700">
                                            <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 transition-all duration-500" :style="'width: ' + (Object.keys(selectedAnswers).length / flatQuestions.length * 100) + '%'"></div>
                                        </div><span class="text-sm font-medium text-slate-600 dark:text-slate-400" x-text="Object.keys(selectedAnswers).length + '/' + flatQuestions.length"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2 text-center">
                                        <div class="rounded-lg bg-indigo-50 p-2 dark:bg-indigo-900/20">
                                            <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400" x-text="Object.keys(selectedAnswers).length"></p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">Answered</p>
                                        </div>
                                        <div class="rounded-lg bg-amber-50 p-2 dark:bg-amber-900/20">
                                            <p class="text-lg font-bold text-amber-600 dark:text-amber-400" x-text="flatQuestions.length - Object.keys(selectedAnswers).length"></p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">Remaining</p>
                                        </div>
                                        <div class="rounded-lg bg-slate-50 p-2 dark:bg-slate-800">
                                            <p class="text-lg font-bold text-slate-600 dark:text-slate-400" x-text="flatQuestions.length"></p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">Total</p>
                                        </div>
                                    </div>
                                </div><!-- Question Grid -->
                                <div class="glass-card rounded-2xl p-5 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50">
                                    <h3 class="mb-3 text-sm font-semibold text-slate-800 dark:text-white">Questions</h3>
                                    <div class="grid max-h-[300px] grid-cols-5 gap-2 overflow-y-auto pr-1">
                                        <template x-for="(q, idx) in flatQuestions" :key="q.id">
                                            <button class="question-btn flex aspect-square w-full items-center justify-center rounded-lg text-sm font-medium transition-all" @click="jumpToQuestion(idx)" :class="{
                                                'bg-indigo-500 text-white shadow-lg shadow-indigo-500/25': currentQuestionIndex === idx,
                                                'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400': currentQuestionIndex !== idx && selectedAnswers[q.id],
                                                'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700': currentQuestionIndex !== idx && !selectedAnswers[q.id]
                                            }" x-text="idx + 1">
                                            </button>
                                        </template>

                                    </div><!-- Legend -->
                                    <div class="mt-4 space-y-2 border-t border-slate-200 pt-4 dark:border-slate-700">
                                        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400"><span class="h-4 w-4 rounded bg-indigo-500"></span> <span>Current</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400"><span class="h-4 w-4 rounded bg-emerald-100 dark:bg-emerald-900/30"></span> <span>Answered</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400"><span class="h-4 w-4 rounded bg-slate-100 dark:bg-slate-800"></span> <span>Not Answered</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template><!-- Result Screen -->
                <template x-if="currentScreen === 'result'">
                    <div class="fade-in mx-auto max-w-lg">
                        <div class="glass-card rounded-3xl p-8 text-center shadow-2xl shadow-slate-200/50 dark:shadow-slate-900/50"><!-- Success Icon -->
                            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 shadow-xl shadow-emerald-500/30">
                                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h2 class="mb-2 text-2xl font-bold text-slate-800 dark:text-white">Exam Submitted!</h2>
                            <p class="mb-8 text-slate-500 dark:text-slate-400" x-text="result.message || 'Your answers have been recorded successfully.'"></p><!-- Score Display -->
                            <div class="mb-8 rounded-2xl bg-gradient-to-br from-indigo-50 to-purple-50 p-6 dark:from-indigo-900/20 dark:to-purple-900/20">
                                <p class="mb-2 text-sm text-slate-500 dark:text-slate-400">Your Score</p>
                                <div class="flex items-baseline justify-center gap-1"><span class="text-5xl font-bold text-indigo-600 dark:text-indigo-400" x-text="result.score"></span> <span class="text-2xl text-slate-400 dark:text-slate-500">/</span> <span class="text-2xl text-slate-600 dark:text-slate-400" x-text="result.total"></span>
                                </div>
                                <div class="mt-4 h-3 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-700">
                                    <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 transition-all duration-1000" :style="'width: ' + (result.score / result.total * 100) + '%'"></div>
                                </div>
                                <p class="mt-2 text-sm font-medium" :class="result.score / result.total >= 0.5 ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400'" x-text="Math.round(result.score / result.total * 100) + '% Score'"></p>
                            </div>
                            <button class="w-full rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-3 font-medium text-white shadow-lg shadow-indigo-500/25 transition-all hover:from-indigo-600 hover:to-purple-700" @click="backToList()"> Back to Exams </button>
                        </div>
                    </div>
                </template>
            </div>
        </main><!-- Submit Confirmation Modal -->
        <template x-if="showSubmitModal">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak><!-- Backdrop -->
                <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showSubmitModal = false"></div><!-- Modal -->
                <div class="glass-card fade-in relative w-full max-w-md rounded-2xl p-6 shadow-2xl">
                    <div class="text-center">
                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-amber-100 dark:bg-amber-900/30">
                            <svg class="h-7 w-7 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold text-slate-800 dark:text-white">Submit Exam?</h3>
                        <p class="mb-2 text-slate-500 dark:text-slate-400">You are about to submit your exam.</p>
                        <div class="mb-6 rounded-xl bg-slate-100 p-4 dark:bg-slate-800">
                            <div class="flex justify-between text-sm"><span class="text-slate-500 dark:text-slate-400">Answered</span> <span class="font-semibold text-slate-800 dark:text-white" x-text="Object.keys(selectedAnswers).length + ' / ' + flatQuestions.length"></span>
                            </div>
                            <template x-if="flatQuestions.length - Object.keys(selectedAnswers).length > 0">
                                <p class="mt-2 text-xs text-amber-600 dark:text-amber-400">⚠️ You have <span x-text="flatQuestions.length - Object.keys(selectedAnswers).length"></span> unanswered questions</p>
                            </template>
                        </div>
                        <div class="flex gap-3"><button class="flex-1 rounded-xl bg-slate-100 px-4 py-3 font-medium text-slate-700 transition-colors hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700" @click="showSubmitModal = false"> Cancel </button> <button class="flex-1 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 px-4 py-3 font-medium text-white shadow-lg shadow-emerald-500/25 transition-all hover:from-emerald-600 hover:to-teal-700 disabled:opacity-50" @click="submitExam()" :disabled="submitting"> <span x-show="!submitting">Submit Now</span> <span class="flex items-center justify-center gap-2" x-show="submitting">
                                    <svg class="h-5 w-5 animate-spin" fill="none" viewbox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                    </svg> Submitting... </span> </button>
                        </div>
                    </div>
                </div>
            </div>
        </template><!-- Server Disconnected Overlay --><template x-if="!serverIsLive && currentScreen === 'exam'">

            <h1> CBT </h1>
            <div class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/80 p-4 backdrop-blur-sm" x-cloak>
                <div class="glass-card w-full max-w-sm rounded-2xl p-8 text-center shadow-2xl">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-100 dark:bg-amber-900/30">
                        <svg class="h-8 w-8 animate-pulse text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3" />
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-slate-800 dark:text-white">Connection Lost</h3>
                    <p class="mb-4 text-slate-500 dark:text-slate-400">Please wait while we reconnect to the server...</p>
                    <div class="flex items-center justify-center gap-2">
                        <div class="h-2 w-2 animate-bounce rounded-full bg-amber-500" style="animation-delay: 0ms"></div>
                        <div class="h-2 w-2 animate-bounce rounded-full bg-amber-500" style="animation-delay: 150ms"></div>
                        <div class="h-2 w-2 animate-bounce rounded-full bg-amber-500" style="animation-delay: 300ms"></div>
                    </div>
                </div>
            </div>
        </template><!-- Toast Notification -->
        <div class="fixed bottom-6 left-1/2 z-50 -translate-x-1/2" x-show="toast.show" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2">
            <div class="flex items-center gap-3 rounded-xl px-6 py-3 shadow-xl" :class="toast.type === 'error' ? 'bg-rose-500 text-white' : 'bg-emerald-500 text-white'">
                <svg class="h-5 w-5" x-show="toast.type === 'success'" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <svg class="h-5 w-5" x-show="toast.type === 'error'" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg><span x-text="toast.message"></span>
            </div>
        </div>
        <script>
            // Default configuration
            const defaultConfig = {
                app_title: 'QTimer',
                api_base_url: '/api/v1/qtimer',
                background_color: '#f8fafc',
                surface_color: '#ffffff',
                text_color: '#1e293b',
                primary_action_color: '#6366f1',
                secondary_action_color: '#64748b'
            };

            // Global config reference
            let config = {
                ...defaultConfig
            };

            function qtimerApp() {
                return {
                    // Config properties
                    appTitle: config.app_title || defaultConfig.app_title,
                    apiBaseUrl: config.api_base_url || defaultConfig.api_base_url,

                    // Theme
                    darkMode: false,
                    tempFix: null,

                    // Screens: 'list', 'exam', 'result'
                    currentScreen: 'list',

                    // Loading states
                    loading: false,
                    examLoading: {},
                    submitting: false,

                    // Exam list
                    exams: [],

                    // Current exam data
                    exam: null,
                    subjects: [],
                    flatQuestions: [],
                    currentQuestionIndex: 0,
                    currentSubjectId: null,
                    selectedAnswers: {},
                    resultId: null,

                    // Timer
                    remainingTime: 0,
                    serverTimeOffset: 0,
                    timerInterval: null,
                    heartbeatInterval: null,

                    // Server status
                    serverIsLive: true,

                    // Result
                    result: {},

                    // UI state
                    showSubmitModal: false,
                    toast: {
                        show: false,
                        message: '',
                        type: 'success'
                    },

                    // Initialize
                    async init() {
                        // Initialize theme from localStorage
                        this.darkMode = localStorage.getItem('qtimer_theme') === 'dark';
                        this.applyTheme();

                        // Restore state from localStorage if exists
                        this.restoreState();

                        // Initialize Element SDK
                        if (window.elementSdk) {
                            await window.elementSdk.init({
                                defaultConfig,
                                onConfigChange: async (newConfig) => {
                                    config = newConfig;
                                    this.appTitle = config.app_title || defaultConfig.app_title;
                                    this.apiBaseUrl = config.api_base_url || defaultConfig.api_base_url;
                                    this.applyColors();
                                },
                                mapToCapabilities: (cfg) => ({
                                    recolorables: [{
                                            get: () => cfg.background_color || defaultConfig.background_color,
                                            set: (v) => {
                                                cfg.background_color = v;
                                                window.elementSdk.setConfig({
                                                    background_color: v
                                                });
                                            }
                                        },
                                        {
                                            get: () => cfg.surface_color || defaultConfig.surface_color,
                                            set: (v) => {
                                                cfg.surface_color = v;
                                                window.elementSdk.setConfig({
                                                    surface_color: v
                                                });
                                            }
                                        },
                                        {
                                            get: () => cfg.text_color || defaultConfig.text_color,
                                            set: (v) => {
                                                cfg.text_color = v;
                                                window.elementSdk.setConfig({
                                                    text_color: v
                                                });
                                            }
                                        },
                                        {
                                            get: () => cfg.primary_action_color || defaultConfig.primary_action_color,
                                            set: (v) => {
                                                cfg.primary_action_color = v;
                                                window.elementSdk.setConfig({
                                                    primary_action_color: v
                                                });
                                            }
                                        },
                                        {
                                            get: () => cfg.secondary_action_color || defaultConfig.secondary_action_color,
                                            set: (v) => {
                                                cfg.secondary_action_color = v;
                                                window.elementSdk.setConfig({
                                                    secondary_action_color: v
                                                });
                                            }
                                        }
                                    ],
                                    borderables: [],
                                    fontEditable: undefined,
                                    fontSizeable: undefined
                                }),
                                mapToEditPanelValues: (cfg) => new Map([
                                    ['app_title', cfg.app_title || defaultConfig.app_title],
                                    ['api_base_url', cfg.api_base_url || defaultConfig.api_base_url]
                                ])
                            });
                        }

                        // Fetch exams if not in exam screen
                        if (this.currentScreen === 'list') {
                            await this.fetchExams();
                        }

                        // Save state periodically
                        setInterval(() => this.saveState(), 5000);
                    },

                    // Theme toggle
                    toggleTheme() {
                        this.darkMode = !this.darkMode;
                        localStorage.setItem('qtimer_theme', this.darkMode ? 'dark' : 'light');
                        this.applyTheme();
                    },

                    applyTheme() {
                        if (this.darkMode) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    },
                    quitExam() {
                        if (confirm('Are you sure you want to quit the exam? Your progress will be lost.')) {
                            this.stopTimer();
                            this.stopHeartbeat();
                            this.currentScreen = 'list';
                            this.exam = null;
                            this.subjects = [];
                            this.flatQuestions = [];
                            this.selectedAnswers = {};
                            this.resultId = null;
                            this.remainingTime = 0;
                            this.serverTimeOffset = 0;
                            // redirect to /log_out to clear session
                            window.location.href = '/logout';
                        }
                    },

                    applyColors() {
                        // Apply custom colors via CSS variables if needed
                        const root = document.documentElement;
                        root.style.setProperty('--bg-color', config.background_color || defaultConfig.background_color);
                        root.style.setProperty('--surface-color', config.surface_color || defaultConfig.surface_color);
                        root.style.setProperty('--text-color', config.text_color || defaultConfig.text_color);
                        root.style.setProperty('--primary-color', config.primary_action_color || defaultConfig.primary_action_color);
                        root.style.setProperty('--secondary-color', config.secondary_action_color || defaultConfig.secondary_action_color);
                    },
                    getCsrfToken() {
                        const meta = document.querySelector('meta[name="csrf-token"]');
                        console.log('CSRF Token:', meta ? meta.getAttribute('content') : 'Not found');
                        return meta ? meta.getAttribute('content') : '';
                    },
                    // API helper
                    async apiCall(endpoint, options = {}) {
                        const url = `${this.apiBaseUrl}${endpoint}`;
                        const defaultOptions = {
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.getCsrfToken()
                            },
                            credentials: 'include'
                        };

                        try {
                            const response = await fetch(url, {
                                ...defaultOptions,
                                ...options
                            });
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return await response.json();
                        } catch (error) {
                            console.error('API Error:', error);
                            throw error;
                        }
                    },

                    // Fetch exam list
                    async fetchExams() {
                        this.loading = true;
                        try {
                            const data = await this.apiCall('/exams');
                            this.exams = data.exams || [];
                        } catch (error) {
                            this.showToast('Failed to load exams. Please try again.', 'error');
                        } finally {
                            this.loading = false;
                        }
                    },

                    // Start exam
                    async startExam(examId) {
                        this.examLoading[examId] = true;
                        try {
                            const data = await this.apiCall(`/exams/${examId}/start`, {
                                method: 'POST'
                            });

                            this.exam = {
                                id: data.exam_id,
                                title: data.title,
                                status: data.status
                            };
                            this.tempFix = this.exam;
                            console.log(this.exam == null, data.status, data.exam_id, data.title);
                            if (data.status === 'submitted') {

                                this.exam = {
                                    id: data.exam_id,
                                    title: data.title,
                                    status: 'submitted'
                                };

                                this.score = data.score || null;
                                this.totalQuestions = data.total || null;

                                this.currentScreen = 'list';

                                this.showToast('This exam has already been submitted.', 'info');

                                console.log('Exam status:', data.status, );
                                return;
                            }
                            this.subjects = data.subjects || [];
                            this.resultId = data.result_id;
                            this.remainingTime = data.remaining_time;
                            this.serverTimeOffset = Math.floor(Date.now() / 1000) - data.server_time;
                            // Build flat question list
                            this.flatQuestions = [];
                            this.subjects.forEach(subject => {
                                subject.questions.forEach(q => {
                                    this.flatQuestions.push({
                                        ...q,
                                        subjectId: subject.id,
                                        subjectTitle: subject.title
                                    });
                                });
                            });

                            // Set initial subject
                            if (this.subjects.length > 0) {
                                this.currentSubjectId = this.subjects[0].id;
                            }

                            // Restore previously attempted answers
                            if (data.attempted && Array.isArray(data.attempted)) {
                                // Mark attempted questions (actual answers would need separate endpoint)
                                data.attempted.forEach(qId => {
                                    this.selectedAnswers[qId] = true; // Mark as attempted (option ID not known)
                                });
                            }

                            // Switch screen
                            this.currentScreen = 'exam';

                            // Start timer
                            this.startTimer();

                            // Start heartbeat
                            this.startHeartbeat();


                            // Save state
                            this.saveState();
                            console.log([this.currentScreen, this.exam, this.subjects]);
                            this.showToast('Exam started successfully. Good luck!', 'success');
                            // this.restoreState();
                        } catch (error) {
                            console.error('Failed to start exam:', error);
                            this.showToast('Failed to start exam. Please try again.', 'error');
                        } finally {
                            this.examLoading[examId] = false;
                        }
                    },

                    // Timer management
                    startTimer() {
                        if (this.timerInterval) clearInterval(this.timerInterval);

                        this.timerInterval = setInterval(() => {
                            if (this.remainingTime > 0) {
                                this.remainingTime--;

                                // Auto-submit when time runs out
                                if (this.remainingTime <= 0) {
                                    this.showToast('Time is up! Submitting your exam...', 'error');
                                    this.submitExam();
                                }
                            }
                        }, 1000);
                    },

                    stopTimer() {
                        if (this.timerInterval) {
                            clearInterval(this.timerInterval);
                            this.timerInterval = null;
                        }
                    },

                    // Heartbeat
                    startHeartbeat() {
                        if (this.heartbeatInterval) clearInterval(this.heartbeatInterval);

                        // Random interval between 20-30 seconds
                        const interval = 20000 + Math.random() * 10000;

                        this.heartbeatInterval = setInterval(async () => {
                            await this.sendHeartbeat();
                        }, interval);
                    },

                    stopHeartbeat() {
                        if (this.heartbeatInterval) {
                            clearInterval(this.heartbeatInterval);
                            this.heartbeatInterval = null;
                        }
                    },

                    async sendHeartbeat() {
                        if (!this.exam) return;

                        try {
                            const data = await this.apiCall(`/exams/${this.exam.id}/heartbeat`, {
                                method: 'POST'
                            });

                            // Sync time with server
                            this.remainingTime = data.remaining_time;
                            this.serverTimeOffset = Math.floor(Date.now() / 1000) - data.server_time;
                            this.serverIsLive = data.server_is_live;

                        } catch (error) {
                            this.serverIsLive = false;
                            console.error('Heartbeat failed:', error);
                        }
                    },

                    // Question navigation
                    get currentQuestion() {
                        return this.flatQuestions[this.currentQuestionIndex] || null;
                    },

                    nextQuestion() {
                        if (this.currentQuestionIndex < this.flatQuestions.length - 1) {
                            this.currentQuestionIndex++;
                            this.updateCurrentSubject();
                        }
                    },

                    prevQuestion() {
                        if (this.currentQuestionIndex > 0) {
                            this.currentQuestionIndex--;
                            this.updateCurrentSubject();
                        }
                    },

                    jumpToQuestion(index) {
                        this.currentQuestionIndex = index;
                        this.updateCurrentSubject();
                    },

                    updateCurrentSubject() {
                        const question = this.currentQuestion;
                        if (question) {
                            this.currentSubjectId = question.subjectId;
                        }
                    },

                    switchSubject(subjectId) {
                        this.currentSubjectId = subjectId;
                        // Jump to first question of this subject
                        const index = this.flatQuestions.findIndex(q => q.subjectId === subjectId);
                        if (index !== -1) {
                            this.currentQuestionIndex = index;
                        }
                    },

                    // Answer selection
                    selectAnswer(questionId, optionId) {
                        this.selectedAnswers[questionId] = optionId;
                        this.saveState();
                    },

                    clearAnswer() {
                        if (this.currentQuestion) {
                            delete this.selectedAnswers[this.currentQuestion.id];
                            this.saveState();
                        }
                    },

                    // Submit exam
                    async submitExam() {
                        // console.log(this.exam)
                        this.exam = this.exam || this.tempFix;

                        if (!this.exam || !this.exam.id) {
                            console.log(["Exam data is missing:", this.exam, "Temp", this.tempFix]);
                            // alert('Exam data is missing.');
                            return;
                        }
                        console.log(["Exam :", this.exam, "Temp", this.tempFix]);
                        // return; // Temporary return to prevent submission during testing
                        if (this.submitting) return;

                        this.submitting = true;
                        this.showSubmitModal = false;

                        try {
                            // Build answers array
                            const answers = Object.entries(this.selectedAnswers).map(([questionId, optionId]) => ({
                                question_id: parseInt(questionId),
                                option_id: optionId
                            }));

                            const data = await this.apiCall(`/exams/${this.exam.id}/submit`, {
                                method: 'POST',
                                body: JSON.stringify({
                                    result_id: this.resultId,
                                    answers: answers
                                })
                            });

                            // Stop timers
                            this.stopTimer();
                            this.stopHeartbeat();

                            // Store result
                            this.result = {
                                message: data.message,
                                score: data.score,
                                total: data.total
                            };

                            // Clear saved state
                            this.clearSavedState();

                            // Show result
                            this.currentScreen = 'result';

                        } catch (error) {
                            console.error('Submission failed:', error);
                            this.showToast('Failed to submit exam. Please try again.', 'error');
                        } finally {
                            this.submitting = false;
                        }
                    },

                    // Back to list
                    backToList() {
                        this.exam = null;
                        this.subjects = [];
                        this.flatQuestions = [];
                        this.currentQuestionIndex = 0;
                        this.selectedAnswers = {};
                        this.result = {};
                        this.currentScreen = 'list';
                        this.fetchExams();
                    },

                    // State persistence
                    saveState() {
                        if (!this.exam) return;

                        const state = {
                            exam: this.exam,
                            subjects: this.subjects,
                            flatQuestions: this.flatQuestions,
                            currentQuestionIndex: this.currentQuestionIndex,
                            currentSubjectId: this.currentSubjectId,
                            selectedAnswers: this.selectedAnswers,
                            resultId: this.resultId,
                            remainingTime: this.remainingTime,
                            currentScreen: this.currentScreen,
                            savedAt: Date.now()
                        };

                        localStorage.setItem('qtimer_state', JSON.stringify(state));
                    },

                    restoreState() {
                        const saved = localStorage.getItem('qtimer_state');
                        if (!saved) return;

                        try {
                            const state = JSON.parse(saved);

                            // Check if state is recent (within last hour)
                            if (Date.now() - state.savedAt > 3600000) {
                                this.clearSavedState();
                                return;
                            }

                            this.exam = state.exam;
                            this.subjects = state.subjects;
                            this.flatQuestions = state.flatQuestions;
                            this.currentQuestionIndex = state.currentQuestionIndex;
                            this.currentSubjectId = state.currentSubjectId;
                            this.selectedAnswers = state.selectedAnswers;
                            this.resultId = state.resultId;
                            this.remainingTime = state.remainingTime;
                            this.currentScreen = state.currentScreen;

                            if (this.currentScreen === 'exam' && this.exam) {
                                this.startTimer();
                                this.startHeartbeat();
                            }

                        } catch (error) {
                            console.error('Failed to restore state:', error);
                            this.clearSavedState();
                        }
                    },

                    clearSavedState() {
                        localStorage.removeItem('qtimer_state');
                    },

                    // Toast notifications
                    showToast(message, type = 'success') {
                        this.toast = {
                            show: true,
                            message,
                            type
                        };
                        setTimeout(() => {
                            this.toast.show = false;
                        }, 4000);
                    },

                    // Formatting helpers
                    formatTime(seconds) {
                        if (seconds <= 0) return '00:00:00';
                        const hrs = Math.floor(seconds / 3600);
                        const mins = Math.floor((seconds % 3600) / 60);
                        const secs = seconds % 60;
                        return `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                    },

                    formatDate(timestamp) {
                        const date = new Date(timestamp * 1000);
                        return date.toLocaleDateString('en-US', {
                            weekday: 'short',
                            month: 'short',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    },

                    formatDuration(seconds) {
                        const hours = Math.floor(seconds / 3600);
                        const minutes = Math.floor((seconds % 3600) / 60);
                        if (hours > 0) {
                            return `${hours}h ${minutes}m`;
                        }
                        return `${minutes} minutes`;
                    }
                };
            }
        </script>
        <script>
            (function() {
                function c() {
                    var b = a.contentDocument || a.contentWindow.document;
                    if (b) {
                        var d = b.createElement('script');
                        d.innerHTML = "window.__CF$cv$params={r:'9ce7da0550744813',t:'MTc3MTE5MDQ1Mi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";
                        b.getElementsByTagName('head')[0].appendChild(d)
                    }
                }
                if (document.body) {
                    var a = document.createElement('iframe');
                    a.height = 1;
                    a.width = 1;
                    a.style.position = 'absolute';
                    a.style.top = 0;
                    a.style.left = 0;
                    a.style.border = 'none';
                    a.style.visibility = 'hidden';
                    document.body.appendChild(a);
                    if ('loading' !== document.readyState) c();
                    else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c);
                    else {
                        var e = document.onreadystatechange || function() {};
                        document.onreadystatechange = function(b) {
                            e(b);
                            'loading' !== document.readyState && (document.onreadystatechange = e, c())
                        }
                    }
                }
            })();
        </script>
    </body>

</html>
