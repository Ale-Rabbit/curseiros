
<?php

    $aparecerCadastrese = false;
    if (isset($_POST)) {

        try {

            $conexao = new PDO("mysql:dbname=curseiros;host=localhost","root","");

            // PROCESSO DE LOGIN
            if ( isset($_POST['user']) &&
                 isset($_POST['senha']) &&
                 (!empty($_POST['user'])) &&
                 (!empty($_POST['senha'])) ) {

                $login = $_POST['user'];
                $senha = $_POST['senha'];
                
                $stmt = $conexao->prepare("SELECT usuario_pk, nome FROM tb_usuario WHERE login = :login AND senha = :senha ");
                $stmt->execute(array(':login' => $login, ':senha' => $senha));
                
                $retorno = $stmt->fetchall(PDO::FETCH_ASSOC);
                
                if (isset($retorno) && !empty($retorno)) {
                    
                    foreach ($retorno as $row){
                        foreach ($row as $key => $value) {

                            if ($key == 'usuario_pk') {
                                setcookie("PK_USUARIO_ATUAL", $value, time() + 30000);
                            } else if($key == 'nome') {
                                setcookie("NOME_USUARIO_ATUAL", $value, time() + 30000);
                            }
                        }
                    }
                    
                } else {
                    $msgErroUsuario = "Usuário inválido.";
                    $aparecerCadastrese = true;
                }

            } else {

                // PROCESSO DE INSERIR CURSOS PARA USUÁRIO
                if ( isset($_POST['cursosParaFazer']) && !(empty($_POST['cursosParaFazer'])) ) {

                    foreach ($_POST['cursosParaFazer'] as $pkCursoParaFazer) {

                        $query = $conexao->prepare("INSERT INTO tb_curso_usuario (fk_usuario, fk_curso)
                                                   VALUES (:fkUsuario, :fkCurso)");

                        $pkUsuario = json_decode($_COOKIE["PK_USUARIO_ATUAL"]);

                        $query->bindParam(":fkUsuario", $pkUsuario);
                        $query->bindParam(":fkCurso", $pkCursoParaFazer);

                        $cursoInserido = $query->execute();

                        if (!$cursoInserido){

                            $erro = $query->errorInfo()[0];
                            $msgErroParaCadastrar = "Erro ao inserir curso $pkCursoParaFazer";

                        }

                    }

                } else {
                    $msgErroParaCadastrar = "Você deve selecionar algum curso para fazer.";
                }

            }

            // PROCESSO DE CARREGAMENTO DE CURSOS DISPONÍVEIS
            $stmt = $conexao->prepare("SELECT c.* FROM tb_curso c 
                                       WHERE c.curso_pk NOT IN 
                                            (SELECT cu.fk_curso FROM tb_curso_usuario cu WHERE fk_usuario = :fk_usuario_atual);");

            $stmt->execute(array(':fk_usuario_atual' => json_decode($_COOKIE["PK_USUARIO_ATUAL"])));
            $cursosDisponiveis = $stmt->fetchall(PDO::FETCH_ASSOC);

            $carregouCursosDisponiveis = false;
            if (isset($cursosDisponiveis) && !empty($cursosDisponiveis)) {
                $carregouCursosDisponiveis = true;
            } else {
                $msgErroCursosDisponiveis = "Uau! Você já está cadastrado em todos os cursos.";
            }

            // PROCESSO DE CARREGAMENTO DE CURSOS JÁ MATRICULADO
            $stmt = $conexao->prepare("SELECT c.* FROM tb_curso c 
                                       WHERE c.curso_pk IN 
                                            (SELECT cu.fk_curso FROM tb_curso_usuario cu WHERE fk_usuario = :fk_usuario_atual);");

            $stmt->execute(array(':fk_usuario_atual' => json_decode($_COOKIE["PK_USUARIO_ATUAL"])));
            $cursosMatriculados = $stmt->fetchall(PDO::FETCH_ASSOC);

            $carregouCursosMatriculados = false;

            if (isset($cursosMatriculados) && !empty($cursosMatriculados)) {
                $carregouCursosMatriculados = true;
            } else {
                $msgErroCursosMatriculados = "Você não esta fazendo nenhum curso. ";
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
            <h1>Cursos para curseiros</h1>
        </div>
        <p> <a href="../index.html">Voltar para o inicio</a> </p>
    </header>

    <div class="container">

        <div>

            <div>

                <?php 
                    if ($aparecerCadastrese && isset($msgErroUsuario)) {
                ?>
                    <p class="erro center"> <?php echo "$msgErroUsuario" ?> </p>
                    <p class="erro center"> <a href="loginUsuario.php">tente novamente</a> ou </p>
                    <p class="erro center"> <a href="novoUsuario.php">faça um cadastro</a> </p>

                <?php
                    } else if(isset($msgErro)) {
                ?>
                    <p class="erro center"> <?php echo "$msgErro" ?> </p>
                <?php
                    } else {
                ?>

                    <?php
                        if ( isset($msgErroParaCadastrar)) {
                    ?>
                        <p class="erro center"> <?php echo "$msgErroParaCadastrar" ?> </p>
                    <?php
                        }
                    ?>

                    <h2>Cursos disponíveis</h2>

                    <?php
                        if ( isset($carregouCursosDisponiveis) && !$carregouCursosDisponiveis && isset($msgErroCursosDisponiveis)) {
                    ?>
                        <p class="erro center"> <?php echo "$msgErroCursosDisponiveis" ?> </p>
                    <?php
                        } else { ?>

                            <div>

                                <form action="homeUsuario.php" method="post">
                                    <ul>

                                    <?php
                                        foreach ($cursosDisponiveis as $row) {
                                        $valores = array_values($row);
                                    ?>
                                            <li>
                                                <input type="checkbox" name="cursosParaFazer[]" value="<?php print_r($valores[0]);?>"/> Fazer este curso
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
                                        <button type="submit">Fazer cursos selecionados</button>
                                    </div>

                                </form>

                            </div>

                    <?php
                        }
                    ?>

                    <h2>Cursos matriculados</h2>

                    <?php
                        if ( isset($carregouCursosMatriculados) && !$carregouCursosMatriculados && isset($msgErroCursosMatriculados)) {
                    ?>
                        <p class="erro center"> <?php echo "$msgErroCursosMatriculados" ?> </p>
                    <?php
                        } else { ?>

                            <div>

                                <ul>

                                    <?php
                                        foreach ($cursosMatriculados as $row) {
                                        $valores = array_values($row);
                                    ?>
                                        <li>
                                            <h3><?php print_r($valores[1]);?></h3>
                                            <div>
                                                <img src="<?php print_r("data:image/png;base64,".$valores[3]);?>" alt="Imagem do curso">
                                            </div>

                                            <form action="certificado.php" method="post" target="_blank">
                                                <input type="radio" name="concluir" value="<?php print_r($valores[0]);?>" required /> Concluir
                                                <input type="hidden" name="nomeCurso" value="<?php print_r($valores[1]);?>" />
                                                <div>
                                                    <button type="submit">Gerar certificado</button>
                                                </div>
                                            </form>

                                        </li>
                                    <?php
                                        }
                                    ?>

                                </ul>

                            </div>

                    <?php
                        }
                    ?>

                <?php
                    }
                ?>

            </div>

        </div>

    </div>

</body>

</html>