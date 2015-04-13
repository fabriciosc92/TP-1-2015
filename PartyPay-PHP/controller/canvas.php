<?php
/**
 *
 * Class for image manipulation using the GD extension and advanced features filters. 
 * Requires PHP 5 or higher.
 *
 **/

class canvas {
	
    /**
     * Variables for storing files/imgs
     **/
    private $origem, $img, $img_temp;

    /**
     * Store the size of the current image and the new image if available
     **/
    private $largura, $altura, $nova_largura, $nova_altura, $tamanho_html;
    
    /**
    * Variables for positioning the crop
    **/
    private $pos_x, $pos_y;
    
    /**
     * Information about the uploaded file and directory
     **/
    private $formato, $extensao, $tamanho, $arquivo, $diretorio;

    /**
     * Array RGB resize with background fill
     **/
    private $rgb;

    /**
     * Coordinates for positioning crop
     **/
    private $posicao_crop;

    /**
     * Constructor
     * @param $string path to image to be loaded [optional]
     * @return void
     **/
     public function __construct( $origem = '' )
     {

          $this->origem = $origem;

          if ( $this->origem )
          {
               $this->dados();
          }

          // RGB default -> white
     $this->rgb( 255, 255, 255 );
     } // end constructor
     
     /**
     * Reset variables in order to use object in long threads
     * @return void
     **/
     public function resetar()
     {
			
		$this->origem = $this->img = $this->img_temp = $this->largura = $this->altura = 
		$this->nova_largura = $this->nova_altura = $this->tamanho_html = $this->pos_x = 
		$this->pos_y = $this->formato = $this->extensao = $this->tamanho = $this->arquivo = 
		$this->diretorio = $this->posicao_crop = NULL;
	
	    	$this->rgb( 255, 255, 255 );
     }// end resetar
     

     /**
      * Return image data
      * @return void
      **/
     private function dados()
     {

          // checks for image
          if ( is_file( $this->origem ) )
          {

               // files data
               $this->dadosArquivo();

               // checks if is an image
               if ( !$this->eImagem() )
               {
                    trigger_error( 'Erro: Arquivo '.$this->origem.' não é uma imagem!', E_USER_ERROR );
               }
               else
               {
                    // search dimensions of the sent image
                    $this->dimensoes();

                    // create image for php
                    $this->criaImagem();
               }
          }
          else
          {
               trigger_error( 'Erro: Arquivo de imagem não encontrado!', E_USER_ERROR );
          }

     } // end dadosImagem

     /**
      * Load a new image outside builder
      * @param String path of the image to load
      * @return Object current instance of the object, for chained method
      **/
     public function carrega( $origem = '' )
     {
          $this->origem = $origem;
          $this->dados();
          return $this;
     } // end carrega

     /**
      * Search dimensions and real image format
      * @return void
      **/
     private function dimensoes()
     {
    $dimensoes                  = getimagesize( $this->origem );
    $this->largura              = $dimensoes[0];
    $this->altura               = $dimensoes[1];
    /**
    * 1 = gif, 2 = jpeg, 3 = png, 6 = BMP
    * http://br2.php.net/manual/en/function.exif-imagetype.php
    **/
    $this->formato               = $dimensoes[2];
    $this->tamanho_html          = $dimensoes[3];
     } // end dimensoes

     /**
      * Search file data
      * @return void
      **/
     private function dadosArquivo()
     {
          // source image
          $pathinfo            = pathinfo( $this->origem );
          $this->extensao = array_key_exists('extension', $pathinfo) ? strtolower($pathinfo['extension']) : strtolower(str_replace('image/', '', $obj['mime']));
          $this->arquivo       = $pathinfo['basename'];
          $this->diretorio     = $pathinfo['dirname'];
     } // end dadosArquivo

     /**
      * Checks if the specified file is an image
      * @return Boolean true/false
      **/
     private function eImagem()
     {
          // filter extension
          $valida = getimagesize( $this->origem );
          if ( !is_array( $valida ) || empty( $valida ) )
          {
               return false;
          }
          else
          {
               return true;
          }
     } // end validaImagem

     /**
      * Create a new image to be worked with texts, etc.
      * Note: the color image must be passed before, via rgb () or hex ()
      * @param String $largura of the image to be created
      * @param String $altura of the image to be created
      * @return Object current instance of the object, for chained method
      **/
     public function novaImagem( $largura, $altura )
     {
          $this->largura     = $largura;
          $this->altura     = $altura;
          $this->img = imagecreatetruecolor( $this->largura, $this->altura );
          $cor_fundo = imagecolorallocate( $this->img, $this->rgb[0], $this->rgb[1], $this->rgb[2] );
          imagefill( $this->img, 0, 0, $cor_fundo );
          $this->extensao = 'jpg';
          return $this;
    } // end novaImagem

    /**
     * Upload an image via URL
     * Note: depends on the server settings for remote access files
     * @param String $url image path
      * @return Object current instance of the object, for chained method
     **/
     public function carregaUrl( $url )
     {
          $this->origem = $url;
          $pathinfo = pathinfo( $this->origem );
          $this->extensao = strtolower( $pathinfo['extension'] );
          switch( $this->extensao )
          {
               case 'jpg':
               case 'jpeg':
                    $this->formato = 2;
                    break;
               case 'gif':
                    $this->formato = 1;
                    break;
               case 'png':
                    $this->formato = 3;
                    break;
               case 'bmp':
                    $this->formato = 6;
                    break;
               default:
                    break;
     }
          $this->criaImagem();
     $this->largura     = imagesx( $this->img );
          $this->altura     = imagesy( $this->img );
          return $this;
     } // end carregaUrl

     /**
      * Create image object for manipulation in GD
      * @return void
      **/
     private function criaImagem()
     {
          switch ( $this->formato )
          {
               case 1:
                    $this->img = imagecreatefromgif( $this->origem );
                    $this->extensao = 'gif';
                    break;
               case 2:
                    $this->img = imagecreatefromjpeg( $this->origem );
                    $this->extensao = 'jpg';
                    break;
               case 3:
                    $this->img = imagecreatefrompng( $this->origem );
                    $this->extensao = 'png';
                    break;
               case 6:
                    $this->img = imagecreatefrombmp( $this->origem );
                    $this->extensao = 'bmp';
                    break;
               default:
                    trigger_error( 'Arquivo inválido!', E_USER_ERROR );
                    break;
          }
     } // end criaImagem

     /**
      * Stores the RGB values for resizing to fill
      * @param Values R, G e B
      * @return Object current instance of the object, for chained method
      **/
     public function rgb( $r, $g, $b )
     {
          $this->rgb = array( $r, $g, $b );
          return $this;
     } // end rgb

     /**
      * Convert hexadecimal for RGB
      * @param String $cor cor hexadecimal
      * @return Object current instance of the object, for chained method
      **/
     public function hexa( $cor )
     {
          $cor = str_replace( '#', '', $cor );

          if( strlen( $cor ) == 3 ) $cor .= $cor; // #fff, #000 etc.

          $this->rgb = array(
            hexdec( substr( $cor, 0, 2 ) ),
            hexdec( substr( $cor, 2, 2 ) ),
            hexdec( substr( $cor, 4, 2 ) ),
          );
          return $this;
     }  // end hexa

     /**
      * Stores positions x and y for crop
      * @param Int x - position x of crop
			* @param Int y - position y of crop
			* @param Int w - width  - larguraOrigem (by OctaAugusto)
			* @param Int h - height - alturaOrigem (by OctaAugusto)
      * @return Object current instance of the object, for chained method
      **/
     public function posicaoCrop( $x, $y, $w=0, $h=0 )
     {
          // no width or manually sitting height, image original handle
		  		if(!$w) $w = $this->largura;
		  		if(!$h) $h = $this->altura;
		  
          $this->posicao_crop = array( $x, $y, $w, $h );

          return $this;
     } // end posicao_crop

     /**
      * Resize image
      * @param Int $nova_largura value in pixels of the new image largura
      * @param Int $nova_altura value in pixels of the new image altura
      * @param String $tipo method for scaling (default [empty], fill or crop)
      * @return Object current instance of the object, for chained method
      **/
     public function redimensiona( $nova_largura = 0, $nova_altura = 0, $tipo = '' )
     {

          // to set variables passed via parameter
          $this->nova_largura         = $nova_largura;
          $this->nova_altura          = $nova_altura;

          // checks went height or width in percent
          // largura %
          $pos = strpos( $this->nova_largura, '%' );
          if( $pos !== false && $pos > 0 )
          {
               $porcentagem               = ( ( int ) str_replace( '%', '', $this->nova_largura ) ) / 100;
               $this->nova_largura          = round( $this->largura * $porcentagem );
          }
          // altura %
          $pos = strpos( $this->nova_altura, '%' );
          if( $pos !== false && $pos > 0 )
          {
               $porcentagem               = ( ( int ) str_replace( '%', '', $this->nova_altura ) ) / 100;
               $this->nova_altura          = $this->altura * $porcentagem;
          }

          // sets whether just passed new width or height
          if ( !$this->nova_largura && !$this->nova_altura )
          {
               return false;
          }
          // just pass altura
          elseif ( !$this->nova_largura )
          {
               $this->nova_largura = $this->largura / ( $this->altura/$this->nova_altura );
          }
          // just pass largura
          elseif ( !$this->nova_altura )
          {
               $this->nova_altura = $this->altura / ( $this->largura/$this->nova_largura );
          }

          // resize according if type
          switch( $tipo )
          {
               case 'crop':
                    $this->redimensionaCrop();
                    break;
               case 'preenchimento':
                    $this->redimensionaPreenchimento();
                    break;
               case 'proporcional': 
                   // proportionally unfilled
                    $this->redimensionaProporcional();
                    break;		
               default:
                    $this->redimensionaSimples();
                    break;
          }

          // update image dimensions
          $this->altura     = $this->nova_altura;
          $this->largura     = $this->nova_largura;

          return $this;
     } // end redimensiona

     /**
      * Resize image, standard mode without crop or fill
      * (distorting case has passed both height and width)
      * @return void
      **/
     private function redimensionaSimples()
     {
          // create temporary destination image
          $this->img_temp = imagecreatetruecolor( $this->nova_largura, $this->nova_altura );

          imagecopyresampled( $this->img_temp, $this->img, 0, 0, 0, 0, $this->nova_largura, $this->nova_altura, $this->largura, $this->altura );
          $this->img     = $this->img_temp;
     } // end redimensiona()

     /**
      * Add image to the background color
      * @return void
      **/
     private function preencheImagem()
     {
          $cor_fundo = imagecolorallocate( $this->img_temp, $this->rgb[0], $this->rgb[1], $this->rgb[2] );
          imagefill( $this->img_temp, 0, 0, $cor_fundo );
     } // end preencheImagem

     /**
      * Redimensiona imagem sem cropar, proporcionalmente,
      * preenchendo espaço vazio com cor rgb especificada
      * @return void
      **/
     private function redimensionaPreenchimento()
     {
          // cria imagem de destino temporária
          $this->img_temp = imagecreatetruecolor( $this->nova_largura, $this->nova_altura );

          // adiciona cor de fundo à nova imagem
          $this->preencheImagem();

          // salva variáveis para centralização
          $dif_x = $dif_w = $this->nova_largura;
          $dif_y = $dif_h = $this->nova_altura;

          /**
      		 * Verifica altura e largura
      		 * Calculo corrigido por Gilton Guma <http://www.gsguma.com.br/>
      		 */
          if ( ($this->largura / $this->nova_largura ) > ( $this->altura / $this->nova_altura ) )
          {
              $fator = $this->largura / $this->nova_largura;
          } else {
              $fator = $this->altura / $this->nova_altura;
          }
          $dif_w = $this->largura / $fator;
          $dif_h = $this->altura  / $fator;

          // copia com o novo tamanho, centralizando
          $dif_x = ( $dif_x - $dif_w ) / 2;
          $dif_y = ( $dif_y - $dif_h ) / 2;
          imagecopyresampled( $this->img_temp, $this->img, $dif_x, $dif_y, 0, 0, $dif_w, $dif_h, $this->largura, $this->altura );
          $this->img     = $this->img_temp;
     } // fim redimensionaPreenchimento()

     /**
      * Redimensiona imagem sem cropar, proporcionalmente e sem preenchimento.
      * Modo proporcional adicionado por Fernando VR ( http://goo.gl/iDtmP )
      * @return void
      **/
     private function redimensionaProporcional()
     {
	   /**
           * Verifica altura e largura proporcional.
           **/
		   $ratio_orig = $this->largura/$this->altura;

			if ($this->nova_largura/$this->nova_altura > $ratio_orig) {
			   $dif_w = $this->nova_altura*$ratio_orig;
			   $dif_h = $this->nova_altura;
			} else {
				$dif_w = $this->nova_largura;
			   $dif_h = $this->nova_largura/$ratio_orig;
			}

          // cria imagem de destino temporária
          $this->img_temp = imagecreatetruecolor( $dif_w, $dif_h );
		 
          // Resample
	  imagecopyresampled($this->img_temp, $this->img, 0, 0, 0, 0, $dif_w, $dif_h, $this->largura, $this->altura);
          $this->img   = $this->img_temp;
     } // fim redimensionaProporcional()


     /**
      * Calcula a posição do crop
      * Os índices 0 e 1 correspondem à posição x e y do crop na imagem
      * Os índices 2 e 3 correspondem ao tamanho do crop
      * @return void
      **/
     private function calculaPosicaoCrop()
     {
          // média altura/largura
          $hm     = $this->altura / $this->nova_altura;
          $wm     = $this->largura / $this->nova_largura;

          // 50% para cálculo do crop
          $h_height = $this->nova_altura / 2;
          $h_width  = $this->nova_largura / 2;

          // calcula novas largura e altura
          if( !is_array( $this->posicao_crop ) )
          {
               if ( $wm > $hm )
               {
                    $this->posicao_crop[2]     = $this->largura / $hm;
                    $this->posicao_crop[3]     = $this->nova_altura;
                    $this->posicao_crop[0]     = ( $this->posicao_crop[2] / 2 ) - $h_width;
                    $this->posicao_crop[1]     = 0;
               }
               // largura <= altura
               elseif ( ( $wm <= $hm ) )
               {
                    $this->posicao_crop[2]     = $this->nova_largura;
                    $this->posicao_crop[3]     = $this->altura / $wm;
                    $this->posicao_crop[0]     = 0;
                    $this->posicao_crop[1]     = ( $this->posicao_crop[3] / 2 ) - $h_height;
               }
          }
     } // fim calculaPosicaoCrop

     /**
      * Redimensiona imagem, cropando para encaixar no novo tamanho, sem sobras
      * baseado no script original de Noah Winecoff
      * http://www.findmotive.com/2006/12/13/php-crop-image/
      * atualizado para receber o posicionamento X e Y e/ou Coordenadas Inteligentes
      * do crop na imagem.
      * Coordenadas Inteligentes implementado por Aires Gonçalves <contato@airesgoncalves.com.br>
      * @return void
      **/
     private function redimensionaCrop()
     {
          // calcula posicionamento do crop automaticamente
          if(!is_array($this->posicao_crop))
          {
          	$auto=1; 
          	$this->calculaPosicaoCrop(); 
		  		}
		  		// posicionamento do crop setado manualmente
		  		else {
		  			$auto = 0;
		  		}

          // cria imagem de destino temporária
          $this->img_temp = imagecreatetruecolor( $this->nova_largura, $this->nova_altura );

          // adiciona cor de fundo à nova imagem
          $this->preencheImagem();
          
          //coordenadas inteligentes
          switch( $this->posicao_crop[ 0 ]  ){
          	
          	case 'esquerdo':
          	          		
          		$this->pos_x = 0;
          	
          	break;
			
		case 'direito':
		
			$this->pos_x = $this->largura - $this->nova_largura;
			
		break;
			
		case 'meio':
			
			$this->pos_x = ( $this->largura - $this->nova_largura ) / 2;
			
		break;
			
		default:
			
			$this->pos_x = $this->posicao_crop[ 0 ];
				
		break;
		
           }
          
           switch( $this->posicao_crop[ 1 ] ){
          	
          	case 'topo':
          		
          		$this->pos_y = 0;
			
		break;
			
		case 'inferior':
			
			$this->pos_y = $this->altura - $this->nova_altura;
			
		break;
			
		case 'meio':
			
			$this->pos_y = ( $this->altura - $this->nova_altura ) / 2;
				
		break;
			
		default:
			
			$this->pos_y = $this->posicao_crop[ 1 ];
				
		break;
			
	 }
		
	  $this->posicao_crop[ 0 ] = $this->pos_x;
	  $this->posicao_crop[ 1 ] = $this->pos_y;

          if($auto) 	imagecopyresampled( $this->img_temp, $this->img, -$this->posicao_crop[0], -$this->posicao_crop[1], 0, 0, $this->posicao_crop[2], $this->posicao_crop[3], $this->largura, $this->altura );
		  		else 				imagecopyresampled( $this->img_temp, $this->img, 0, 0, $this->posicao_crop[0], $this->posicao_crop[1], $this->nova_largura, $this->nova_altura, $this->posicao_crop[2], $this->posicao_crop[3] );

          $this->img     = $this->img_temp;
     } // fim redimensionaCrop

     /**
      * flipa/inverte imagem
      * baseado no script original de Noah Winecoff
      * http://www.php.net/manual/en/ref.image.php#62029
      * @param String $tipo tipo de espelhamento: h - horizontal, v - vertical
      * @return Object instância atual do objeto, para métodos encadeados
      **/
     public function flip( $tipo = 'h' )
     {
          $w = imagesx( $this->img );
          $h = imagesy( $this->img );

          $this->img_temp = imagecreatetruecolor( $w, $h );

          // vertical
          if ( 'v' == $tipo )
          {
               for ( $y = 0; $y < $h; $y++ )
               {
                    imagecopy( $this->img_temp, $this->img, 0, $y, 0, $h - $y - 1, $w, 1 );
               }
          }
          // horizontal
          elseif ( 'h' == $tipo )
          {
               for ( $x = 0; $x < $w; $x++ )
               {
                    imagecopy( $this->img_temp, $this->img, $x, 0, $w - $x - 1, 0, 1, $h );
               }
          }

          $this->img     = $this->img_temp;

          return $this;
     } // fim flip

     /**
      * gira imagem
      * @param Int $graus grau para giro
      * @return Object instância atual do objeto, para métodos encadeados
      **/
     public function gira( $graus )
     {
          $cor_fundo     = imagecolorallocate( $this->img, $this->rgb[0], $this->rgb[1], $this->rgb[2] );
          $this->img     = imagerotate( $this->img, $graus, $cor_fundo );
          imagealphablending( $this->img, true );
          imagesavealpha( $this->img, true );
          $this->largura = imagesx( $this->img );
          $this->altura = imagesx( $this->img );
          return $this;
     } // fim girar

     /**
      * adiciona texto à imagem
      * @param String $texto texto a ser inserido
      * @param Int $tamanho tamanho da fonte
      *            Ver: http://br2.php.net/imagestring
      * @param Int $x posição x do texto na imagem
      * @param Int $y posição y do texto na imagem
      * @param Array/String $cor_fundo array com cores RGB ou string com cor hexadecimal
      * @param Boolean $truetype true para utilizar fonte truetype, false para fonte do sistema
      * @param String $fonte nome da fonte truetype a ser utilizada
      * @return void
      **/
     public function legenda( $texto, $tamanho = 5, $x = 0, $y = 0, $cor_fundo = '', $truetype = false, $fonte = '' )
     {
          $cor_texto = imagecolorallocate( $this->img, $this->rgb[0], $this->rgb[1], $this->rgb[2] );

          /**
           * Define tamanho da legenda para posições fixas e fundo da legenda
           **/
          if( $truetype  === true )
          {
               $dimensoes_texto     = imagettfbbox( $tamanho, 0, $fonte, $texto );
               $largura_texto          = $dimensoes_texto[4];
               $altura_texto          = $tamanho;
          }
          else
          {
               if( $tamanho > 5 ) $tamanho = 5;
               $largura_texto     = imagefontwidth( $tamanho ) * strlen( $texto );
               $altura_texto     = imagefontheight( $tamanho );
          }

          if( is_string( $x ) && is_string( $y ) )
          {
               list( $x, $y ) = $this->calculaPosicaoLegenda( $x . '_' . $y, $largura_texto, $altura_texto );
          }

          /**
           * Cria uma nova imagem para usar de fundo da legenda
           **/
          if( $cor_fundo )
          {
               if( is_array( $cor_fundo ) )
               {
                    $this->rgb = $cor_fundo;
               }
               elseif( strlen( $cor_fundo ) > 3 )
               {
                    $this->hexa( $cor_fundo );
               }

               $this->img_temp = imagecreatetruecolor( $largura_texto, $altura_texto );
               $cor_fundo = imagecolorallocate( $this->img_temp, $this->rgb[0], $this->rgb[1], $this->rgb[2] );
               imagefill( $this->img_temp, 0, 0, $cor_fundo );

               imagecopy( $this->img, $this->img_temp, $x, $y, 0, 0, $largura_texto, $altura_texto );
          }

          // truetype ou fonte do sistema?
          if ( $truetype === true )
          {
               $y = $y + $tamanho;
               imagettftext( $this->img, $tamanho, 0, $x, $y, $cor_texto, $fonte, $texto );
          }
          else
          {
               imagestring( $this->img, $tamanho, $x, $y, $texto, $cor_texto );
          }
          return $this;
     } // fim legenda

    /**
     * Calcula a posição da legenda de acordo com string passada via parâmetro
     *
     * @param String $posicao valores pré-definidos (topo_esquerda, meio_centro etc.)
     * @param Integer $largura largura da imagem
     * @param Integer $altura altura da imagem
     * @return void
     **/
     private function calculaPosicaoLegenda( $posicao, $largura, $altura )
     {
          // define X e Y para posicionamento
          switch( $posicao )
          {
               case 'topo_esquerda':
                    $x = 0;
                    $y = 0;
                    break;
               case 'topo_centro':
                    $x = ( $this->largura - $largura ) / 2;
                    $y = 0;
                    break;
               case 'topo_direita':
                    $x = $this->largura - $largura;
                    $y = 0;
                    break;
               case 'meio_esquerda':
                    $x = 0;
                    $y = ( $this->altura / 2 ) - ( $altura / 2 );
                    break;
               case 'meio_centro':
                    $x = ( $this->largura - $largura ) / 2;
                    $y = ( $this->altura - $altura ) / 2 ;
                    break;
               case 'meio_direita':
                    $x = $this->largura - $largura;
                    $y = ( $this->altura / 2) - ( $altura / 2 );
                    break;
               case 'baixo_esquerda':
                    $x = 0;
                    $y = $this->altura - $altura;
                    break;
               case 'baixo_centro':
                    $x = ( $this->largura - $largura ) / 2;
                    $y = $this->altura - $altura;
                    break;
               case 'baixo_direita':
                    $x = $this->largura - $largura;
                    $y = $this->altura - $altura;
                    break;
               default:
                    return false;
                    break;
          } // end switch posicao

          return array( $x, $y );
     } // fim calculaPosicaoLegenda

     /**
      * adiciona imagem de marca d'água
      * @param String $imagem caminho da imagem de marca d'água
      * @param Int/String $x posição x da marca na imagem ou constante para marcaFixa()
      * @param Int/Sring $y posição y da marca na imagem ou constante para marcaFixa()
      * @return Boolean true/false dependendo do resultado da operação
      * @param Int $alfa valor para transparência (0-100)
      *                 -> se utilizar alfa, a função imagecopymerge não preserva
      *                 -> o alfa nativo do PNG
      * @return Object instância atual do objeto, para métodos encadeados
      **/
     public function marca( $imagem, $x = 0, $y = 0, $alfa = 100 )
     {
          // cria imagem temporária para merge
          if ( $imagem ) {

               if( is_string( $x ) && is_string( $y ) )
               {
                    return $this->marcaFixa( $imagem, $x . '_' . $y, $alfa );
               }

               $pathinfo = pathinfo( $imagem );
               switch( strtolower( $pathinfo['extension'] ) )
               {
                    case 'jpg':
                    case 'jpeg':
                         $marcadagua = imagecreatefromjpeg( $imagem );
                         break;
                    case 'png':
                         $marcadagua = imagecreatefrompng( $imagem );
                         break;
                    case 'gif':
                         $marcadagua = imagecreatefromgif( $imagem );
                         break;
                    case 'bmp':
                         $marcadagua = imagecreatefrombmp( $imagem );
                         break;
                    default:
                         trigger_error( 'Arquivo de marca d\'água inválido.', E_USER_ERROR );
                         return false;
               }
          }
          else
          {
               return false;
          }
          // dimensões
          $marca_w     = imagesx( $marcadagua );
          $marca_h     = imagesy( $marcadagua );
          // retorna imagens com marca d'água
          if ( is_numeric( $alfa ) && ( ( $alfa > 0 ) && ( $alfa < 100 ) ) ) {
               imagecopymerge( $this->img, $marcadagua, $x, $y, 0, 0, $marca_w, $marca_h, $alfa );
          } else {
               imagecopy( $this->img, $marcadagua, $x, $y, 0, 0, $marca_w, $marca_h );
          }
          return $this;
     } // fim marca

     /**
      * adiciona imagem de marca d'água, com valores fixos
      * ex: topo_esquerda, topo_direita etc.
      * Implementação original por Giolvani <inavloig@gmail.com>
      * @param String $imagem caminho da imagem de marca d'água
      * @param String $posicao posição/orientação fixa da marca d'água
      *       [topo, meio, baixo] + [esquerda, centro, direita]
      * @param Int $alfa valor para transparência (0-100)
      * @return void
      **/
     private function marcaFixa( $imagem, $posicao, $alfa = 100 )
     {

          // dimensões da marca d'água
          list( $marca_w, $marca_h ) = getimagesize( $imagem );

          // define X e Y para posicionamento
          switch( $posicao )
          {
               case 'topo_esquerda':
                    $x = 0;
                    $y = 0;
                    break;
               case 'topo_centro':
                    $x = ( $this->largura - $marca_w ) / 2;
                    $y = 0;
                    break;
               case 'topo_direita':
                    $x = $this->largura - $marca_w;
                    $y = 0;
                    break;
               case 'meio_esquerda':
                    $x = 0;
                    $y = ( $this->altura / 2 ) - ( $marca_h / 2 );
                    break;
               case 'meio_centro':
                    $x = ( $this->largura - $marca_w ) / 2;
                    $y = ( $this->altura / 2 ) - ( $marca_h / 2 );
                    break;
               case 'meio_direita':
                    $x = $this->largura - $marca_w;
                    $y = ( $this->altura / 2) - ( $marca_h / 2 );
                    break;
               case 'baixo_esquerda':
                    $x = 0;
                    $y = $this->altura - $marca_h;
                    break;
               case 'baixo_centro':
                    $x = ( $this->largura - $marca_w ) / 2;
                    $y = $this->altura - $marca_h;
                    break;
               case 'baixo_direita':
                    $x = $this->largura - $marca_w;
                    $y = $this->altura - $marca_h;
                    break;
               default:
                    return false;
                    break;
          } // end switch posicao

          // cria marca
          $this->marca( $imagem, $x, $y, $alfa );
          return $this;
     } // fim marcaFixa

    /**
      * Aplica filtros avançados como brilho, contraste, pixelate, blur
      * Requer o GD compilado com a função imagefilter()
      * http://br.php.net/imagefilter
      * @param String $filtro constante/nome do filtro
      * @param Integer $quantidade número de vezes que o filtro deve ser aplicado
      *            utilizado em blur, edge, emboss, pixel e rascunho
      * @param $arg1, $arg2 e $arg3 - ver manual da função imagefilter
      * @return Object instância atual do objeto, para métodos encadeados
     **/
    public function filtra( $filtro, $quantidade = 1, $arg1 = NULL, $arg2 = NULL, $arg3 = NULL, $arg4 = NULL )
    {
         switch( $filtro )
         {
             case 'blur':
                if( is_numeric( $quantidade ) && $quantidade > 1 )
                {
                    for( $i = 1; $i <= $quantidade; $i++ )
                    {
                        imagefilter( $this->img, IMG_FILTER_GAUSSIAN_BLUR );
                    }
                }
                else
                {
                    imagefilter( $this->img, IMG_FILTER_GAUSSIAN_BLUR );
                }
                break;
            case 'blur2':
                if( is_numeric( $quantidade ) && $quantidade > 1 )
                {
                    for( $i = 1; $i <= $quantidade; $i++ )
                    {
                        imagefilter( $this->img, IMG_FILTER_SELECTIVE_BLUR );
                    }
                }
                else
                {
                    imagefilter( $this->img, IMG_FILTER_SELECTIVE_BLUR );
                }
                break;
            case 'brilho':
                imagefilter( $this->img, IMG_FILTER_BRIGHTNESS, $arg1 );
                break;
            case 'cinzas':
                imagefilter( $this->img, IMG_FILTER_GRAYSCALE );
                break;
            case 'colorir':
                imagefilter( $this->img, IMG_FILTER_COLORIZE, $arg1, $arg2, $arg3, $arg4 );
                break;
            case 'contraste':
                imagefilter( $this->img, IMG_FILTER_CONTRAST, $arg1 );
                break;
            case 'edge':
                if( is_numeric( $quantidade ) && $quantidade > 1 )
                {
                    for( $i = 1; $i <= $quantidade; $i++ )
                    {
                        imagefilter( $this->img, IMG_FILTER_EDGEDETECT );
                    }
                }
                else
                {
                    imagefilter( $this->img, IMG_FILTER_EDGEDETECT );
                }
                break;
            case 'emboss':
                if( is_numeric( $quantidade ) && $quantidade > 1 )
                {
                    for( $i = 1; $i <= $quantidade; $i++ )
                    {
                        imagefilter( $this->img, IMG_FILTER_EMBOSS );
                    }
                }
                else
                {
                    imagefilter( $this->img, IMG_FILTER_EMBOSS );
                }
                break;
            case 'negativo':
                imagefilter( $this->img, IMG_FILTER_NEGATE );
                break;
            case 'ruido':
                if( is_numeric( $quantidade ) && $quantidade > 1 )
                {
                    for( $i = 1; $i <= $quantidade; $i++ )
                    {
                        imagefilter( $this->img, IMG_FILTER_MEAN_REMOVAL );
                    }
                }
                else
                {
                    imagefilter( $this->img, IMG_FILTER_MEAN_REMOVAL );
                }
                break;
            case 'suave':
                if( is_numeric( $quantidade ) && $quantidade > 1 )
                {
                    for( $i = 1; $i <= $quantidade; $i++ )
                    {
                        imagefilter( $this->img, IMG_FILTER_SMOOTH, $arg1 );
                    }
                }
                else
                {
                    imagefilter( $this->img, IMG_FILTER_SMOOTH, $arg1 );
                }
                break;
            // SOMENTE 5.3 ou superior
            case 'pixel':
                if( is_numeric( $quantidade ) && $quantidade > 1 )
                {
                    for( $i = 1; $i <= $quantidade; $i++ )
                    {
                        imagefilter( $this->img, IMG_FILTER_PIXELATE, $arg1, $arg2 );
                    }
                }
                else
                {
                    imagefilter( $this->img, IMG_FILTER_PIXELATE, $arg1, $arg2 );
                }
                break;
            default:
                break;
         }
          return $this;
    } // fim filtrar
    
    
    /**  
    Adiciona o melhor filtro para as imagens o sharpen | Jefferson Oliveira 
    Usa GD image objects 
    **/
    
   
   function imagesharpen() {
    
        $qualidade = array(
            array(-1, -1, -1),
            array(-1, 16, -1),
            array(-1, -1, -1),
        );
    
        $divisao = array_sum(array_map('array_sum', $qualidade));
        $offset = 0; 
        imageconvolution($this->img, $qualidade, $divisao, $offset);
        
        return $this;
    }	
    

     /**
      * retorna saída para tela ou arquivo
      * @param String $destino caminho e nome do arquivo a serem criados
      * @param Int $qualidade qualidade da imagem no caso de JPEG (0-100)
      * @return void
      **/
     public function grava( $destino='', $qualidade = 100 )
     {
          // dados do arquivo de destino
          if ( $destino )
          {
               $pathinfo               = pathinfo( $destino );
               $dir_destino          = $pathinfo['dirname'];
               $extensao_destino     = strtolower( $pathinfo['extension'] );

               // valida diretório
               if ( !is_dir( $dir_destino ) )
               {
                    trigger_error( 'Diretório de destino inválido ou inexistente', E_USER_ERROR );
               }
          }

          if ( !isset( $extensao_destino ) )
          {
               $extensao_destino = $this->extensao;
          }

          switch( $extensao_destino )
          {
               case 'jpg':
               case 'jpeg':
               case 'bmp':
                    if ( $destino )
                    {
                         imagejpeg( $this->img, $destino, $qualidade );
                    }
                    else
                    {
                         header( "Content-type: image/jpeg" );
                         imagejpeg( $this->img, NULL, $qualidade );
                         imagedestroy( $this->img );
                    }
                    break;
               case 'png':
                    if ( $destino )
                    {
                         imagepng( $this->img, $destino );
                    }
                    else
                    {
                         header( "Content-type: image/png" );
                         imagepng( $this->img );
                         imagedestroy( $this->img );
                    }
                    break;
               case 'gif':
                    if ( $destino )
                    {
                         imagegif( $this->img, $destino );
                    }
                    else
                    {
                         header( "Content-type: image/gif" );
                         imagegif( $this->img );
                         imagedestroy( $this->img );
                    }
                    break;
               default:
                    return false;
                    break;
          }
          
     return $this;

     } // fim grava

} // fim da classe


//------------------------------------------------------------------------------
// suporte para a manipulação de arquivos BMP

/*********************************************/
/* Function: ImageCreateFromBMP              */
/* Author:   DHKold                          */
/* Contact:  admin@dhkold.com                */
/* Date:     The 15th of June 2005           */
/* Version:  2.0B                            */
/*********************************************/

function imagecreatefrombmp($filename) {
 //Ouverture du fichier en mode binaire
   if (! $f1 = fopen($filename,"rb")) return FALSE;

 //1 : Chargement des ent?tes FICHIER
   $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
   if ($FILE['file_type'] != 19778) return FALSE;

 //2 : Chargement des ent?tes BMP
   $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
                     '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
                     '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
   $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
   if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
   $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
   $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
   $BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
   $BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
   $BMP['decal'] = 4-(4*$BMP['decal']);
   if ($BMP['decal'] == 4) $BMP['decal'] = 0;

 //3 : Chargement des couleurs de la palette
   $PALETTE = array();
   if ($BMP['colors'] < 16777216)
   {
     $PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
   }

 //4 : Cr?ation de l'image
   $IMG = fread($f1,$BMP['size_bitmap']);
   $VIDE = chr(0);

   $res = imagecreatetruecolor($BMP['width'],$BMP['height']);
   $P = 0;
   $Y = $BMP['height']-1;
   while ($Y >= 0)
   {
     $X=0;
     while ($X < $BMP['width'])
     {
      if ($BMP['bits_per_pixel'] == 24)
          $COLOR = @unpack("V",substr($IMG,$P,3).$VIDE);
      elseif ($BMP['bits_per_pixel'] == 16)
      {
          $COLOR = @unpack("n",substr($IMG,$P,2));
          $COLOR[1] = $PALETTE[$COLOR[1]+1];
      }
      elseif ($BMP['bits_per_pixel'] == 8)
      {
          $COLOR = @unpack("n",$VIDE.substr($IMG,$P,1));
          $COLOR[1] = $PALETTE[$COLOR[1]+1];
      }
      elseif ($BMP['bits_per_pixel'] == 4)
      {
          $COLOR = @unpack("n",$VIDE.substr($IMG,floor($P),1));
          if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
          $COLOR[1] = $PALETTE[$COLOR[1]+1];
      }
      elseif ($BMP['bits_per_pixel'] == 1)
      {
          $COLOR = @unpack("n",$VIDE.substr($IMG,floor($P),1));
          if     (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]          >>7;
          elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
          elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
          elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
          elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
          elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
          elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
          elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
          $COLOR[1] = $PALETTE[$COLOR[1]+1];
      }
      else
          return FALSE;
      imagesetpixel($res,$X,$Y,$COLOR[1]);
      $X++;
      $P += $BMP['bytes_per_pixel'];
     }
     $Y--;
     $P+=$BMP['decal'];
   }

 //Fermeture du fichier
   fclose($f1);

 return $res;

} // fim function image from BMP
