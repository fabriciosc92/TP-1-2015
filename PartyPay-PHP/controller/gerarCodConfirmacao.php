<?php
// Class to generate confirmation code

// Function that generates a code for confirmation
function gerarCodigoConfirmaçao() 
{
    $seed = rand(10, 1000);
    $code = md5($seed . time());
    return($code);
}

?>
