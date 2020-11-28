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

                <h2>Todos os cursos</h2>

                <!-- <p>Ainda não possui nenhum curso cadastrado. Entre em contato com algum administrador</p>-->

                <div>

                    <!-- <p>Curso xxx incluido com sucesso</p> -->

                    <form action="homeAdm.php" method="post">
                        <ul>
    
                            <li>
                                <input type="checkbox" name="apagar" value="curso1"/> Apagar
                                <h3>Título do curso 1</h3>
                                <div>
                                    <img src="" alt="Imagem do curso 1">
                                </div>
                                <p>Descrição do curso 1</p>
                            </li>
                            <li>
                                <input type="checkbox" name="apagar" value="curso2"/> Apagar
                                <h3>Título do curso 2</h3>
                                <div>
                                    <img src="" alt="Imagem do curso 2">
                                </div>
                                <p>Descrição do curso 2</p>
                            </li>
                            <li>
                                <input type="checkbox" name="apagar" value="curso3"/> Apagar
                                <h3>Título do curso 3</h3>
                                <div>
                                    <img src="" alt="Imagem do curso 3">
                                </div>
                                <p>Descrição do curso 3</p>
                            </li>
                            <li>
                                <input type="checkbox" name="apagar" value="curso4"/> Apagar
                                <h3>Título do curso 4</h3>
                                <div>
                                    <img src="" alt="Imagem do curso 4">
                                </div>
                                <p>Descrição do curso 4</p>
                            </li>
                            <li>
                                <input type="checkbox" name="apagar" value="curso5"/> Apagar
                                <h3>Título do curso 5</h3>
                                <div>
                                    <img src="" alt="Imagem do curso 5">
                                </div>
                                <p>Descrição do curso 5</p>
                            </li>
                            
                        </ul>

                        <div>
                            <button type="submit">Executar exclusões</button>
                        </div>
                        
                        <!-- <p>Você deve selecionar um curso se deseja excluir </p>-->

                    </form>

                </div>

            </div>

            <a href="novoCurso.php" class="inlineBlock botaoRoxo"><p>Cadastrar novo curso</p></a>

        </div>

    </div>

</body>

</html>