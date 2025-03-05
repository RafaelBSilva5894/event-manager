# Event Manager 🎟️

Event Manager é um sistema web desenvolvido em **Laravel 12** para **gestão de eventos**. Ele permite que **administradores** criem eventos e que **participantes** se inscrevam neles. O sistema conta com **autenticação, autorização, interface responsiva** e testes automatizados.

## 🚀 Tecnologias Utilizadas
- **Laravel 12** (Framework PHP)
- **MySQL** (Banco de Dados)
- **Tailwind CSS** (Estilização Frontend)
- **Blade Components** (Templates)
- **Font Awesome** (Ícones)
- **PHPUnit** (Testes)

---

## 📌 Requisitos do Sistema

Antes de instalar o projeto, certifique-se de ter os seguintes requisitos:

- **PHP** `>= 8.2`
- **Composer** `>= 2.0`
- **MySQL** `>= 5.7`
- **Node.js** `>= 16.0` (para compilação do frontend)
- **NPM** `>= 8.0`

---

## ⚙️ Instalação e Configuração

## 1️⃣ **Clonar o repositório**
git clone https://github.com/RafaelBSilva5894/event-manager.git

cd event-manager

## 2️⃣ Instalar dependências
composer install

npm install

## 3️⃣ Configurar o arquivo .env
Crie uma cópia do arquivo .env.example e renomeie para .env:

cp .env.example .env

Agora, edite o arquivo .env e configure os dados do banco de dados:

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=event_manager

DB_USERNAME=root

DB_PASSWORD=sua_senha


## 4️⃣ Gerar chave da aplicação
php artisan key:generate

## 5️⃣ Criar o banco de dados e rodar as migrations
php artisan migrate --seed

## 6️⃣ Iniciar o servidor Laravel
php artisan serve

Agora, acesse no navegador:
🔗 http://127.0.0.1:8000

## 7️⃣ Usar o Tinker para criar ou alterar usuários

1. Para criar ou alterar usuários usando o Tinker, siga os passos abaixo:

     Abrir o Tinker:

        php artisan tinker


2. Criar um novo usuário participante:

     $user = new App\Models\User();

     $user->name = 'Nome do Participante';

     $user->email = 'participante@example.com';

     $user->password = bcrypt('sua_senha');

     $user->role = 'participante'; // ou 'admin' para administrador

     $user->save();

3. Alterar um usuário existente:

     $user = App\Models\User::find(1);  // Substitua '1' pelo ID do usuário

     $user->name = 'Novo Nome';

     $user->email = 'novo_email@example.com';

     $user->role = 'admin';   //Altere o papel do usuário

     $user->save();

---

## ✅ Executando os Testes
Para rodar os testes automatizados com PHPUnit, utilize o comando:

php artisan test

Para rodar um teste específico:

php artisan test --filter NomeDoTeste

---

## 🎯 Uso da Aplicação

📌 Fluxo para Administradores

1. Criar eventos pelo painel administrativo
2. Gerenciar inscrições de participantes
3. Modificar ou excluir eventos


📌 Fluxo para Participantes

1. Criar uma conta
2. Inscrever-se em eventos disponíveis
3. Visualizar detalhes do evento
---

📄 Licença

Este projeto está licenciado sob a MIT License. Veja o arquivo LICENSE para mais detalhes.

---

🤝 Contribuição

Contribuições são bem-vindas! Se quiser sugerir melhorias ou relatar problemas, sinta-se à vontade para abrir uma Issue ou um Pull Request.

📌 Passos para contribuir

1. Fork o repositório
2. Crie uma branch para sua feature (git checkout -b minha-melhoria)
3. Faça suas alterações e commit (git commit -m "Minha melhoria")
4. Envie para o repositório (git push origin minha-melhoria)
5. Abra um Pull Request
