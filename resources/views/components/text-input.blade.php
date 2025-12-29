@props(['disabled' => false])

@php
    $isNumber = isset($attributes['type']) && $attributes['type'] === 'number';
    $uniqueId = 'input_' . uniqid();

    // Override type="number" jadi "text"
    if ($isNumber) {
        $attributes = $attributes->except(['type']);
    }
@endphp

<input {{ $disabled ? 'disabled' : '' }} type="{{ $isNumber ? 'text' : $attributes['type'] ?? 'text' }}"
    {!! $attributes->merge([
        'class' =>
            'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 rounded-md shadow-sm',
    ]) !!}
    @if ($isNumber) inputmode="numeric"
        data-format-number="true"
        data-number-id="{{ $uniqueId }}" @endif>

@if ($isNumber)
    <script>
        (function() {
            const inputId = '{{ $uniqueId }}';
            const input = document.querySelector('[data-number-id="' + inputId + '"]');

            if (!input || input.dataset.numberInitialized) return;
            input.dataset.numberInitialized = 'true';

            console.log('Initializing number format for:', inputId);

            // Format number
            function fmt(n) {
                if (!n) return '';
                const clean = String(n).replace(/\D/g, '');
                return clean ? clean.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
            }

            // Unformat number
            function unfmt(s) {
                return String(s).replace(/\./g, '');
            }

            // Get digit position
            function getDigitPos(str, cursorPos) {
                let pos = 0;
                for (let i = 0; i < cursorPos; i++) {
                    if (str[i] && str[i] !== '.') pos++;
                }
                return pos;
            }

            // Get cursor position from digit position
            function getCursorPos(str, digitPos) {
                let count = 0;
                for (let i = 0; i <= str.length; i++) {
                    if (count === digitPos) return i;
                    if (i < str.length && str[i] !== '.') count++;
                }
                return str.length;
            }

            // Format initial value
            if (input.value) {
                input.value = fmt(input.value);
            }

            // Input event
            input.addEventListener('input', function() {
                const pos = getDigitPos(this.value, this.selectionStart);
                this.value = fmt(this.value);
                const newPos = getCursorPos(this.value, pos);
                this.setSelectionRange(newPos, newPos);
            });

            // Paste event
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                const clean = paste.replace(/\D/g, '');
                if (!clean) return;

                const start = this.selectionStart;
                const end = this.selectionEnd;
                const posStart = getDigitPos(this.value, start);
                const posEnd = getDigitPos(this.value, end);
                const raw = unfmt(this.value);
                const newRaw = raw.substring(0, posStart) + clean + raw.substring(posEnd);

                this.value = fmt(newRaw);

                const newDigitPos = posStart + clean.length;
                const newCursorPos = getCursorPos(this.value, newDigitPos);
                this.setSelectionRange(newCursorPos, newCursorPos);
            });

            // Keydown event
            input.addEventListener('keydown', function(e) {
                const allowed = [8, 9, 27, 13, 46, 35, 36, 37, 38, 39, 40];
                if (allowed.includes(e.keyCode) ||
                    ((e.ctrlKey || e.metaKey) && [65, 67, 86, 88, 90].includes(e.keyCode))) {
                    return;
                }
                if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });

            // Form submit
            const form = input.closest('form');
            if (form && !form.dataset.numberFormHandler) {
                form.dataset.numberFormHandler = 'true';
                form.addEventListener('submit', function() {
                    const inputs = this.querySelectorAll('[data-format-number="true"]');
                    inputs.forEach(inp => {
                        if (inp.value) {
                            inp.value = unfmt(inp.value);
                        }
                    });
                });
            }

            console.log('Number format initialized for:', inputId);
        })();
    </script>
@endif
