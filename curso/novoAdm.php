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

            <form action="novoAdm.php" method="post" class="center"> 

                <input class="acessar center block" type="text" name="user" placeholder="seu login">
                <input class="acessar center block" type="password" name="senha" placeholder="sua senha" >

                <div>
                    <button type="submit" class="botaoRoxo">Cadastrar</button>
                </div>
                
            </form>

            <div>

                <p>É necessário enviar todos os campos</p>
                <p>Cadastrado com sucesso!</p>

                <div>
                <a href="loginAdm.php">Logar</a>
            </div>

            </div>

        </div>

    </div>

</body>

</html>