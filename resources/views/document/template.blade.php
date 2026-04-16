@php
    $hideDashboard = true;
@endphp
@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    
    <!-- Enhanced Header -->
    <div class="relative mb-10">
        <div class="absolute -top-6 -left-6 w-40 h-40 bg-blue-200/30 rounded-full blur-3xl"></div>
        <div class="relative flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg shadow-blue-200/40">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-800">Template Studio</h1>
                    <p class="text-gray-500 mt-1 max-w-xl">Design dynamic document templates with smart variables — preview, edit, and manage effortlessly.</p>
                </div>
            </div>
            <div class="flex items-center gap-2 bg-white/60 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm border border-gray-100">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                </span>
                <span class="text-xs font-medium text-gray-600">Live templates</span>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-7 animate-fade-in-up" id="successToast">
            <div class="bg-white border-l-4 border-emerald-500 rounded-xl shadow-card p-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 bg-emerald-100 rounded-full p-1.5">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-800">{{ session('success') }}</p>
                </div>
                <button onclick="this.closest('#successToast')?.remove()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Create / Edit Card -->
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-card border border-gray-100/80 mb-10 overflow-hidden transition-all duration-300" id="formCard">
        <div class="relative px-6 py-5 border-b border-gray-100 bg-white">
            <div class="flex items-center gap-2.5">
                <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800" id="formTitle">Create new template</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Fill the details and use variables with @{{ ... }}</p>
                </div>
            </div>
        </div>
        
        <div class="p-6 md:p-7">
            <form method="POST" id="templateForm" action="{{ route('template.store') }}">
                @csrf
                <input type="hidden" name="id" id="template_id">

                <!-- Template Name -->
                <div class="mb-6 group">
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        Template name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="name" id="template_name_input" 
                            placeholder="e.g., Booking Confirmation, Invoice, Welcome Letter"
                            class="w-full pl-4 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200 text-gray-800"
                            required>
                    </div>
                </div>

                <!-- Template HTML area -->
                <div class="mb-6">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                            HTML content <span class="text-red-500">*</span>
                        </label>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Insert variable:</span>
                            <div class="flex gap-2">
                                <button type="button" onclick="window.insertVariable('customer_name')" class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition">@{{customer_name}}</button>
                                <button type="button" onclick="window.insertVariable('booking_id')" class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition">@{{booking_id}}</button>
                                <button type="button" onclick="window.insertVariable('date')" class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition">@{{date}}</button>
                                <button type="button" onclick="window.insertVariable('total_amount')" class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 transition">@{{total_amount}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="relative rounded-xl overflow-hidden border border-gray-200 focus-within:ring-2 focus-within:ring-blue-400">
                        <textarea name="template_html" id="template_html_input" rows="12" required
                            class="w-full px-4 py-3 bg-gray-50 font-mono text-sm focus:bg-white focus:outline-none transition-all duration-200"
                            placeholder="<div class='document'><h1>Hello @{{customer_name}}</h1><p>Booking: @{{booking_id}}</p></div>"></textarea>
                        <div class="absolute bottom-3 right-3 bg-white/80 backdrop-blur-sm rounded-md px-2 py-0.5 text-[11px] font-mono text-gray-400 border border-gray-200">HTML</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center justify-end gap-3 pt-2 border-t border-gray-100 mt-4">
                    <button type="reset" id="resetFormBtn" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-200">
                        Clear form
                    </button>
                    <button type="submit" id="submitBtn" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span id="submitBtnText">Create Template</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Templates List Section -->
    <div class="bg-white rounded-2xl shadow-card border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 flex flex-wrap justify-between items-center gap-3">
            <div class="flex items-center gap-2">
                <div class="p-2 rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Your Templates</h3>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-gray-100 px-3 py-1 rounded-full text-xs font-medium text-gray-700">
                    {{ count($documents) }} {{ Str::plural('template', count($documents)) }}
                </div>
                <input type="text" id="searchTemplate" placeholder="Filter templates..." class="text-sm pl-8 pr-3 py-1.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:ring-1 focus:ring-blue-300">
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100" id="templatesTable">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Template name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($documents as $doc)
                    <tr class="hover:bg-gray-50 transition duration-150" data-template-name="{{ strtolower($doc->name) }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl">
                                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $doc->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $doc->created_at ? $doc->created_at->format('M d, Y') : '—' }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2.5 whitespace-nowrap">
                            <a href="{{ route('document.create', ['template_id' => $doc->id]) }}" 
                                class="inline-flex items-center gap-1 text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1.5 rounded-lg hover:bg-emerald-100 transition">
                                Use
                            </a>
                            <button onclick="window.editTemplate({{ $doc->id }}, '{{ addslashes($doc->name) }}', `{{ addslashes($doc->template_html) }}`)" 
                                class="inline-flex items-center gap-1 text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1.5 rounded-lg hover:bg-amber-100 transition">
                                Edit
                            </button>
                            <a href="{{ route('template.delete', $doc->id) }}" onclick="return confirm('Delete this template permanently?')"
                                class="inline-flex items-center gap-1 text-xs font-medium bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-100 transition">
                                Delete
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <div class="p-4 bg-gray-100 rounded-full">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-gray-500 font-medium">No templates yet</p>
                                <p class="text-sm text-gray-400">Create your first template above</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tips Section -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white/70 rounded-xl p-4 border border-blue-100 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-800">Dynamic variables</h4>
                    <p class="text-xs text-gray-500">Use <code class="bg-gray-100 px-1 rounded">@{{variable}}</code> to inject data dynamically</p>
                </div>
            </div>
        </div>
        <div class="bg-white/70 rounded-xl p-4 border border-indigo-100 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="p-2 rounded-full bg-indigo-100 text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-800">Clean HTML design</h4>
                    <p class="text-xs text-gray-500">Ensure responsive design for consistent document formatting</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.3s ease-out;
    }
    .shadow-card {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    }
</style>

<script>
// All JavaScript is now properly placed outside PHP tags
(function() {
    // Insert variable into textarea at cursor position
    window.insertVariable = function(varName) {
        const textarea = document.getElementById('template_html_input');
        if (!textarea) return;
        
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const variable = '@{{' + varName + '}}';
        const text = textarea.value;
        const newText = text.substring(0, start) + variable + text.substring(end);
        textarea.value = newText;
        textarea.focus();
        textarea.setSelectionRange(start + variable.length, start + variable.length);
    };

    // Edit template function
    window.editTemplate = function(id, name, html) {
        document.getElementById('template_id').value = id;
        document.getElementById('template_name_input').value = name;
        document.getElementById('template_html_input').value = html;
        
        const form = document.getElementById('templateForm');
        form.action = "/template/update/" + id;
        
        document.getElementById('submitBtnText').innerText = "Update Template";
        document.getElementById('formTitle').innerHTML = "✏️ Edit Template";
        
        // Scroll to top smoothly
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // Reset form handler
    const resetBtn = document.getElementById('resetFormBtn');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            document.getElementById('templateForm').reset();
            document.getElementById('template_id').value = '';
            document.getElementById('templateForm').action = "{{ route('template.store') }}";
            document.getElementById('submitBtnText').innerText = "Create Template";
            document.getElementById('formTitle').innerHTML = "Create new template";
        });
    }

    // Search filter for templates
    const searchInput = document.getElementById('searchTemplate');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const term = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#templatesTable tbody tr');
            rows.forEach(row => {
                const nameCell = row.querySelector('td:first-child .text-sm.font-semibold');
                if (nameCell) {
                    const templateName = nameCell.innerText.toLowerCase();
                    row.style.display = templateName.includes(term) ? '' : 'none';
                }
            });
        });
    }
})();
</script>
@endsection