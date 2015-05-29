<?php
// Class responsible for uploading the event image

require 'canvas.php'
	or log_it("Could not include canvas.php file");
const NO_ERROR = 0;
const MAX_FILE_SIZE = 2;
const MAX_FILE_SIZE_TYPE = "MB";
const FILE_SIZE_MULTIPLYER = 2; // KB = 1, MB = 2, GB = 3
const INVALID_EXTENSION = false;
const THUMBNAIL_WIDTH = 80;
const THUMBNAIL_HEIGTH = 80;
const THUMBNAIL_QUALITY = 100; // 1 to 100


require 'canvas.php';
// Pasta onde o arquivo vai ser salvo

$_UP['pasta'] = 'view/images/';

// Tamanho máximo do arquivo (em Bytes)

$_UP['tamanho'] = (FILE_SIZE_MULTIPLYER * 1024) * MAX_FILE_SIZE; // 2Mb
// Array com as extensões permitidas

echo($_UP['tamanho']);
die();

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

if ($_FILES['arquivo']['error'] != NO_ERROR) {
	
	log_it("Error on image upload: "$_UP['erros'][$_FILES['arquivo']['error']]);

    die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);

    exit; // Para a execução do script
}



// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
// Faz a verificação da extensão do arquivo
$var = explode('.', $_FILES['arquivo']['name']);

$extension = strtolower(end($var));

if (array_search($extension, $_UP['extensoes']) === INVALID_EXTENSION) {
	
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

        $finalName = time() . '.jpg';
    } else {

// Mantém o nome original do arquivo

        $finalName = $_FILES['arquivo']['name'];
    }



// Depois verifica se é possível mover o arquivo para a pasta escolhida

    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $finalName)) {


        $event->setImagem($_UP['pasta'] . $finalName);
        $thumb = new canvas($event->getImagem());

        $thumb->redimensiona(THUMBNAIL_WIDTH, THUMBNAIL_HEIGTH, 'proporcional');
        $thumb->grava($_UP['pasta'] . "thumb" . $finalName, THUMBNAIL_QUALITY);
        $event->setMiniatura($_UP['pasta'] . "thumb" . $finalName);
    } else {

// Não foi possível fazer o upload, provavelmente a pasta está incorreta		
		log_it("Error on image upload: unable to move uploaded file");

        echo "Não foi possível enviar o arquivo, tente novamente";
    }
}
?>
