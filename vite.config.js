import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default ({ mode }) => {
    // Carrega as variáveis do seu arquivo .env
    const env = loadEnv(mode, process.cwd(), '');

    // Retorna a configuração final para o Vite
    return defineConfig({
        plugins: [
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/js/app.js',
                ],
                refresh: true,
            }),
        ],
        server: {
            // 1. Expõe o servidor a todos os IPs da máquina (0.0.0.0)
            // Permitindo acesso via localhost, 127.0.0.1 e seu IP de rede (ex: 192.168.1.10)
            host: '0.0.0.0',

            // 2. Garante que o Hot Module Replacement (HMR) funcione na rede
            // Ele injetará o IP correto (do .env) no HTML para que seu celular encontre os assets.
            hmr: {
                host: env.VITE_HOST,
            },
        },
    });
}