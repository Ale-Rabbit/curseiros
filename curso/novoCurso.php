
<?php 

$sucesso = false;

if (isset($_POST) &&
    !empty($_POST) &&
    !(empty($_POST['titulo'])) && 
    !(empty($_FILES['imagemCurso'])) && 
    !(empty($_POST['descricao']))) {

    try {

        $conexao = new PDO("mysql:dbname=curseiros;host=localhost","root","");

        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $imagem = $_FILES['imagemCurso']["tmp_name"];

        $imagemCursoEncode = base64_encode(file_get_contents($imagem));
        
        $query = $conexao->prepare("INSERT INTO tb_curso (nome, descricao, imagem) 
                                    VALUES (:nome, :descricao, :imagem)");
                    
        $query->bindParam(":nome",$titulo);
        $query->bindParam(":descricao",$descricao);
        $query->bindParam(":imagem",$imagemCursoEncode);
        
        $result = $query->execute();
        
        $tituloNovoCurso = $_POST['titulo'];

        if(!$result){

            $erro = $query->errorInfo()[1];
            $msgErro = "Erro ao inserir curso: $erro";
            
        } else {
            $sucesso = true;
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

    <!-- Fonte: -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <title>Cursos para curseiros</title>
</head>
<body>
    
    <header>
        <div class="center">
            <h1>Cadastro de curso</h1>
        </div>
    </header>

    <div class="container">

        <div>

            <?php 
                if (isset($msgErro)) {
            ?>  
                <p class="center"> <?php echo "$msgErro" ?> </p>
                <p class="center"> <a href="homeAdm.php"> Ir para cursos</a> </p>

            <?php
                } else if($sucesso) {
            ?>
                <p class="center roxo"> <?php echo isset($nomeUsuario) ? "Curso $tituloNovoCurso inserido com sucesso!" : "Curso inserido" ?> </p>

            <?php
                }
            ?>

            <form enctype="multipart/form-data" action="novoCurso.php" method="post" class="center novoCurso">

                <input class="acessar center block" type="text" name="titulo" placeholder="Título" required>
                <input class=" acessar center block" type="file" name="imagemCurso" required>
                <textarea class="acessar center block" maxlength= "200" name="descricao" rows="5" cols="33" placeholder="breve descrição sobre o curso " required></textarea>

                <div>
                    <button type="submit" class="botaoRoxo">Enviar</button>
                </div>

                <div class="block box-opcoes">
                    <input class="inlineBlock botaoRoxo limpar" type="reset" value="Limpar">
                    <a href="homeAdm.php" class="inlineBlock botaoRoxo"><p>Voltar</p></a>
                </div>
                
            </form>


        </div>

    </div>

</body>

</html>