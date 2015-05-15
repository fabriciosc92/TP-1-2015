<?php

//$coverage = new PHP_CodeCoverage;
//$coverage->start('AuthenticateRegistrationTEST.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Class: AuthenticateRegistration
 * Description: Class that validate registrations fields.
 *
 * @author Fagner-note
 */

require_once '../model/DAC/UserDAC.php';

class AuthenticateRegistration 
{

    var $field;
    var $value;
    var $errorMessage = array();

    // Defines error messages. 
    public function messages($number, $field) 
    {

        // Notify the user when the email is invalid.
        $this->errorMessage[0] = "Preencha o campo com um email válido <br />"; 

        // Notify the user when cep is in the wrong format.
        $this->errorMessage[1] = "CEP com formato inválido (Ex: XXXXX-XXX) <br />";

        // Notify the user when date is in the wrong format. 
        $this->errorMessage[2] = "Data em formato inválido, informe data como (Ex: DD/MM/AAAA) <br />";
        
        // Notify the user when hour is in the wrong format.
        $this->errorMessage[3] = "Hora em formato inválido <br />";

        // Notify the user when phone number is invalid.
        $this->errorMessage[4] = "Telefone inválido (Ex: 61-33333333) <br />";

        // Notify the user when CPF is invalid.
        $this->errorMessage[5] = "CPF inválido (Ex: 11111111111) <br />"; 

        // Shows this fields has only numbers.
        $this->errorMessage[6] = "Preencha o campo " . $field . " com numeros <br />";

        // Notify that the field is empty.
        $this->errorMessage[7] = "Por favor Preencha o campo " . $field . " <br />";

        // Year informed is below to the current year.
        $this->errorMessage[8] = "Ano informado e inferior ao ano corrente <br />";
        
        // Notify that the email already exists.
        $this->errorMessage[10] = "E-mail já existe, cadastre outro e-mail <br />";

        // Notify user that minute is in the wrong format.
        $this->errorMessage[11] = "Minuto em formato inválido <br />";

        // Notify the user to input a valid price.
        $this->errorMessage[12] = "Informe um preço válido <br />";

        // Notify the user to input a valid vacancy.
        $this->errorMessage[13] = "Informe um número de vagas válida <br />";

        return $this->errorMessage[$number];
    }

    // Authenticate Email
    function authenticateEmail($email) 
    {
        if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', 
            $email)) 
        {
            
            echo $this->messages(0, 'email', null, null);

            return $this->messages(0, 'email', null, null);
            exit();

        } 
        elseif (PessoaDAC::verifiqueDispo($email) == 0) 
        {
                
                echo $this->messages(10, 'email', null, null);
                exit();
        }
    }

    // Authenticate CEP (xxxxx-xxx)
    function authenticateCep($cep) 
    {
        if(!preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $cep)) 
        {
            echo $this->messages(1, 'cep', null, null);
            exit();
        }
    }

    // Authenticate Date (DD/MM/AAAA)
    function authenticateDate($date) 
    {        
        if (!isset($date) || $date == "") 
        {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(2, 'data', null, null);

            return $this->messages(2, 'data', null, null);
            exit();
        }

        if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $date)) 
        {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(2, 'data', null, null);

            return $this->messages(2, 'data', null, null);
            exit();
        }

        $data = explode("/", $date);
        $d = $data[0];
        $m = $data[1];
        $y = $data[2];
        
        if ($y < 2013) 
        {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(8, 'data', null, null);

            return $this->messages(8, 'data', null, null);
            exit();
        }

        $result = checkdate($m, $d, $y);
        if ($result == FALSE) 
        {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(2, 'data', null, null);
            return $this->messages(2, 'data', null, null);
            exit();
        }
    }

    // Authenticate HORA (23:59)
    function authenticateTime($hora, $minuto) 
    {
        if (!is_numeric($hora)) 
        {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(3, 'hora', null, null);
            exit();
        }
        if (!is_numeric($minuto)) 
        {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(11, 'hora', null, null);
            exit();
        }
        if (!preg_match('/^[0-23]{2,2}?$/', $hora)) 
        {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(3, 'hora', null, null);
            exit();
        }
        if (!preg_match('/^[0-59]{2,2}?$/', $minuto)) {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(11, 'hora', null, null);
            exit();
        }
    }

    function authenticatePrice($preco) 
    {
        if (!is_numeric($preco)) 
        {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(12, 'hora', null, null);

            return $this->messages(12, 'hora', null, null);
            exit();
        } 
        elseif ($preco < 0) 
        {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(12, 'hora', null, null);

            return $this->messages(12, 'hora', null, null);
            exit();
        }
    }

    // Authenticate HORA (23:59)
    function authenticateVacancy($vaga) 
    {
        if (!is_numeric($vaga)) 
        {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(13, 'hora', null, null);

            return $this->messages(13, 'hora', null, null);
            exit();

        } 
        elseif ($vaga < 0) 
        {
            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(13, 'hora', null, null);

            return $this->messages(13, 'hora', null, null);
            exit();
        }
    }

    // Authenticate Phone number (61-32363810)
    function authenticatePhone($telefone) 
    {
        if (!preg_match('^\(+[0-9]{2,3}\) [0-9]{4}-[0-9]{4}$^', $telefone)) 
        {
            echo $this->messages(4, 'telefone', null, null);
            exit();
        }
    }

    // Authenticate CPF (99999999999)
    function authenticateCpf($cpf)
    {
        $cpf         = preg_replace("/[^0-9]/", "", $cpf);
        $digitoUm     = 0;
        $digitoDois = 0;
         
        for($i = 0, $x = 10; $i <= 8; $i++, $x--)
        {
            $digitoUm += $cpf[$i] * $x;
        }
        for($i = 0, $x = 11; $i <= 9; $i++, $x--)
        {
            if(str_repeat($i, 11) == $cpf)
            {
                echo $this->messages(5, 'cpf', null, null);
                exit();
            }
            $digitoDois += $cpf[$i] * $x;
        }
         
        $calculoUm  = (($digitoUm%11) < 2) ? 0 : 11-($digitoUm%11);
        $calculoDois = (($digitoDois%11) < 2) ? 0 : 11-($digitoDois%11);

        if($calculoUm <> $cpf[9] || $calculoDois <> $cpf[10])
        {
            echo $this->messages(5, 'cpf', null, null);
            exit();
        }
    }
    
// Authenticate fields with numbers.
    function authenticateNumber($field, $number) 
    {
        if (!is_numeric($number)) 
        {
            return $this->messages(6, $field, null, null);
        }
    }

    // Simple verification (empty field, max/min numbers of caracters).
    function authenticateField($field, $value) 
    {
        
        if ($value == "") 
        {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(7, $field);
            exit();
        }
    }

// Verify if there are errors.
    function verifyErrors() 
    {
        if (sizeof($this->errorMessage) == 0) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }
}

//$coverage->stop();

//$writer = new PHP_CodeCoverage_Report_Clover;
//$writer->process($coverage, '/tmp/clover.xml');

