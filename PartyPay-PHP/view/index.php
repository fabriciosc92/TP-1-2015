<?php 

/**
 * File name: index
 * First UI page to be seen
**/

require_once 'header.php'; 

?>
<div id="hero" class="">
    <ul>
        <li><img src="view/img/slide.jpg" alt="" /></li>
    </ul>
    <div class="busca">
        <h1>O que tem de bom pra hoje?</h1>
        <h2>Encontre eventos</h2>
        <div class="navbar">
            <div class="navbar-inner">
                <form class="navbar-form pull-left">
                    <input type="text" class="span10">
                    <button type="submit" class="btn btn-success">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<section class="container">
    <h3>Eventos em destaque</h3>
    <div class="row">
        <div class="span12">

            <ul class="thumbnails">
                <?php
				
				$num = lastEvent();

				for ($i = 0; $i < 6; $i++) {
					
				?>

                    <li class="span4">
                        <div class="thumbnail">
                            <a href="event.php?id=<?php echo (lastEvent() - $i); ?>">
                                <img src="<?php event_image($num - $i); ?>" alt="">
                            </a>
                            <div class="caption">
                                <h3>
                                    <a href="event.php?id=<?php echo (lastEvent() - $i); ?>">
                                        <?php event_name($num - $i); ?>
                                    </a>
                                </h3>
                                <p><?php event_description($num - $i); ?></p>
                                <p>
                                    <a href="event.php?id=<?php echo (lastEvent() - $i); ?>" class="btn">Ver</a>
                                    <a href="#" class="btn btn-success">Comprar ingresso</a>
                                </p>
                            </div>
                        </div>
                    </li>
                <?php
				
				}
				
				?>
            </ul>
        </div>

    </div>
</section>
<footer>
</footer>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="view/js/bootstrap.min.js"></script>
<script src="view/js/bootstrap-responsive.min.js"></script>
</body>
</html>
