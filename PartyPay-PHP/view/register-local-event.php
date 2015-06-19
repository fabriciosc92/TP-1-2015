<?php

/**
 * File name: register-local-event
 * Shows the local event registering form
**/
 
require_once ('header.php'); 

?>
<section class="container">
    <h3>Local</h3>
    <div class="row">
        <form class="form-horizontal" method="post" action="controller/doLocalRegister.php" enctype="multipart/form-data">
            <div class="control-group">
                <label class="control-label" for="nome">Nome</label>
                <div class="controls">
                    <input type="text" name="name" placeholder="Nome do Local" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="fotos">Fotos</label>
                <div class="controls">
                    <input type="file" name="file" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="endereco">Endere&ccedil;o</label>
                <div class="controls">
                    <input type="text" name="address" placeholder="Endere&ccedil;o" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="numero">Numero</label>
                <div class="controls">
                    <input type="text" id="numero" name="number" placeholder="Numero" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="numero">Complemento</label>
                <div class="controls">
                    <input type="text" name="complement" placeholder="Complemento" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="numero">Bairro</label>
                <div class="controls">
                    <input type="text" name="neighborhood" placeholder="Bairro" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="numero">Cidade</label>
                <div class="controls">
                    <input type="text" name="city" placeholder="Cidade" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="numero">CEP</label>
                <div class="controls">
                    <input type="text" id="cep" name="zip" placeholder="CEP" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="numero">Pa&iacute;s</label>
                <div class="controls">
                    <input type="text" name="country" placeholder="Pa&iacute;s" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="numero">Estado</label>
                <div class="controls">
                    <input type="text" name="state" placeholder="Estado" required>
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
<?php

require_once ('footer.php');

?>