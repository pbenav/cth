<div x-data="initNumpad()" x-init="iniciar()" role="form" aria-label="{{ __('Formulario de ingreso de código') }}">
    {{-- Livewire Component --}}
    @livewire('add-event')

    {{-- Display information message if exists --}}
    <div class="numpad-info-placeholder">
        @if (session('info'))
            <div class="numpad-info-message flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert" aria-live="polite">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" aria-hidden="true">
                    <path
                        d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
                </svg>
                <p>{{ __(session('info')) }}</p>
            </div>
        @endif
    </div>

    <div class="mb-4">
        <div id="ct7" class="btn-aux"></div>
    </div>

    <div class="max-w-lg">
        <div class="content-center">
            {{-- Branding Section --}}
            <div class="flex flex-col items-center mb-4 sm:mb-6">
                {{-- Logo --}}
                <div class="mb-3 sm:mb-4">
                    <img src="{{ asset('images/sientiaCTH-logo.png') }}" 
                         alt="{{ config('app.name') }}" 
                         class="w-16 sm:w-20 md:w-24 aspect-square object-contain">
                </div>
                {{-- App Name --}}
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white text-center">
                    {{ config('app.name') }}
                </h1>
            </div>

            <div class="w-auto mb-3 sm:mb-4 text-center">
                <form wire:submit.prevent="insertCode">
                    <input type="password" id="user_code" x-model="user_code" class="pin-input"
                        aria-label="{{ __('Código de usuario') }}"
                        autocomplete="off"
                        @keyup.enter="$wire.insertCode()" />
                </form>
            </div>

            <div id="buttons" class="grid grid-cols-3 gap-2 sm:gap-4" role="group" aria-label="{{ __('Teclado numérico') }}">
                <button @click="addCode('1')" class="btn-pad" aria-label="1">1</button>
                <button @click="addCode('2')" class="btn-pad" aria-label="2">2</button>
                <button @click="addCode('3')" class="btn-pad" aria-label="3">3</button>
                <button @click="addCode('4')" class="btn-pad" aria-label="4">4</button>
                <button @click="addCode('5')" class="btn-pad" aria-label="5">5</button>
                <button @click="addCode('6')" class="btn-pad" aria-label="6">6</button>
                <button @click="addCode('7')" class="btn-pad" aria-label="7">7</button>
                <button @click="addCode('8')" class="btn-pad" aria-label="8">8</button>
                <button @click="addCode('9')" class="btn-pad" aria-label="9">9</button>
                <button @click="addCode('0')" class="btn-pad col-span-3" aria-label="0">0</button>
            </div>

            <div class="mt-3 sm:mt-4">
                <button type="submit" wire:click="insertCode" class="btn-code" aria-label="{{ __('Insertar código') }}">
                    {{ __('Insertar código') }}
                </button>
            </div>

            <div class="mt-0 text-center content-center">
                <button @click="resetCode()" class="btn-aux" aria-label="{{ __('Restablecer') }}">
                    {{ __('Restablecer') }}
                </button>
                <button @click="deleteCode()" class="btn-aux" aria-label="{{ __('Borrar') }}">
                    {{ __('Borrar') }}
                </button>
            </div>
        </div>
    </div>

    <style>
        .btn-pad {
            background-color: #d1d5db !important; /* gray-300 */
            color: #111827 !important; /* gray-900 */
            text-align: center !important;
            padding: 0.75rem 0.5rem !important;
            border-radius: 0.5rem !important;
            cursor: pointer !important;
            border: none !important;
            transition: all 0.7s duration-700 !important;
            font-size: 1.125rem !important;
        }

        .btn-pad:hover {
            background-color: #374151 !important; /* gray-700 */
            color: #ffffff !important;
        }

        .btn-aux {
            background-color: #d1d5db !important; /* gray-300 */
            color: #111827 !important; /* gray-900 */
            text-align: center !important;
            padding: 0.75rem 2.5rem !important;
            border-radius: 0.5rem !important;
            cursor: pointer !important;
            border: none !important;
            transition: all 0.7s duration-700 !important;
            font-size: 1.25rem !important;
            margin-bottom: 0.5rem !important;
        }

        .btn-aux:hover {
            background-color: #374151 !important; /* gray-700 */
            color: #ffffff !important;
        }

        .btn-code {
            width: 100% !important;
            background-color: #22c55e !important; /* green-500 approx */
            color: #ffffff !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            text-align: center !important;
            padding: 0.75rem !important;
            border-radius: 0.5rem !important;
            cursor: pointer !important;
            border: none !important;
            transition: all 0.7s duration-700 !important;
            display: block !important;
        }

        .btn-code:hover {
            background-color: #16a34a !important; /* green-600 */
        }

        .pin-input {
            width: 100% !important;
            background-color: #fef9c3 !important; /* light yellow */
            color: #111827 !important;
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            text-align: center !important;
            padding: 0.75rem !important;
            border-radius: 0.375rem !important;
            border: 1px solid #d1d5db !important;
            outline: none !important;
        }

        /* Clock override to use btn-aux like styles as per original */
        #ct7.btn-aux {
            width: 100% !important;
            display: block !important;
            padding: 0.75rem !important;
        }
    </style>

    <script>
        window.onload = () => {
            document.getElementById("user_code").focus();
        };

        function initNumpad() {
            return {
                user_code: @entangle('user_code').defer,
                iniciar: function() {
                    this.user_code = '';
                },
                addCode: function(s) {
                    this.user_code += s;
                },
                resetCode: function() {
                    this.user_code = '';
                },
                deleteCode: function() {
                    this.user_code = this.user_code.slice(0, -1);
                },
            }
        }
    </script>
</div>