# VitaCare - Clínica Médica

Projeto de website para clínica médica desenvolvido para fins educacionais.

## Estrutura do Projeto

```
clinica_web/
├── index.html              # Página inicial (na raiz)
├── css/                    # Arquivos de estilo
│   ├── geral.css          # Estilos compartilhados
│   ├── index.css          # Estilos específicos da página inicial
│   ├── agendamento.css    # Estilos da página de agendamento
│   ├── contato.css        # Estilos da página de contato
│   ├── galeria.css        # Estilos da página de galeria
│   ├── login.css          # Estilos da página de login
│   ├── dashboard.css      # Estilos do dashboard
│   └── tabelas.css        # Estilos para páginas com tabelas
├── js/                     # Arquivos JavaScript
│   ├── geral.js           # Funções compartilhadas
│   ├── index.js           # JavaScript da página inicial
│   ├── agendamento.js     # JavaScript da página de agendamento
│   ├── contato.js         # JavaScript da página de contato
│   ├── login.js           # JavaScript da página de login
│   ├── dashboard.js       # JavaScript do dashboard
│   └── tabelas.js         # JavaScript para páginas com tabelas
├── img/                    # Imagens do projeto
├── public/                 # Páginas públicas
│   ├── agendamento.html
│   ├── contato.html
│   ├── galeria.html
│   └── login.html
└── restrito/              # Páginas da área restrita
    ├── dashboard.html
    ├── cadastro_funcionario.html
    ├── cadastro_medico.html
    ├── listar_agendamentos.html
    ├── listar_contatos.html
    ├── listar_funcionarios.html
    └── listar_medicos.html
```

## Organização dos Arquivos

### CSS
- **geral.css**: Contém estilos compartilhados por todas as páginas (header, footer, navegação, formulários básicos, etc.)
- **[pagina].css**: Cada página HTML tem seu próprio arquivo CSS com estilos específicos

### JavaScript
- **geral.js**: Contém funções utilitárias compartilhadas (validações, mensagens, navegação ativa)
- **[pagina].js**: Cada página HTML tem seu próprio arquivo JS com funcionalidades específicas

## Funcionalidades

### Página Inicial (index.html)
- Apresentação da clínica
- Informações sobre missão, visão e valores
- Especialidades médicas
- Animações simples

### Agendamento (agendamento.html)
- Formulário de agendamento de consultas
- Seleção dinâmica de especialidades e médicos
- Validação de formulário
- Máscara para telefone

### Contato (contato.html)
- Formulário de contato
- Informações da clínica
- Validação de email

### Login (login.html)
- Autenticação para área restrita
- Credenciais de teste: admin/123456

### Dashboard (dashboard.html)
- Painel administrativo
- Estatísticas animadas
- Verificação de autenticação

## Como Usar

1. Abra o arquivo `index.html` no navegador
2. Navegue pelas páginas usando o menu
3. Para acessar a área restrita, use:
   - Usuário: admin
   - Senha: 123456

## Tecnologias Utilizadas

- HTML5
- CSS3
- JavaScript (ES6+)
- Bootstrap 4.5.2
- Font Awesome 6.0.0

## Características do Código

- **Simples e educativo**: Código organizado e comentado para facilitar o aprendimento
- **Modular**: CSS e JS separados por página para melhor organização
- **Responsivo**: Layout adaptável para diferentes dispositivos
- **Funcional**: Formulários com validação e interatividade

## Observações

- Este é um projeto educacional, não conectado a banco de dados real
- As funcionalidades são simuladas com JavaScript
- Ideal para estudantes aprenderem sobre desenvolvimento web front-end

