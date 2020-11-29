
<?php 

    $aparecerCadastrese = false;
    $vindoDaPaginaLogarAdm = !(empty($_POST['vindoDaPaginaLogarAdm']));

    try {

        $conexao = new PDO("mysql:dbname=curseiros;host=localhost","root","");
        
        if ($vindoDaPaginaLogarAdm && isset($_POST) && !empty($_POST)) {

            // PROCESSO DE LOGIN
            if ( !(empty($_POST['user'])) && !(empty($_POST['senha'])) ) {

                $login = $_POST['user'];
                $senha = $_POST['senha'];
                
                $stmt = $conexao->prepare("SELECT flAdministrador FROM tb_usuario WHERE login = :login AND senha = :senha ");
                $stmt->execute(array(':login' => $login, ':senha' => $senha));
                
                $retorno = $stmt->fetchall(PDO::FETCH_ASSOC);
                
                if (isset($retorno) && !empty($retorno)) {
                    
                    foreach ($retorno as $row) {
                        foreach ($row as $key => $value) {
                            if ($value == 'N') {
                                $msgErro = "Ei! Você não é um Administrador.";
                                break;
                            }
                        }
                    }

                    
                } else {
                    $msgErro = "Usuário inválido.";
                    $aparecerCadastrese = true;
                }

            }

            // PROCESSO DE CARREGAMENTO DO CURSO
            $stmt = $conexao->prepare("SELECT * FROM tb_curso");

            $stmt->execute();
            $cursos = $stmt->fetchall(PDO::FETCH_ASSOC);

            $carregouCursos = false;
            if (isset($cursos) && !empty($cursos)) {
                $carregouCursos = true;
            } else {
                $msgErro = "Ainda não possui nenhum curso cadastrado. Entre em contato com algum administrador";
            }
            
            $vindoDaPaginaLogarAdm = false;

        } else {

            // PROCESSO DE EXCLUSÃO DO CURSO
            if (!(empty($_POST['apagar']))) {

                foreach ($_POST['apagar'] as $pkCursoParaApagar) {
                    $stmt = $conexao->prepare("DELETE FROM tb_curso WHERE curso_pk = :curso");
                    $stmt->execute(array(':curso' => $pkCursoParaApagar));

                    if ($stmt == false) {
                        $msgErro = "Erro ao excluir curso $pkCursoParaApagar";
                    }

                }

            }

            // PROCESSO DE CARREGAMENTO DO CURSO
            $stmt = $conexao->prepare("SELECT * FROM tb_curso");

            $stmt->execute();
            $cursos = $stmt->fetchall(PDO::FETCH_ASSOC);

            $carregouCursos = false;
            if (isset($cursos) && !empty($cursos)) {
                $carregouCursos = true;
            } else {
                $msgErro = "Ainda não possui nenhum curso cadastrado. Entre em contato com algum administrador";
            }

        }

    } catch ( PDOException $e ) {
        $msgErro = "Erro em conexão com banco: ".$e->getMessage();
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
            <h1>Cursos para curseiros</h1>
        </div>
    </header>

    <div class="container">

        <div>

            <div>

                <?php 
                    if ($aparecerCadastrese && isset($msgErro)) {
                ?>
                    <p class="erro center"> <?php echo "$msgErro" ?> </p>
                    <p class="erro center"> <a href="loginAdm.php">tente novamente</a> ou </p>
                    <p class="erro center"> <a href="novoAdm.php">faça um cadastro</a></p>
                <?php 
                    } elseif (isset($msgErro)) {
                ?>
                    <p class="erro center"> <?php echo "$msgErro" ?> </p>
                    <p class="erro center"> <a href="../index.html">Voltar para página inicial</a></p>
                    <a href="novoCurso.php" class="inlineBlock botaoRoxo"><p>Cadastrar novo curso</p></a>
                <?php
                    } else {
                ?>
                    <h2>Todos os cursos</h2>

                    <?php 
                        if (isset($msgErro)) {
                    ?>
                            <p class="erro center"> <?php echo "$msgErro" ?> </p>

                    <?php 
                        }
                        if (isset($carregouCursos) && $carregouCursos) {
                    ?>
                            <div>
        
                                <form action="homeAdm.php" method="post">

                                    <ul>
                                    <?php 
                                        foreach ($cursos as $row) {
                                        $valores = array_values($row);
                                    ?>
                                            <li>
                                                <input type="checkbox" name="apagar[]" value="<?php print_r($valores[0]);?>"/> Apagar
                                                <h3><?php print_r($valores[1]);?></h3>
                                                <div>
                                                    <img src="<?php print_r("data:image/png;base64,".$valores[3]);?>" alt="Imagem do curso">
                                                </div>
                                                <p><?php print_r($valores[2]);?></p>
                                            </li>
                                    <?php
                                        }
                                    ?>
                                        
                                    </ul>
        
                                    <div>
                                        <button type="submit">Executar exclusões</button>
                                    </div>
        
                                </form>
        
                            </div>

                    <?php 
                        } else {
                    ?>
                        <p class="erro center"> <?php echo isset($msgErro) ? "$msgErro" : ""; ?> </p>
                    <?php
                        }
                    }
                    ?>
                    
                    <?php 
                        if (!isset($msgErro)) {
                    ?>
                            <a href="novoCurso.php" class="inlineBlock botaoRoxo"><p>Cadastrar novo curso</p></a>
                    <?php 
                        }
                    ?>

            </div>


        </div>

    </div>

</body>

</html>