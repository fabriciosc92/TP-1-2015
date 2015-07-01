<?php

/**
* 
* Class to generate confirmation code
*
**/


/** 
* Function that generates a code for confirmation
* @return code
*/
function generateCodConfirmation() 
{
    $seed = rand(10, 1000); // Variable that receives a random number
    $code = md5($seed . time()); // Variable that creates a code according to the seed number
    return($code);
}
 
