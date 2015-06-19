<?php 

/**
 * File name: editPerson
 * Shows the user edition form
**/

require_once('header.php'); 

?>
<section class="container">
    <h3>Editar dados</h3>
    <div class="row"><h3><?php echo $_SESSION['id']; ?></h3>
        <form class="form-horizontal" method="post" action="controller/processaEditaPessoa.php" enctype="multipart/form-data">
            <div class="control-group">
                <label class="control-label" for="nome">Primeiro Nome</label>
                <div class="controls">
                    <input type="text" name="firstName" placeholder="Primeiro nome" value="<?php echo $firstName; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="nome">Sobrenome</label>
                <div class="controls">
                    <input type="text" name="surName" placeholder="Sobrenome"  value="<?php echo $surName; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="email">email</label>
                <div class="controls">
                    <span class="input-xlarge uneditable-input"><?php echo $email; ?></span></div>
            </div>
            <div class="control-group">
                <label class="control-label" for="senha">Senha</label>
                <div class="controls">
                    <a href="#">Mudar senha</a>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="sexo">Sexo</label>

                <div class="controls">
                    <select name="gender">
                        <option>Feminino</option>
                        <option>Masculino</option>
                    </select>
                </div>

                <!-- confimartion code -->

                <div class="control-group">
                    <label class="control-label" for="cpf">CPF</label>
                    <div class="controls">
                        <input type="text" id="cpf" name="idNumber" placeholder="CPF" value="<?php echo $idNumber; ?>" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="telefoneContato">Telefone de Contato</label>
                    <div class="controls">
                        <input type="text" id="telefone" name="phoneNumber" placeholder="Telefone de Contato" value="<?php echo $phoneNumber; ?>" required>
                    </div>
                </div>
                <?php $id = 9; // Consult id in Session ?>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </div>
        </form>
    </div>
</section>
<?php

require_once('footer.php'); 
	
?>