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

                <h2>Cursos disponíveis</h2>

                <!-- <p>Ainda não possui nenhum curso cadastrado. Entre em contato com algum administrador</p>-->

                <div>

                    <form action="homeUsuario.php" method="post">
                        <ul>
    
                            <li>
                                <input type="checkbox" name="curso" value="curso1"/>
                                <h3>Título do curso 1</h3>
                                <div>
                                    <img src="" alt="Imagem do curso 1">
                                </div>
                                <p>Descrição do curso 1</p>
                            </li>
                            <li>
                                <input type="checkbox" name="curso" value="curso2"/>
                                <h3>Título do curso 2</h3>
                                <div>
                                    <img src="" alt="Imagem do curso 2">
                                </div>
                                <p>Descrição do curso 2</p>
                            </li>
                            <li>
                                <input type="checkbox" name="curso" value="curso3"/>
                                <h3>Título do curso 3</h3>
                                <div>
                                    <img src="" alt="Imagem do curso 3">
                                </div>
                                <p>Descrição do curso 3</p>
                            </li>
                            <li>
                                <input type="checkbox" name="curso" value="curso4"/>
                                <h3>Título do curso 4</h3>
                                <div>
                                    <img src="" alt="Imagem do curso 4">
                                </div>
                                <p>Descrição do curso 4</p>
                            </li>
                            <li>
                                <input type="checkbox" name="curso" value="curso5"/>
                                <h3>Título do curso 5</h3>
                                <div>
                                    <img src="" alt="Imagem do curso 5">
                                </div>
                                <p>Descrição do curso 5</p>
                            </li>
                            
                        </ul>

                        <div>
                            <button type="submit">Fazer esse curso</button>
                        </div>
                        
                        <!-- <p>Você deve selecionar um curso para fazer</p>-->

                    </form>

                </div>

                <h2>Cursos matriculado</h2>

                <!-- <p>Você ainda não esta matriculado em nenhum curso</p>-->
                
                <div>

                    <ul>
        
                        <li>
                            <h3>Título do curso 1</h3>
                            <div>
                                <img src="" alt="Imagem do curso 1">
                            </div>

                            <form action="certificado.php" method="post" target="_blank">
                                <input type="radio" name="concluir" value="curso1" required /> Concluir
                                <div>
                                    <button type="submit">Gerar certificado</button>
                                </div>
                            </form>

                        </li>
                        <li>
                            <h3>Título do curso 2</h3>
                            <div>
                                <img src="" alt="Imagem do curso 2">
                            </div>

                            <form action="certificado.php" method="post" target="_blank">
                                <input type="radio" name="concluir" value="curso1" required /> Concluir
                                <div>
                                    <button type="submit">Gerar certificado</button>
                                </div>
                            </form>

                        </li>
                        <li>
                            <h3>Título do curso 3</h3>
                            <div>
                                <img src="" alt="Imagem do curso 3">
                            </div>

                            <form action="certificado.php" method="post" target="_blank">
                                <input type="radio" name="concluir" value="curso1" required /> Concluir
                                <div>
                                    <button type="submit">Gerar certificado</button>
                                </div>
                            </form>
                            
                        </li>
        
                    </ul>

                </div>

            </div>

            </div>

        </div>

    </div>

</body>

</html>