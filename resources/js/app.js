import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// window.selectmenu = function() { // Removido 'datalist' do parâmetro, pois buscaremos dinamicamente
//     return {
//         state: false, // Inicia fechado por padrão
//         filter: '',
//         // list: datalist, // Não precisamos mais de uma lista estática
//         results: {}, // Armazenará os resultados da pesquisa AJAX
//         selectedkey: null, // ID do usuário selecionado (será enviado)
//         selectedlabel: null, // Texto do usuário selecionado para exibição

//         // Inicializa o componente, útil para carregar o valor 'old'
//         init() {
//             // Verifica se há um valor 'old' (ex: após erro de validação)
//             const oldUserId = this.$el.querySelector('input[name="usuario_responsavel"]').value;
//             if (oldUserId) {
//                 this.selectedkey = oldUserId;
//                 // Faz uma requisição AJAX para buscar o nome do usuário pelo ID
//                 fetch(`/api/users/${oldUserId}`) // Use a rota que busca um único usuário
//                     .then(response => response.json())
//                     .then(data => {
//                         if (data) {
//                             this.selectedlabel = data.value; // 'value' conforme mapeado no Controller show()
//                             this.filter = data.name; // Preenche o input de filtro com o nome para que o usuário veja
//                         }
//                     })
//                     .catch(error => console.error('Erro ao carregar usuário antigo:', error));
//             }
//         },

//         toggle: function() {
//             this.state = !this.state;
//             this.filter = ''; // Limpa o filtro ao abrir/fechar
//             if (this.state) {
//                 // Ao abrir, se já tiver um item selecionado, preenche o filtro com ele
//                 if (this.selectedlabel) {
//                     // Extrai apenas o nome se o label incluir e-mail
//                     const nameMatch = this.selectedlabel.match(/(.*) \(/);
//                     this.filter = nameMatch ? nameMatch[1] : this.selectedlabel;
//                 }
//                 this.$nextTick(() => this.$refs.filterinput.focus()); // Foca no campo de filtro
//                 this.searchUsers(); // Faz uma busca inicial ao abrir (pode mostrar os últimos pesquisados ou todos)
//             }
//         },
//         close: function() {
//             this.state = false;
//         },
//         select: function(value, key) {
//             // Se o item clicado já estiver selecionado, deseleciona
//             if (this.selectedkey === key) {
//                 this.selectedlabel = null;
//                 this.selectedkey = null;
//                 this.filter = ''; // Limpa o filtro também
//             } else {
//                 this.selectedlabel = value; // Texto visível
//                 this.selectedkey = key;     // ID para o input hidden
//                 this.state = false;         // Fecha o menu após a seleção
//                 this.filter = value.split(' (')[0] || value; // Opcional: preenche o filtro com o nome
//             }
//         },
//         isselected: function(key) {
//             return this.selectedkey === key;
//         },
//         // Método para buscar usuários via AJAX (substitui getlist())
//         searchUsers: function() {
//             // Não busca se o filtro estiver muito curto ou vazio, a menos que seja para 'toggle' inicial
//             if (this.filter.length < 2 && this.filter !== '') {
//                 this.results = {}; // Limpa os resultados se o filtro for inválido
//                 return;
//             }

//             // Faz a requisição AJAX
//             fetch(`{{ route('users.search') }}?term=${encodeURIComponent(this.filter)}`)
//                 .then(response => response.json())
//                 .then(data => {
//                     this.results = data; // Atualiza os resultados com os dados da API
//                 })
//                 .catch(error => {
//                     console.error('Erro na busca de usuários:', error);
//                     this.results = {}; // Limpa em caso de erro
//                 });
//         }
//     };
// }

Alpine.start();