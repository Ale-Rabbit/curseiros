
<?php

    $aparecerCadastrese = false;
    $menosDeTresCursosNabase = false;
    $menosDeTresParaUsuario = false;

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
                            }
                            if($key == 'nome') {
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

            
            if (isset($_COOKIE['PK_USUARIO_ATUAL'])) {
                $stmt->execute(array(':fk_usuario_atual' => $_COOKIE["PK_USUARIO_ATUAL"]));
            }

            $cursosDisponiveis = $stmt->fetchall(PDO::FETCH_ASSOC);

            $carregouCursosDisponiveis = false;
            if (isset($cursosDisponiveis) && !empty($cursosDisponiveis)) {
                $carregouCursosDisponiveis = true;

                if(sizeof($cursosDisponiveis) < 3) {
                    $menosDeTresCursosNabase = true;
                }

            } else {
                $msgErroCursosDisponiveis = "Uau! Você já está cadastrado em todos os cursos.";
            }

            // PROCESSO DE CARREGAMENTO DE CURSOS JÁ MATRICULADO
            $stmt = $conexao->prepare("SELECT c.* FROM tb_curso c 
                                       WHERE c.curso_pk IN 
                                            (SELECT cu.fk_curso FROM tb_curso_usuario cu WHERE fk_usuario = :fk_usuario_atual);");

            if (isset($_COOKIE['PK_USUARIO_ATUAL'])) {
                $stmt->execute(array(':fk_usuario_atual' => $_COOKIE["PK_USUARIO_ATUAL"]));
            }

            $cursosMatriculados = $stmt->fetchall(PDO::FETCH_ASSOC);

            $carregouCursosMatriculados = false;

            if (isset($cursosMatriculados) && !empty($cursosMatriculados)) {
                $carregouCursosMatriculados = true;

                if(sizeof($cursosMatriculados) < 3) {
                    $menosDeTresParaUsuario = true;

                }

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

    <link rel="stylesheet" href="../css/main.css">
    
    <!-- Slide-->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">

    <!-- Fonte: -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <title>Cursos para curseiros</title>
</head>
<body>
    
    <header>
        <div class="center">
            <h1>Cursos para curseiros</h1>
        </div>
    </header>
    
    <section class="container containerhomeUsuario">

        <div>
            <p class="right"> <a href="../index.html" class="linkRoxo voltar">Voltar para o inicio</a> </p>
        </div>

        <div>
    
            <div>
    
                <div>
    
                    <?php 
                        if ($aparecerCadastrese && isset($msgErroUsuario)) {
                    ?>
                        <p class="vermelho center"> <?php echo "$msgErroUsuario" ?> </p>
                        <p class="center"> <a href="loginUsuario.php">tente novamente</a> ou </p>
                        <p class="center"> <a href="novoUsuario.php">faça um cadastro</a> </p>
    
                    <?php
                        } else if(isset($msgErro)) {
                    ?>
                        <p class="vermelho center"> <?php echo "$msgErro" ?> </p>
                    <?php
                        } else {
                    ?>
    
                        <?php
                            if ( isset($msgErroParaCadastrar)) {
                        ?>
                            <p class="vermelho center"> <?php echo "$msgErroParaCadastrar" ?> </p>
                        <?php
                            }
                        ?>
    
                        <h2 class="center roxo">Cursos disponíveis</h2>
    
                        <?php
                            if ( isset($carregouCursosDisponiveis) && !$carregouCursosDisponiveis && isset($msgErroCursosDisponiveis)) {
                        ?>
                            <p class="vermelho center"> <?php echo "$msgErroCursosDisponiveis" ?> </p>
                        <?php
                            } else { ?>
    
                                <div class="splide center cursosDisponiveis">
    
                                    <form action="homeUsuario.php" method="post" class="splide__track">
                                        <ul class="splide__list">
    
                                        <?php
                                            foreach ($cursosDisponiveis as $row) {
                                            $valores = array_values($row);
                                        ?>
                                                <li class="splide__slide">
                                                    <input type="checkbox" name="cursosParaFazer[]" value="<?php print_r($valores[0]);?>"/> <b>Fazer este curso</b>
                                                    <h3 class="roxo m10"><?php print_r($valores[1]);?></h3>
                                                    <div>
                                                        <img src="<?php print_r("data:image/png;base64,".$valores[3]);?>" alt="Imagem do curso">
                                                    </div>
                                                    <p><?php print_r($valores[2]);?></p>
                                                </li>
                                        <?php
                                            }
                                        ?>
    
                                        </ul>
    
                                        <div class="m50">
                                            <button type="submit" class="botaoRoxo" id="botaoFazerCursosSelecionados">Fazer cursos selecionados</button>
                                        </div>
    
                                    </form>
    
                                </div>
                                
                                <?php
                                    if ( isset($menosDeTresCursosNabase) && $menosDeTresCursosNabase) {
                                ?>
                                    <script> new Splide( '.splide.cursosDisponiveis' ).mount(); </script>
                                <?php
                                    } else {
                                ?>
                                        <script>
                                            new Splide( '.splide.cursosDisponiveis', {
                                                perPage: 3,
                                                rewind: true,
                                                pagination: false
                                            } ).mount();
                                        </script>
                                <?php
                                    }
                                ?>
    
                        <?php
                            }
                        ?>
    
                        <h2 class="roxo center">Cursos matriculados</h2>
    
                        <?php
                            if ( isset($carregouCursosMatriculados) && !$carregouCursosMatriculados && isset($msgErroCursosMatriculados)) {
                        ?>
                            <p class="vermelho center"> <?php echo "$msgErroCursosMatriculados" ?> </p>
                        <?php
                            } else { ?>
    
                                <div class="splide center cursosMatriculados">

                                    <div class="splide__track">
        
                                        <ul class="splide__list" >
        
                                            <?php
                                                foreach ($cursosMatriculados as $row) {
                                                $valores = array_values($row);
                                            ?>
                                                    <li class="splide__slide">
                                                        <h3 class="roxo" ><?php print_r($valores[1]);?></h3>
                                                        <div>
                                                            <img src="<?php print_r("data:image/png;base64,".$valores[3]);?>" alt="Imagem do curso">
                                                        </div>
            
                                                        <form action="certificado.php" method="post" target="_blank">
                                                            <div class="m10 roxo">
                                                                <input type="radio" name="concluir" value="<?php print_r($valores[0]);?>" required /> <b>Concluir</b>
                                                            </div>
                                                            <input type="hidden" name="nomeCurso" value="<?php print_r($valores[1]);?>" />
                                                            <div>
                                                                <button type="submit" class="botaoRoxo">Gerar certificado</button>
                                                            </div>
                                                        </form>
                                                    </li>
                                            <?php
                                                }
                                            ?>
        
                                        </ul>
        
                                    </div>

                                </div>

                                <?php
                                    if ( isset($menosDeTresParaUsuario) && $menosDeTresParaUsuario) {
                                ?>
                                    <script> new Splide( '.splide.cursosMatriculados', {pagination: false} ).mount(); </script>
                                <?php
                                    } else {
                                ?>
                                        <script>
                                            new Splide( '.splide.cursosMatriculados', {
                                                perPage: 3,
                                                rewind: true,
                                                pagination: false
                                            } ).mount();
                                        </script>
                                <?php
                                    }
                                ?>
    
                        <?php
                            }
                        ?>
    
                    <?php
                        }
                    ?>
    
                </div>
    
            </div>
    
        </div>

    </section>

</body>

</html>