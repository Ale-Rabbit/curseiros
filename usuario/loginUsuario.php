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
            <h1>Acesse sua conta</h1>
        </div>
    </header>

    <div class="container">

        <div>

            <form action="homeUsuario.php" method="post" class="center">

                <input class="acessar center block" type="text" name="user" required>
                <input class="acessar center block" type="password" name="senha" required>

                <div>
                    <button type="submit" class="botaoRoxo">Entrar</button>
                </div>

                <div class="block box-opcoes">
                    <input class="inlineBlock botaoRoxo limpar" type="reset" value="Limpar">
                    <a href="novoUsuario.php" class="inlineBlock botaoRoxo"><p>Cadastrar</p></a>
                </div>
                
            </form>


        </div>

    </div>

</body>

</html>