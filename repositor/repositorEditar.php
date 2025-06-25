<?php
session_start();
include('../funcoes/conexao.php');

// Verifica se o usuário é um repositor
if ($_SESSION['tipo_usuario'] !== 'repositor'){
    header("Location: ../entrada/Entrar.php");
    exit();
}

// Captura o nome do funcionário da sessão
$nomeFuncionario = $_SESSION['usuario'];

// Inicializa variáveis
$codigoProduto = '';
$nomeProduto = '';
$precoProduto = '';
$estoqueProduto = '';
$mensagem = '';
$produtoEncontrado = false;

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se é busca ou modificação
    if (isset($_POST['buscar'])) {
        // Se o código do produto foi enviado
        if (!empty(trim($_POST['codigo']))) {
            $codigoProduto = trim($_POST['codigo']);

            // Busca o produto pelo ID
            $sql = "SELECT id_produto, nome_produto, preco, estoque FROM produto WHERE id_produto = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $codigoProduto);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $produto = $result->fetch_assoc();
                $codigoProduto = $produto['id_produto'];
                $nomeProduto = $produto['nome_produto'];
                $precoProduto = number_format($produto['preco'], 2, ',', '.');
                $estoqueProduto = $produto['estoque'];
                $produtoEncontrado = true;
            } else {
                $mensagem = "Produto não encontrado.";
                $codigoProduto = '';
            }
        } else {
            $mensagem = "Por favor, informe o código do produto.";
        }
    } elseif (isset($_POST['modificar'])) {
        // Valida e sanitiza os dados do formulário
        $codigoProduto = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
        $nomeProduto = isset($_POST['nome']) ? trim($_POST['nome']) : '';
        $precoProduto = isset($_POST['preco']) ? str_replace(['.', ','], ['', '.'], $_POST['preco']) : 0;
        $estoqueProduto = isset($_POST['estoque']) ? intval($_POST['estoque']) : 0;

        if (empty($codigoProduto)) {
            $mensagem = "Código do produto inválido.";
        } elseif (empty($nomeProduto)) {
            $mensagem = "Nome do produto é obrigatório.";
        } else {
            // Atualiza o produto no banco de dados
            $sqlUpdate = "UPDATE produto SET nome_produto = ?, preco = ?, estoque = ? WHERE id_produto = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("sdii", $nomeProduto, $precoProduto, $estoqueProduto, $codigoProduto);

            if ($stmtUpdate->execute()) {
                $mensagem = "Produto atualizado com sucesso!";
                $produtoEncontrado = true;
                
                // Busca os dados atualizados para mostrar no formulário
                $sql = "SELECT nome_produto, preco, estoque FROM produto WHERE id_produto = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $codigoProduto);
                $stmt->execute();
                $result = $stmt->get_result();
                $produto = $result->fetch_assoc();
                
                $nomeProduto = $produto['nome_produto'];
                $precoProduto = number_format($produto['preco'], 2, ',', '.');
                $estoqueProduto = $produto['estoque'];
            } else {
                $mensagem = "Erro ao atualizar o produto: " . $stmtUpdate->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Produto</title>
    <link rel="shortcut icon" href="../img/Logo-Pethop-250px .ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/principal.css" />
    <link rel="stylesheet" href="../css/repositor.css" />
    <link rel="stylesheet" href="../css/responsivo.css">
    <link rel="stylesheet" href="../css/mensagem.css">
    <link rel="stylesheet" href="../css/Vendas.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codigoProduto = "<?php echo $codigoProduto; ?>";
            const voltarSomeDiv = document.querySelector('.voltarSome');
            
            if (codigoProduto && voltarSomeDiv) {
                voltarSomeDiv.style.display = 'none';
            }
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="funcionario">
            <div class="funci">
                <img src="../img/Logo-Pethop-250px.png" alt="Logo Pethop" />
                <p>Olá <span id="colaborador"><?php echo htmlspecialchars($nomeFuncionario); ?></span>, bem-vindo a mais um dia de trabalho!</p>
            </div>
            <div class="sair">
                <a href="../funcoes/logout.php"><img src="../img/sair.svg" alt="Sair"></a>
            </div>
        </div>
        <div class="cadastrar" id="repositor">
            <div class="cadastro">
                <?php if ($mensagem): ?>
                    <div class="mensagem-<?php echo strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro'; ?>">
                        <?php echo htmlspecialchars($mensagem); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="pesquisa-produto">
                        <h3>Editar Produto:</h3>
                        <label for="codigo">Pesquisar ID do Produto:</label>
                        <input
                            type="number"
                            name="codigo"
                            id="codigo"
                            placeholder="Digite o ID do produto"
                            autocomplete="off"
                            value="<?php echo htmlspecialchars($codigoProduto); ?>"
                            min="1"
                            required>
                        <button type="submit" name="buscar">Buscar</button>
                    </div>
                </form>

                <?php if ($produtoEncontrado): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigoProduto); ?>">
                        
                        <div class="cliente">
                            <div class="colunas">
                                <div class="coluna">
                                    <label for="codigo">Código do produto:</label>
                                    <input
                                        type="text"
                                        class="NomeCliente"
                                        placeholder="Código do Produto"
                                        value="<?php echo htmlspecialchars($codigoProduto); ?>"
                                        disabled
                                        style="color: #6c6b6b; cursor: not-allowed;">

                                    <label for="preco">Preço:</label>
                                    <input
                                        type="text"
                                        id="preco"
                                        name="preco"
                                        placeholder="Preço do produto"
                                        autocomplete="off"
                                        value="<?php echo htmlspecialchars($precoProduto); ?>"
                                        required>
                                </div>

                                <div class="coluna">
                                    <label for="nome">Nome do produto:</label>
                                    <input
                                        type="text"
                                        name="nome"
                                        class="Telefone"
                                        placeholder="Nome do produto"
                                        autocomplete="off"
                                        value="<?php echo htmlspecialchars($nomeProduto); ?>"
                                        required>

                                    <label for="estoque">Estoque:</label>
                                    <input
                                        type="number"
                                        name="estoque"
                                        class="Email"
                                        placeholder="Quantidade em estoque"
                                        autocomplete="off"
                                        min="0"
                                        value="<?php echo htmlspecialchars($estoqueProduto); ?>"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="botoes">
                            <div>
                                <a href="repositor.php">
                                    <button class="voltar" id="volt" type="button">Voltar</button>
                                </a>
                            </div>
                            <div>
                                <button name="modificar" id="cade" type="submit">Modificar</button>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>