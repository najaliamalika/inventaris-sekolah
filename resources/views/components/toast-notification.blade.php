<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-[70] space-y-3 w-full max-w-sm pointer-events-none"
    aria-live="polite">
</div>

@once
    @push('scripts')
        <script>
            window.Toast = {
                show(message, type = 'success', duration = 5000) {
                    const container = document.getElementById('toast-container');
                    if (!container) return;

                    const toastId = 'toast-' + Date.now();
                    const toast = this.createToast(toastId, message, type);

                    container.insertAdjacentHTML('beforeend', toast);

                    // Trigger animation
                    setTimeout(() => {
                        const toastElement = document.getElementById(toastId);
                        if (toastElement) {
                            toastElement.classList.remove('translate-x-full', 'opacity-0');
                            toastElement.classList.add('translate-x-0', 'opacity-100');
                        }
                    }, 10);

                    // Auto remove
                    if (duration > 0) {
                        setTimeout(() => {
                            this.hide(toastId);
                        }, duration);
                    }

                    return toastId;
                },

                createToast(id, message, type) {
                    const styles = this.getStyles(type);

                    return `
                <div id="${id}" 
                    class="transform translate-x-full opacity-0 transition-all duration-300 ease-out pointer-events-auto">
                    <div class="flex barang-start gap-3 p-4 rounded-lg shadow-lg ${styles.bg} border ${styles.border}">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            ${styles.icon}
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium ${styles.text}">
                                ${this.escapeHtml(message)}
                            </p>
                        </div>
                        
                        <!-- Close Button -->
                        <button type="button" 
                            onclick="window.Toast.hide('${id}')"
                            class="flex-shrink-0 ${styles.closeBtn} hover:${styles.closeBtnHover} rounded p-0.5 transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
                },

                getStyles(type) {
                    const styles = {
                        success: {
                            bg: 'bg-green-50 dark:bg-green-900/30',
                            border: 'border-green-200 dark:border-green-800',
                            text: 'text-green-800 dark:text-green-200',
                            closeBtn: 'text-green-500 dark:text-green-400',
                            closeBtnHover: 'text-green-700 dark:text-green-300',
                            icon: `<svg class="w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>`
                        },
                        error: {
                            bg: 'bg-red-50 dark:bg-red-900/30',
                            border: 'border-red-200 dark:border-red-800',
                            text: 'text-red-800 dark:text-red-200',
                            closeBtn: 'text-red-500 dark:text-red-400',
                            closeBtnHover: 'text-red-700 dark:text-red-300',
                            icon: `<svg class="w-5 h-5 text-red-500 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>`
                        },
                        warning: {
                            bg: 'bg-yellow-50 dark:bg-yellow-900/30',
                            border: 'border-yellow-200 dark:border-yellow-800',
                            text: 'text-yellow-800 dark:text-yellow-200',
                            closeBtn: 'text-yellow-500 dark:text-yellow-400',
                            closeBtnHover: 'text-yellow-700 dark:text-yellow-300',
                            icon: `<svg class="w-5 h-5 text-yellow-500 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>`
                        },
                        info: {
                            bg: 'bg-blue-50 dark:bg-blue-900/30',
                            border: 'border-blue-200 dark:border-blue-800',
                            text: 'text-blue-800 dark:text-blue-200',
                            closeBtn: 'text-blue-500 dark:text-blue-400',
                            closeBtnHover: 'text-blue-700 dark:text-blue-300',
                            icon: `<svg class="w-5 h-5 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>`
                        }
                    };

                    return styles[type] || styles.info;
                },

                hide(toastId) {
                    const toast = document.getElementById(toastId);
                    if (!toast) return;

                    toast.classList.remove('translate-x-0', 'opacity-100');
                    toast.classList.add('translate-x-full', 'opacity-0');

                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                },

                escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                },

                // Shorthand methods
                success(message, duration = 5000) {
                    return this.show(message, 'success', duration);
                },

                error(message, duration = 5000) {
                    return this.show(message, 'error', duration);
                },

                warning(message, duration = 5000) {
                    return this.show(message, 'warning', duration);
                },

                info(message, duration = 5000) {
                    return this.show(message, 'info', duration);
                }
            };

            // Auto show toast from session flash messages
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('success'))
                    window.Toast.success('{{ session('success') }}');
                @endif

                @if (session('error'))
                    window.Toast.error('{{ session('error') }}');
                @endif

                @if (session('warning'))
                    window.Toast.warning('{{ session('warning') }}');
                @endif

                @if (session('info'))
                    window.Toast.info('{{ session('info') }}');
                @endif
            });
        </script>
    @endpush
@endonce
