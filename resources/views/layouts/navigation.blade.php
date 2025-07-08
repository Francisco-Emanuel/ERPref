<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 no-print">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @can('view-ativos')
                        <x-nav-link :href="route('ativos.index')" :active="request()->routeIs('ativos.*')">
                            {{ __('Ativos') }}
                        </x-nav-link>
                    @endcan
                    
                    @can('view-chamados')
                        <x-nav-link :href="route('chamados.index')" :active="request()->routeIs('chamados.*')">
                            {{ __('Chamados') }}
                        </x-nav-link>

                        
                    @endcan

                    

                    @hasanyrole('Admin|Supervisor')
                        <x-nav-link :href="route('departamentos.index')" :active="request()->routeIs('departamentos.*')">
                            {{ __('Departamentos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')">
                            {{ __('Categorias') }}
                        </x-nav-link>
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            {{ __('Usuários') }}
                        </x-nav-link>
                    @endhasanyrole
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                {{-- Ícone de Notificações --}}
                <div x-data="{ 
                    notifications: [], 
                    unreadCount: 0, 
                    openNotifications: false,
                    
                    // Função para buscar notificações
                    fetchNotifications: async function() {
                        try {
                            const response = await axios.get('/api/notifications');
                            this.notifications = response.data.notifications;
                            this.unreadCount = response.data.unreadCount;
                        } catch (error) {
                            console.error('Erro ao buscar notificações:', error);
                        }
                    },

                    // Função para buscar apenas a contagem de não lidas
                    fetchUnreadCount: async function() {
                        try {
                            const response = await axios.get('/api/notifications/count');
                            this.unreadCount = response.data.count;
                        } catch (error) {
                            console.error('Erro ao buscar contagem de notificações:', error);
                        }
                    }
                }" 
                x-init="
                    // Busca inicial ao carregar a página
                    // Removido 'this.' aqui, pois as funções já estão no escopo do x-data
                    fetchNotifications(); 

                    // Atualiza a contagem de não lidas a cada 30 segundos
                    setInterval(() => fetchUnreadCount(), 30000); // Removido 'this.' aqui

                    // Observa a abertura do dropdown para marcar como lido
                    $watch('openNotifications', async value => {
                        if (value && this.unreadCount > 0) {
                            try {
                                await axios.post('/api/notifications/mark-as-read');
                                this.unreadCount = 0; // Zera o contador visualmente
                                // Opcional: recarregar todas as notificações para atualizar o status 'read_at'
                                // this.fetchNotifications(); // Mantenha 'this.' se chamar a função interna
                            } catch (error) {
                                console.error('Erro ao marcar notificações como lidas:', error);
                            }
                        }
                    });
                " class="relative me-4">
                    <button @click="openNotifications = !openNotifications" class="p-2 text-gray-500 hover:text-gray-700 relative focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span x-show="unreadCount > 0" x-transition class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full" x-text="unreadCount"></span>
                    </button>
                    <div x-show="openNotifications" @click.away="openNotifications = false" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50 max-h-80 overflow-y-auto">
                        <template x-for="notification in notifications.slice(0, 5)" :key="notification.id"> {{-- Mostra as 5 mais recentes --}}
                            <a :href="notification.data.url" class="block px-4 py-2 text-sm" :class="{'font-bold text-gray-900 bg-gray-50': !notification.read_at, 'text-gray-700 hover:bg-gray-100': notification.read_at}" @click="axios.patch(`/api/notifications/${notification.id}/mark-as-read`).catch(e => console.error(e))">
                                <p x-text="notification.data.mensagem"></p>
                                <span class="text-xs text-gray-400" x-text="new Date(notification.created_at).toLocaleString()"></span>
                            </a>
                        </template>
                        <div x-show="notifications.length === 0" class="px-4 py-2 text-sm text-gray-500 text-center">Nenhuma notificação.</div>
                        <template x-if="notifications.length > 0">
                            <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 text-center border-t border-gray-100">Ver todas as notificações</a>
                        </template>
                    </div>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- O link do perfil agora aponta para a nova rota de visualização --}}
                        <x-dropdown-link :href="route('profile.show')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                {{-- O link do perfil agora aponta para a nova rota de visualização --}}
                <x-responsive-nav-link :href="route('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
