<?php
session_start(); // Inicia a sessão no início do arquivo

include_once('db/connect.php');
include_once('db/gdb_mysql.php');

$gdb = new gdb();
$termoAceito = false; // Variável para controlar se o termo foi aceito

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validação dos campos de entrada
    $acessoUsuario = !empty($_POST['acessoUsuario']) ? $conn->real_escape_string($_POST['acessoUsuario']) : null;
    $senhaUsuario = !empty($_POST['senhaUsuario']) ? $_POST['senhaUsuario'] : null;

    if (!$acessoUsuario) {
        echo "<script>alert('Preencha seu usuário');</script>";
    } elseif (!$senhaUsuario) {
        echo "<script>alert('Preencha sua senha');</script>";
    } else {
        // Verificar se o usuário existe no banco de dados
        $sql_code = "SELECT * FROM usuario WHERE acessoUsuario = '$acessoUsuario'";
        $sql_query = $conn->query($sql_code);

        if (!$sql_query) {
            die("Falha na execução do código SQL: " . mysqli_error($conn));
        }

        if ($sql_query->num_rows == 1) {
            $usuario = $sql_query->fetch_assoc();

            // Verificar a senha
            if (password_verify($senhaUsuario, $usuario['senhaUsuario'])) {
                $_SESSION['usuario'] = $usuario; // Armazenar o usuário na sessão

                // Verificar se o termo foi aceito
                if ($usuario['termoAceito'] == 0) {
                    $termoAceito = true; // Setar para true para mostrar o modal
                } else {
                    // Redirecionar para o dashboard se o termo já foi aceito
                    $_SESSION["idUsuario"] = $usuario["idUsuario"];
                    $_SESSION["acessoUsuario"] = $usuario["acessoUsuario"];
                    $_SESSION["permissaoUsuario"] = $usuario["permissaoUsuario"];
                    $_SESSION["nomeUsuario"] = $usuario["nomeUsuario"];
                    header("Location: /TelaDashboard/index.php");
                    exit();
                }
            } else {
                echo "<script>alert('Usuário ou Senha Incorretos');</script>";
            }
        } else {
            echo "<script>alert('Usuário ou Senha Incorretos');</script>";
        }
    }

    // Verificar se o termo deve ser aceito após o post
    if (isset($_POST['aceitarTermos'])) {
        $usuarioId = $_SESSION['usuario']['idUsuario'];
        // Atualizar o termoAceito para 1
        $updateTermo = "UPDATE usuario SET termoAceito = 1 WHERE idUsuario = $usuarioId";
        $conn->query($updateTermo);

        // Redirecionar para o dashboard
        $_SESSION["idUsuario"] = $_SESSION['usuario']["idUsuario"];
        $_SESSION["acessoUsuario"] = $_SESSION['usuario']["acessoUsuario"];
        $_SESSION["permissaoUsuario"] = $_SESSION['usuario']["permissaoUsuario"];
        $_SESSION["nomeUsuario"] = $_SESSION['usuario']["nomeUsuario"];
        header("Location: /TelaDashboard/index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=support_agent" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
</head>

<style>
  .form-aceitacao {
    width: 90%;
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.termos {
    max-height: 350px;
    overflow-y: auto;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 4px;
}

label {
    display: block;
    margin-top: 10px;
    font-size: 16px;
    color: #333;
}

input[type="submit"] {
    display: block;
    margin-top: 20px;
    padding: 10px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

</style>

<body>
    <div class="background"></div>
    <form action="" method="POST">

        <img src="imagens/logoPGSSS.jpg" class="pgs">

        <label for="acessoUsuario">Matrícula/CPF</label>
        <input name="acessoUsuario" type="text" placeholder="Digite aqui" id="nome" required>

        <label for="senhaUsuario">Senha</label>
        <input name="senhaUsuario" type="password" placeholder="Senha" id="Senha" required>

        <input type="submit" value="Entrar">
        <div class="reset_senha">
            <a href="TelaEmail.php">Esqueceu a senha?</a>
        </div>

        <img src="imagens/logo_pmf.jpg" class="logo">
    </form>

    <div class="suporte">
        <p class="posicaoSuporte"><span class="material-symbols-outlined">
support_agent
</span>Suporte</p>
        <p>suporte.pgs@pmf.sc.gov.br</p>
    </div>

    <!-- Modal de Termos de Uso -->
<?php if ($termoAceito): ?>
<div class="modal fade show" id="termoModal" tabindex="-1" aria-labelledby="termoModalLabel" aria-hidden="true" style="display: block; z-index: 1050;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termoModalLabel">Termos de Uso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" class="form-aceitacao">
                    <h3>Aceitação de Termos e Condições</h3>
                    <p>Por favor, leia os termos e condições abaixo:</p>
                    <div class="termos">
                        <p>TERMOS DE USO - SISTEMA DE GESTÃO DE CONTRATOS (SGC)

                        Bem-vindo ao nosso Sistema de Gestão de Contratos. Antes de utilizar nossos serviços, leia atentamente estes Termos de Uso. Ao acessar ou utilizar o sistema, você concorda em cumprir estes termos. Ao acessar ou utilizar nosso Sistema de Gestão de Contratos, você confirma ter lido, compreendido e concordado com estes Termos de Uso.

                        Uso: Você concorda em usar o sistema exclusivamente para a gestão de contratos dentro dos limites estabelecidos por estes Termos de Uso. O uso não autorizado, acesso não autorizado, modificação ou distribuição dos dados, é estritamente proibido.

                        Responsabilidades do Usuário: Você é responsável por manter a confidencialidade de suas credenciais de acesso. Informe-nos imediatamente caso suspeite de qualquer uso não autorizado de sua conta. Você concorda em fornecer informações precisas e atualizadas.

                        Privacidade e Segurança: Comprometemo-nos a proteger sua privacidade e a manter a segurança dos dados armazenados no sistema. Consulte nossa Política de Privacidade para obter informações detalhadas sobre como tratamos suas informações.

                        Atualizações e Modificações: Reservamo-nos o direito de fazer atualizações, modificações ou melhorias no sistema a qualquer momento, sem aviso prévio. Você concorda em aceitar tais atualizações como parte do seu uso contínuo do sistema.

                        Podemos rescindir ou suspender seu acesso ao Sistema de Gestão de Contratos a qualquer momento, sem aviso prévio, se violar estes Termos de Uso. Após a rescisão, você deverá interromper o uso imediato do sistema. Estes termos estão sujeitos a alterações, e é responsabilidade do usuário revisá-los periodicamente.</p>
                    </div>

                    <label>
                        <p>Eu li e aceito os termos e condições.</p>
                        <input type="checkbox" name="aceitarTermos" required>
                    </label>

                    <input type="submit" value="Aceitar">
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-Dg2Qh48mZsFCfWxlVNI7LFoMy+4+/2/MIvS2nY5W+zE3Sw3F+59LZtHso6C0IfVi" crossorigin="anonymous"></script>
</body>
</html>
