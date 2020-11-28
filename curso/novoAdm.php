
<?php 

$aparecerLogar = false;
$aparecerFormularioDeCadastro = true;

if (isset($_POST) &&
    !empty($_POST) &&
    !(empty($_POST['user'])) && 
    !(empty($_POST['nome'])) && 
    !(empty($_POST['senha']))) {

    $aparecerFormularioDeCadastro = false;

    try {

        $conexao = new PDO("mysql:dbname=curseiros;host=localhost","root","");

        $login = $_POST['user'];
        $senha = $_POST['senha'];
        $flagAdm = "S";
        
        $stmt = $conexao->prepare("SELECT usuario_pk FROM tb_usuario WHERE login = :login AND 
                                                                           senha = :senha AND 
                                                                           flAdministrador = :flagAdm");
        
        $stmt->execute(array(':login' => $login, ':senha' => $senha, ':flagAdm' => $flagAdm));
        
        $retorno = $stmt->fetchall(PDO::FETCH_ASSOC);
        
        if (isset($retorno) && !empty($retorno)) {
            
            $msgErro = "Você já esta cadastrado (a). Acesse o sistema na tela de login! ";
            $aparecerLogar = true;

        } else {

            $query = $conexao->prepare("INSERT INTO tb_usuario (nome, flAdministrador,login,senha) 
                                       VALUES (:nome,:flAdministrador,:login,:senha)");
                    
            $query->bindParam(":nome",$_POST['nome']);
            $query->bindParam(":flAdministrador",$flagAdm);
            $query->bindParam(":login",$login);
            $query->bindParam(":senha",$senha);
            
            $result = $query->execute();
            
            $nomeUsuario = $_POST['nome'];

            if(!$result){

                $erro = $query->errorInfo()[1];
                $msgErro = "Erro ao inserir usuário: $erro";
                
            }


        }

    } catch ( PDOException $e ) {
        $msgErro = "Erro em conexão com banco: ".$e->getMessage();
    }       

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos para curseiros</title>
</head>
<body>
    
    <header>
        <div class="center">
            <h1>Cadastro de Administradores</h1>
        </div>
    </header>

    <div class="container">

        <div>

            <?php 
                if ($aparecerFormularioDeCadastro) {
            ?>

                <form action="novoAdm.php" method="post" class="center"> 

                    <input class="acessar center block" type="text" name="nome" placeholder="seu nome" required>
                    <input class="acessar center block" type="text" name="user" placeholder="seu login">
                    <input class="acessar center block" type="password" name="senha" placeholder="sua senha" >

                    <div>
                        <button type="submit" class="botaoRoxo">Cadastrar</button>
                    </div>
                    
                </form>

            <?php 
                } elseif ($aparecerLogar && isset($msgErro)) {
            ?>

                <p class="erro center"> <?php echo "$msgErro" ?> </p>
                <p class="erro center"> <a href="loginAdm.php"> Ir para login</a> </p>
            
            <?php 
                } elseif (isset($msgErro)) {
            ?>
                <p class="erro center"> <?php echo "$msgErro" ?> </p>

            <?php
                } else{
            ?>
                <div>
                    <h2 class="erro center"> Usuário administrador cadastrado com sucesso. </h2>
                    <p> <?php echo isset($nomeUsuario) ? "Parabéns administrador, $nomeUsuario !" : "Parabéns!" ?> </p>
                    
                    <p class="center"> <a href="loginAdm.php"> Ir para login</a> </p>
                </div>

            <?php
                }
            ?>

        </div>

    </div>

</body>

</html>