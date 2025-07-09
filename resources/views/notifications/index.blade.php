<x-app-layout>
    <div class="bg-slate-50 min-h-screen">
        {{-- Cabeçalho --}}
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-bold text-slate-900">
                    Minhas Notificações
                </h1>
                contagem: 
            </div>
        </header>

        {{-- Conteúdo Principal --}}
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6">
                        @forelse ($notifications as $notification)
                            <div class="border-b border-slate-200 last:border-b-0 py-4">
                                <a href="{{ $notification->data['url'] ?? '#' }}"
                                   class="block hover:bg-slate-50 p-2 rounded-md"
                                   onclick="event.preventDefault(); document.getElementById('mark-as-read-{{ $notification->id }}').submit(); window.location.href = '{{ $notification->data['url'] ?? '#' }}';">
                                    <p class="text-sm {{ $notification->read_at ? 'text-slate-500' : 'font-semibold text-slate-800' }}">
                                        {{ $notification->data['mensagem'] }}
                                    </p>
                                    <span class="text-xs text-slate-400">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </a>
                                {{-- Formulário oculto para marcar como lida --}}
                                <form id="mark-as-read-{{ $notification->id }}" method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}" style="display: none;">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 text-center py-4">Você não possui notificações.</p>
                        @endforelse
                    </div>

                    @if ($notifications->hasPages())
                        <div class="p-6 border-t border-slate-200">{{ $notifications->links() }}</div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
