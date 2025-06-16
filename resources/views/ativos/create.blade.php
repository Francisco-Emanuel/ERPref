<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Ativo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg px-8 py-6">
                <form method="POST" action="{{ route('Ativos.store') }}">
                    @csrf
                    {{-- Bloco para exibir todos os erros de validação --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                            <p class="font-bold">Por favor, corrija os seguintes erros:</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tipo do Ativo -->
                        <div>
                            <label for="tipo_ativos" class="block mb-2 text-sm font-medium text-gray-900">Tipo de
                                ativo</label>
                            <select name="tipo_ativos"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>

                                <option>Computador</option>
                                <option>Monitor</option>
                            </select>
                            @error('tipo_ativo')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Identificação -->
                        <div>
                            <label for="identificacao"
                                class="block text-sm font-medium text-gray-700 mb-1">Identificação do ativo</label>
                            <input type="text" name="identificacao"
                                class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="ex: 42069" value="{{ old('identificacao') }}" required />
                            @error('identificacao')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Setor -->
                        <div>
                            <label for="setor" class="block mb-2 text-sm font-medium text-gray-900">Setor</label>
                            <select name="setor"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>

                                <option>RH</option>
                                <option>TI</option>
                                <option>ADM</option>
                                <option>EMEI</option>
                            </select>
                            @error('setor')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- <!-- Responsável -->
                        <div>
                            <label for="usuario_ersponsavel"
                                class="block mb-2 text-sm font-medium text-gray-900">Responsável pelo ativo</label>
                            <select name="usuario_ersponsavel"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>

                                @foreach ($usuarios as $usuario)
                                <option>{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                            @error('usuario_responsavel')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div> --}}


                        <!-- EXEMPLO GPT -->
                        <div>
                            <label for="usuario_responsavel_search"
                                class="block mb-2 text-sm font-medium text-gray-900">Responsável pelo ativo</label>

                            <div class="relative text-black" x-data="selectmenu()" @click.away="close()">
                                <input type="hidden" x-model="selectedkey" name="usuario_responsavel"
                                    id="usuario_responsavel">

                                <span class="inline-block w-full rounded-md shadow-sm" @click="toggle()">
                                    <button type="button"
                                        class="relative z-0 w-full py-2 pl-3 pr-10 text-left transition duration-150 ease-in-out bg-gray-50 border border-gray-300 rounded-lg cursor-default focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm sm:leading-5">
                                        <span class="block truncate"
                                            x-text="selectedlabel ?? 'Selecione um responsável'"></span>
                                        <span
                                            class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="none"
                                                stroke="currentColor">
                                                <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </button>
                                </span>

                                <div x-show="state" class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg p-2">
                                    <input type="text" class="w-full rounded-md py-1 px-2 mb-1 border border-gray-400"
                                        x-model.debounce.300ms="filter" @input="searchUsers()" x-ref="filterinput"
                                        placeholder="Digite para buscar..." autocomplete="off">
                                    <ul
                                        class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                                        <template x-for="(value, key) in results" :key="key">
                                            <li @click="select(value, key)" :class="{'bg-gray-100': isselected(key)}"
                                                class="relative py-1 pl-3 mb-1 text-gray-900 select-none pr-9 hover:bg-gray-100 cursor-pointer rounded-md">
                                                <span x-text="value" class="block font-normal truncate"></span>
                                                <span x-show="isselected(key)"
                                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-700">
                                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </li>
                                        </template>
                                        <template x-if="Object.keys(results).length === 0 && filter.length >= 2">
                                            <li class="py-1 pl-3 text-gray-500">Nenhum resultado encontrado.</li>
                                        </template>
                                    </ul>
                                </div>
                                <template x-if="selectedUserName">
                                    <p class="mt-2 text-sm text-gray-600">
                                        Selecionado: <span x-text="selectedUserName" class="font-semibold"></span>
                                        <button type="button" @click="clearSelection()"
                                            class="text-red-500 hover:text-red-700 ml-2 text-xs">Limpar</button>
                                    </p>
                                </template>
                            </div>

                            @error('usuario_responsavel')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status (toggle) -->
                        <div x-data="{ status: false }">
                            <label class="inline-flex items-center mb-5 cursor-pointer">
                                <input type="checkbox" x-model="status" name="status" value="1" class="sr-only peer">
                                <div class="relative w-11 h-6 bg-red-300 peer-focus:outline-none rounded-full 
                                        peer peer-checked:after:translate-x-full 
                                        rtl:peer-checked:after:-translate-x-full 
                                        peer-checked:after:border-white 
                                        after:content-[''] after:absolute after:top-[2px] after:start-[2px] 
                                        after:bg-white after:border-gray-300 after:border after:rounded-full 
                                        after:w-5 after:h-5 after:transition-all 
                                        peer-checked:bg-green-300"></div>
                                <span :class="status ? 'text-green-600' : 'text-red-500'"
                                    class="ms-3 text-sm font-medium">
                                    <span x-text="status ? 'Status (OK)' : 'Status (Problema)'"></span>
                                </span>
                            </label>
                            @error('status')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descrição -->
                        <div class="md:col-span-2">
                            <label for="descricao_problema"
                                class="block text-sm font-medium text-gray-700 mb-1">Descrição do problema</label>
                            <textarea name="descricao_problema" rows="4"
                                class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Computador fazendo barulho..."></textarea>
                            @error('descricao_problema')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botão -->
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full md:w-auto px-6 py-2.5 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 transition">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function selectmenu() { // Removido 'datalist' do parâmetro, pois buscaremos dinamicamente
            return {
                state: false, // Inicia fechado por padrão
                filter: '',
                // list: datalist, // Não precisamos mais de uma lista estática
                results: {}, // Armazenará os resultados da pesquisa AJAX
                selectedkey: null, // ID do usuário selecionado (será enviado)
                selectedlabel: null, // Texto do usuário selecionado para exibição

                // Inicializa o componente, útil para carregar o valor 'old'
                init() {
                    // Verifica se há um valor 'old' (ex: após erro de validação)
                    const oldUserId = this.$el.querySelector('input[name="usuario_responsavel"]').value;
                    if (oldUserId) {
                        this.selectedkey = oldUserId;
                        // Faz uma requisição AJAX para buscar o nome do usuário pelo ID
                        fetch(`/api/users/${oldUserId}`) // Use a rota que busca um único usuário
                            .then(response => response.json())
                            .then(data => {
                                if (data) {
                                    this.selectedlabel = data.value; // 'value' conforme mapeado no Controller show()
                                    this.filter = data.name; // Preenche o input de filtro com o nome para que o usuário veja
                                }
                            })
                            .catch(error => console.error('Erro ao carregar usuário antigo:', error));
                    }
                },

                toggle: function () {
                    this.state = !this.state;
                    this.filter = ''; // Limpa o filtro ao abrir/fechar
                    if (this.state) {
                        // Ao abrir, se já tiver um item selecionado, preenche o filtro com ele
                        if (this.selectedlabel) {
                            // Extrai apenas o nome se o label incluir e-mail
                            const nameMatch = this.selectedlabel.match(/(.*) \(/);
                            this.filter = nameMatch ? nameMatch[1] : this.selectedlabel;
                        }
                        this.$nextTick(() => this.$refs.filterinput.focus()); // Foca no campo de filtro
                        this.searchUsers(); // Faz uma busca inicial ao abrir (pode mostrar os últimos pesquisados ou todos)
                    }
                },
                close: function () {
                    this.state = false;
                },
                select: function (value, key) {
                    // Se o item clicado já estiver selecionado, deseleciona
                    if (this.selectedkey === key) {
                        this.selectedlabel = null;
                        this.selectedkey = null;
                        this.filter = ''; // Limpa o filtro também
                    } else {
                        this.selectedlabel = value; // Texto visível
                        this.selectedkey = key;     // ID para o input hidden
                        this.state = false;         // Fecha o menu após a seleção
                        this.filter = value.split(' (')[0] || value; // Opcional: preenche o filtro com o nome
                    }
                },
                isselected: function (key) {
                    return this.selectedkey === key;
                },
                // Método para buscar usuários via AJAX (substitui getlist())
                searchUsers: function () {
                    // Não busca se o filtro estiver muito curto ou vazio, a menos que seja para 'toggle' inicial
                    if (this.filter.length < 2 && this.filter !== '') {
                        this.results = {}; // Limpa os resultados se o filtro for inválido
                        return;
                    }

                    // Faz a requisição AJAX
                    fetch(`{{ route('users.search') }}?term=${encodeURIComponent(this.filter)}`)
                        .then(response => response.json())
                        .then(data => {
                            this.results = data; // Atualiza os resultados com os dados da API
                        })
                        .catch(error => {
                            console.error('Erro na busca de usuários:', error);
                            this.results = {}; // Limpa em caso de erro
                        });
                }
            };
        }
    </script>
</x-app-layout>