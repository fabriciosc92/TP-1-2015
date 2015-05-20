<?php
// Class responsible for uploading the local image

require 'canvas.php';
    or log_it("Could not include canvas.php file");

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '../view/images/';

// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
// Array com as extensões permitidas
$_UP['extensoes'] = array('jpg', 'png', 'gif');

// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = true;

// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';

$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';

$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';

$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';

$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivo']['error'] != 0) {

    log_it("Error on upload: "$_UP['erros'][$_FILES['arquivo']['error']]);

    die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);

    exit; // Para a execução do script
}

// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
// Faz a verificação da extensão do arquivo
$var = explode('.', $_FILES['arquivo']['name']);
$extension = strtolower(end($var));

if (array_search($extension, $_UP['extensoes']) === false) {
    
    log_it("Error on image upload: invalid file extension");

    echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
}

// Faz a verificação do tamanho do arquivo
else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {

    log_it("Error on image upload: invalid file fize");

    echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
}

// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
else {
// Primeiro verifica se deve trocar o nome do arquivo
    if ($_UP['renomeia'] == true) {
// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
        $nome_final = time() . '.jpg';
    } else {
// Mantém o nome original do arquivo
        $nome_final = $_FILES['arquivo']['name'];
    }

// Depois verifica se é possível mover o arquivo para a pasta escolhida
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
        $local->setFotos($_UP['pasta'] . $nome_final);
        $thumb = new canvas($local->getFotos());
        $width = 80;
        $heigth = 80;
        $thumb->redimensiona($width, $heigth, 'proporcional');
        $thumb->grava($_UP['pasta'] . "thumb" . $nome_final, 100);
        $local->setMiniatura($_UP['pasta'] . "thumb" . $nome_final);
    } else {
// Não foi possível fazer o upload, provavelmente a pasta está incorreta

        log_it("Error on image upload: unable to move uploaded file");

        echo "Não foi possível enviar o arquivo, tente novamente";
    }
}
?>
