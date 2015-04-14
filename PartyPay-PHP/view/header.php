<?php

/**
 * File name: header
 * Page responsible to be the header of all view pages
 */

include 'model/Person.php';
include 'controller/functions.php';


session_start();

if (isset($_SESSION['id'])) {

    $firstName = $_SESSION['firstName'];
    $phoneNumber = $_SESSION['phoneNumber'];
    $surName = $_SESSION['surName'];
    $email = $_SESSION['email'];
    $gender = $_SESSION['gender'];
    $idNumber = $_SESSION['idNumber'];
	
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Party Pay</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="view/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="view/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="view/css/style.css" rel="stylesheet" media="screen">
    </head>
    <body>
        <header>
            <div class="navbar">
                <div class="navbar-inner">
                    <a class="brand" href="index.php"><img src="view/img/marca-mini.png" alt="" /></a>
                    <ul class="nav">
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="#">Sobre</a></li>
                        <?php 
						if (!isset($_SESSION['id'])) {
						?>
                            <li><a href="#myModal" data-toggle="modal">Entrar</a></li>
                            <li><a href="#cadastrar" data-toggle="modal">Sign up</a></li>
                        <?php 
						} else {
							//Nothing to do
						}
                        ?>
                    </ul>
                    <a class="btn btn-success pull-right" href="cadastrarEvento.php">Divulgar seu evento</a>
						<?php 
						if (isset($_SESSION['id'])) {
						?>
							<div id="usuario" class="btn-group pull-right">
								<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
									<?php 
									echo "$firstName $surName"; 
									?>
									</button>
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<li><a href="editPerson.php">Editar cadastro</a></li>
									<li><a href="logout.php">Sair</a></li>
								</ul>
							</div>
						<?php 
						} else {
							//Nothing to do
						}
						?>
                </div>
                <!-- Modal Login-->
                <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">x</button>
                        <h3>Login</h3>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="controller/doLogin.php" name="login_form">
                            <p><input type="email" class="span3" name="email" id="email" placeholder="Email" required></p>
                            <p><input type="password" class="span3" name="password" placeholder="password" required></p>
                            <p><button type="submit" class="btn btn-primary">Entrar</button>
                                <a href="#recuperarSenha" data-toggle="modal" onclick="$('#myModal').modal('hide')">Esqueci a senha</a>
                            </p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        N&atilde;o tem conta?
                        <a href="cadastrarPessoa.php" class="btn btn-primary">Registrar</a>
                    </div>
                </div>
                <!-- Modal Recuperar-->
                <div id="recuperarSenha" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">x</button>
                        <h3>Login</h3>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="controller/SendEmailReset.php" name="login_form">
                            <p>Email de recupera&ccedil;&atilde;o</p>
                            <p><input type="text" class="span3" name="email" id="email" placeholder="Email" required></p>
                            <p><button type="submit" class="btn btn-primary">Enviar</button>
                            </p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        J&aacute; tem conta? 
                        <a href="signUp.php" class="btn btn-primary">Registrar</a>
                    </div>
                </div>
                <!-- Modal Cadastrar-->
                <div id="cadastrar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">x</button>
                        <h3>Novo Usu&aacute;rio</h3>
                    </div>
                    <section class="container">
                        <div class="row">
                            <form class="form-horizontal" method="post" action="controller/doSignUp.php" enctype="multipart/form-data">
                                <div class="control-group">
                                    <label class="control-label" for="nome">Primeiro Nome</label>
                                    <div class="controls">
                                        <input type="text" name="firstName" placeholder="Primeiro nome" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="nome">Sobrenome</label>
                                    <div class="controls">
                                        <input type="text" name="surName" placeholder="Sobrenome" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="nome">email</label>
                                    <div class="controls">
                                        <input type="email" name="email" placeholder="email" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="nome">Senha</label>
                                    <div class="controls">
                                        <input type="password" name="password" placeholder="senha" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="nome">Sexo</label>
                                    <div class="controls">
                                        <select name="gender">
                                            <option>Feminino</option>
                                            <option>Masculino</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- cod confirmação -->

                                <div class="control-group">
                                    <label class="control-label" for="nome">CPF</label>
                                    <div class="controls">
                                        <input type="text" id="cpf" name="idNumber" placeholder="CPF" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="nome">Telefone de Contato</label>
                                    <div class="controls">
                                        <input type="text" id="telefone" name="phoneNumber" placeholder="Telefone de Contato" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-success">Enviar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </header>