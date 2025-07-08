<?php

namespace App\Notifications;

use App\Models\Chamado;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ChamadoAtribuidoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $chamado;
    public $atribuidor;

    /**
     * Crie uma nova instância de notificação.
     */
    public function __construct(Chamado $chamado, User $atribuidor)
    {
        $this->chamado = $chamado;
        $this->atribuidor = $atribuidor;
    }

    /**
     * Obtenha os canais de entrega da notificação.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Obtenha a representação da notificação para armazenamento no banco de dados.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'chamado_id' => $this->chamado->id,
            'titulo' => $this->chamado->titulo,
            'mensagem' => "Chamado #{$this->chamado->id} foi atribuído a você por {$this->atribuidor->name}.",
            'url' => route('chamados.show', $this->chamado->id),
            'tipo' => 'chamado_atribuido',
        ];
    }
}
