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
            <h1>Cadastro de curso</h1>
        </div>
    </header>

    <div class="container">

        <div>

            <form action="homeAdm.php" method="post" enctype="multipart/form-data" class="center">

                <input class="acessar center block" type="text" name="titulo" placeholder="Título">
                <input type="file" name="imagemCurso">

                <textarea maxlength= "200" name="descricao" rows="5" cols="33" placeholder="breve descrição sobre o curso "></textarea>

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