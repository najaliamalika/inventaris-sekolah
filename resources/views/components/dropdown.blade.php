@props([
    'name' => '',
    'id' => '',
    'placeholder' => 'Pilih opsi',
    'selected' => '',
    'options' => [],
    'valueField' => 'value',
    'labelField' => 'label',
    'searchable' => false,
    'required' => false,
    'xModel' => null,
    'autoSubmit' => false,
])

@php
    $componentId = $id ?: 'dropdown-' . uniqid();
@endphp

<div x-data="customDropdown({
    searchable: {{ $searchable ? 'true' : 'false' }},
    selected: {{ $xModel ? 'null' : "'$selected'" }},
    placeholder: '{{ $placeholder }}',
    options: {{ json_encode($options) }},
    valueField: '{{ $valueField }}',
    labelField: '{{ $labelField }}',
    xModel: {{ $xModel ? "'$xModel'" : 'null' }},
    autoSubmit: {{ $autoSubmit ? 'true' : 'false' }},
    name: '{{ $name }}'
})"
    @if ($xModel) x-modelable="selectedValue"
x-init="initWithModel({{ $xModel }})"
@else
x-init="init()" @endif
    class="relative w-full" @click.away="open = false" x-ref="dropdownContainer">

    <input type="hidden" name="{{ $name }}" :value="selectedValue" {{ $required ? 'required' : '' }}>

    <button type="button" @click="open = !open"
        class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white text-left flex items-center justify-between"
        :class="{ 'border-green-500 ring-2 ring-green-500/20': open }">
        <span x-text="selectedLabel" class="truncate"
            :class="{ 'text-gray-400 dark:text-gray-500': !selectedValue }"></span>
        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-hidden"
        style="display: none;">

        <div x-show="searchable" class="p-2 border-b border-gray-200 dark:border-gray-600">
            <input type="text" x-model="search" @input="filterOptions" @click.stop placeholder="Cari..."
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white text-sm">
        </div>

        <div class="overflow-y-auto max-h-48">
            <template x-for="option in filteredOptions" :key="option[valueField]">
                <button type="button" @click="selectOption(option)"
                    class="w-full px-4 py-2.5 text-left hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                    :class="{
                        'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400': selectedValue == option[
                            valueField]
                    }">
                    <span x-text="option[labelField]"></span>
                </button>
            </template>

            <div x-show="filteredOptions.length === 0"
                class="px-4 py-3 text-center text-gray-500 dark:text-gray-400 text-sm">
                Tidak ada hasil ditemukan
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            function customDropdown(config) {
                return {
                    open: false,
                    search: '',
                    selectedValue: config.selected,
                    selectedLabel: config.placeholder,
                    options: config.options,
                    filteredOptions: config.options,
                    searchable: config.searchable,
                    placeholder: config.placeholder,
                    valueField: config.valueField,
                    labelField: config.labelField,
                    xModelValue: config.xModel,
                    autoSubmit: config.autoSubmit,
                    name: config.name,

                    init() {
                        this.updateLabel();
                    },

                    initWithModel(initialValue) {
                        this.selectedValue = initialValue;
                        this.updateLabel();

                        this.$watch('selectedValue', (value) => {
                            this.updateLabel();
                        });
                    },

                    updateLabel() {
                        if (this.selectedValue) {
                            const selected = this.options.find(opt => opt[this.valueField] == this.selectedValue);
                            if (selected) {
                                this.selectedLabel = selected[this.labelField];
                            } else {
                                this.selectedLabel = this.placeholder;
                            }
                        } else {
                            this.selectedLabel = this.placeholder;
                        }
                    },

                    selectOption(option) {
                        this.selectedValue = option[this.valueField];
                        this.selectedLabel = option[this.labelField];
                        this.open = false;
                        this.search = '';
                        this.filteredOptions = this.options;

                        this.$dispatch('dropdown-changed', option[this.valueField]);

                        if (!this.xModelValue) {
                            this.$nextTick(() => {
                                const container = this.$refs.dropdownContainer;
                                const hiddenInput = container.querySelector('input[type="hidden"]');
                                if (hiddenInput) {
                                    hiddenInput.value = option[this.valueField];
                                    hiddenInput.dispatchEvent(new Event('change', {
                                        bubbles: true
                                    }));
                                }

                                if (this.autoSubmit) {
                                    const form = container.closest('form');
                                    if (form) {
                                        setTimeout(() => {
                                            form.submit();
                                        }, 100);
                                    }
                                }
                            });
                        }
                    },

                    filterOptions() {
                        if (!this.search) {
                            this.filteredOptions = this.options;
                            return;
                        }

                        this.filteredOptions = this.options.filter(option => {
                            return option[this.labelField]
                                .toLowerCase()
                                .includes(this.search.toLowerCase());
                        });
                    }
                }
            }
        </script>
    @endpush
@endonce
