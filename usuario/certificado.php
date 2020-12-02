<?php 


    $nomeCurso = "Curso legal";

    if ( isset($_POST['nomeCurso']) && !empty($_POST['nomeCurso']) ) {
        $nomeCurso = $_POST['nomeCurso'];
    }

    $image = imagecreatefrompng("../img/certificado.png");
    
    $cor = imagecolorallocate($image, 109, 48, 29);
    $fontNomeUsuario = realpath('../css/Rochester-Regular.otf');
    $fontNomeCurso = realpath('../css/Roboto-Regular.ttf');


    imagefttext($image, 48, 0, 400, 380, $cor, $fontNomeUsuario, $_COOKIE["NOME_USUARIO_ATUAL"]);
    imagettftext($image, 16, 0, 270, 228, $cor, $fontNomeCurso, $nomeCurso);
    
    header("Content-Type: image/png");
    imagepng($image);


?>