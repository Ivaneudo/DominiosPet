
# 🐾 DominiosPet

Sistema web desenvolvido em PHP voltado para a gestão de um pet shop, com funcionalidades específicas para diferentes perfis de usuário: **administrador**, **repositor** e **secretária**.

Este sistema permite o controle completo de clientes, pets, produtos, serviços, vendas e funcionários.

---

## 📌 Funcionalidades

### 👤 Administrador (`/adm`)
- Cadastrar, editar e excluir:
  - Clientes
  - Funcionários
  - Pets
  - Produtos
- Gerenciar estoque e vendas

### 🧑‍🔧 Repositor (`/repositor`)
- Cadastrar e editar produtos
- Gerenciar o estoque
- Remover itens

### 💼 Secretária (`/secretaria`)
- Cadastrar e editar clientes e pets
- Processar pagamentos (dinheiro e serviços)
- Visualizar vendas, serviços e produtos
- Cancelar pagamentos

---

## 🛠 Tecnologias Utilizadas

- **PHP**
- **MySQL**
- **HTML/CSS**
- **JavaScript**
- Organização modular por pasta
- Banco de dados versionado: `petShop.sql`
- Diagrama UML: `petShop_Diagrama.pdf`

---

## ⚙️ Requisitos

- Servidor Apache (XAMPP, WAMP, LAMP ou similar)
- PHP 7.4+
- MySQL ou MariaDB

---

## 🚀 Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/Ivaneudo/DominiosPet.git
   cd DominiosPet
   ```

2. Importe o banco de dados `petShop.sql` para seu MySQL:
   ```sql
   CREATE DATABASE petShop;
   USE petShop;
   -- Importe o arquivo .sql usando o phpMyAdmin ou cliente MySQL
   ```

3. Configure a conexão com o banco em `funcoes/conexao.php`.

4. Coloque o projeto dentro da pasta do servidor (ex: `htdocs` no XAMPP).

5. Acesse no navegador:
   ```
   http://localhost/DominiosPet/entrada/Entrar.php
   ```

---

## 🧭 Estrutura de Pastas

```
.
├── adm/               # Área do administrador
├── repositor/         # Área do repositor
├── secretaria/        # Área da secretária
├── entrada/           # Login e boas-vindas
├── funcoes/           # Scripts de conexão, sessões e exclusões
├── css/               # Estilos CSS
├── js/                # Scripts JavaScript
├── img/               # Imagens usadas na interface
├── petShop.sql        # Script do banco de dados
├── petShop_Diagrama.pdf # Diagrama UML do sistema
```

---

## 🔐 Login e Sessões

- O acesso ao sistema é controlado por sessões (ver `funcoes/SessaoCpf.php`).
- Cada área verifica e redireciona o tipo de usuário apropriado.

---

## 🤝 Contribuindo

1. Faça um fork do projeto
2. Crie sua feature branch: `git checkout -b feature/sua-feature`
3. Commit: `git commit -m 'feat: adiciona nova funcionalidade'`
4. Push: `git push origin feature/sua-feature`
5. Abra um Pull Request

---

## 👥 Colaboradores

- [Ivaneudo](https://github.com/Ivaneudo)
- [Laura](https://github.com/lcruzz)

---

## 📄 Licença

Projeto sob licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

---

**DominiosPet** — Sistema completo e modular para o gerenciamento de pet shops! 🐶🐱
