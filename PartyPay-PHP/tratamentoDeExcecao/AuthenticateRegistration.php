<?php
//$coverage = new PHP_CodeCoverage;
//$coverage->start('AuthenticateRegistrationTEST.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
**/
/**
 * Class: AuthenticateRegistration
 * Description: Class that validate registrations fields.
 *
 * @author Fagner-note
**/

require_once '../model/DAC/UserDAC.php'
    or log_it("Could not include UserDAC file");

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
        $this->errorMessage[7] = "Por favor preencha o campo " . $field . " <br />";
        // Year informed is below to the current year.
        $this->errorMessage[8] = "Ano informado e inferior ao ano corrente <br />";
        
        // Notify that the email already exists.
        $this->errorMessage[10] = "E-mail já existe, cadastre outro e-mail <br />";
        // Notify user that minute is in the wrong format.
        $this->errorMessage[11] = "Minuto em formato inválido <br />";
        // Notify the user to input a valid price.
        $this->errorMessage[12] = "Informe um preço válido <br />";
        // Notify the user to input a valid vacancy.
        $this->errorMessage[13] = "Informe um número de vagas válido <br />";

        return $this->errorMessage[$number];
    }

    // Authenticate Email
    function authenticateEmail($email) 
    {
        if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', 
            $email)) 
        {
            
            echo("<script>console.log('PHP: ".$email."');</script>");
            echo $this->messages(0, 'email', null, null);
            return $this->messages(0, 'email', null, null);
            exit();
        } 
        elseif (UserDAC::verifiqueDispo($email) == 0) 
        {
                
                echo $this->messages(10, 'email', null, null);
                exit();
        }
    }

    // Authenticate CEP (xxxxx-xxx)
    function authenticateCep($cep) 
    {
        if (!preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $cep)) 
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
            echo $this->messages(2, 'date', null, null);
            return $this->messages(2, 'date', null, null);
            exit();
        }
        if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $date)) 
        {
            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(2, 'date', null, null);
            return $this->messages(2, 'date', null, null);
            exit();
        }
        $date = explode("/", $date);
        $day = $date[0];
        $month = $date[1];
        $year = $date[2];
        
        // Checks if the year is below the current one. 
        if ($year < 2013) 
        {
            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(8, 'date', null, null);
            return $this->messages(8, 'date', null, null);
            exit();
        }
        $result = checkdate($month, $day, $year);
        if ($result == FALSE) 
        {
            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(2, 'date', null, null);
            return $this->messages(2, 'date', null, null);
            exit();
        }
    }

    // Authenticate hour (23:59)
    function authenticateTime($hour, $minute) 
    {
        if (!is_numeric($hour)) 
        {
            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(3, 'hour', null, null);
            exit();
        }
        if (!is_numeric($minute)) 
        {
            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(11, 'hour', null, null);
            exit();
        }
        if (!preg_match('/^[0-23]{2,2}?$/', $hour)) 
        {
            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(3, 'hour', null, null);
            exit();
        }
        if (!preg_match('/^[0-59]{2,2}?$/', $minute)) {

            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(11, 'hour', null, null);
            exit();
        }
    }

    function authenticatePrice($price) 
    {
        if (!is_numeric($price)) 
        {
            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(12, 'hour', null, null);
            return $this->messages(12, 'hour', null, null); 
            exit();
        } 
        elseif ($price < 0) 
        {
            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(12, 'hour', null, null);
            return $this->messages(12, 'hour', null, null);
            exit();
        }
    }

    // Authenticate hour (23:59)
    function authenticateVacancy($vacancy) 
    {
        if (!is_numeric($vacancy)) 
        {
            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(13, 'hour', null, null);
            return $this->messages(13, 'hour', null, null);
            exit();
        } 
        elseif ($vacancy < 0) 
        {
            //header("refresh:5;url=../cadastrarEvento.php");
            echo $this->messages(13, 'hour', null, null);
            return $this->messages(13, 'hour', null, null);
            exit();
        }
    }

    // Authenticate Phone number (61-32363810)
    function authenticatePhone($phone) 
    {
        if (!preg_match('^\(+[0-9]{2,3}\) [0-9]{4}-[0-9]{4}$^', $phone)) 
        {
            echo $this->messages(4, 'phone', null, null);
            exit();
        }
    }

    const CPF_SIZE = 11;

    // Authenticate CPF (99999999999)
    function authenticateCpf($cpf)
    {
        $cpf         = preg_replace("/[^0-9]/", "", $cpf);
        $firstDigit     = 0;
        $secondDigit = 0;
        
        // Calculate first digit.
        for($i = 0, $x = 10; $i <= 8; $i = $i + 1, $x = $x - 1)
        {
            $firstDigit = $firstDigit + $cpf[$i] * $x;
        }
        // Calculate second digit.
        for($i = 0, $x = 11; $i <= 9; $i = $i + 1, $x = $x - 1)
        {
            if (str_repeat($i, 11) == $cpf)
            {
                echo $this->messages(5, 'cpf', null, null);
                exit();
            }
            $secondDigit = $secondDigit + $cpf[$i] * $x;
        }
         
        if (($firstDigit%CPF_SIZE) < 2)
        {
            $firstCalculation = 0;
        }
        else
        {
            $firstCalculation = CPF_SIZE-($firstDigit%CPF_SIZE);
        }
        if (($secondDigit%CPF_SIZE) < 2)
        {
            $secondCalculation = 0;
        }
        else
        {
            $secondCalculation = CPF_SIZE-($secondDigit%CPF_SIZE);
        }
        if ($firstCalculation <> $cpf[9] || $secondCalculation <> $cpf[10])
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

    const EMPTY_FIELD = " ";

    // Simple verification (empty field, max/min numbers of caracters).
    function authenticateField($field, $value) 
    {
        
        if ($value == EMPTY_FIELD) 
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

//$coverage->stop();
//$writer = new PHP_CodeCoverage_Report_Clover;
//$writer->process($coverage, '/tmp/clover.xml');
