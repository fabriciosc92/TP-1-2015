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
    private $widht, $height, $new_widht, $new_heigth, $size_html;
    
    /**
    * Variables for positioning the crop
    **/
    private $position_x, $position_y;
    
    /**
     * Information about the uploaded file and directory
     **/
    private $format, $extension, $size, $file, $path;

    /**
     * Array RGB resize with background fill
     **/
    private $rgb;

    /**
     * Coordinates for positioning crop
     **/
    private $position_crop;

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
	
		    $reset_variables = $this->origem = $this->img = $this->img_temp = $this->widht = $this->height = 
        $this->new_widht = $this->new_heigth = $this->size_html = $this->position_x = 
        $this->position_y = $this->format = $this->extension = $this->size = $this->file = 
        $this->path = $this->position_crop;

        $reset_variables = NULL;
	
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
               $this->dadosfile();

               // checks if is an image
               if ( !$this->eImagem() )
               {
                    trigger_error( 'Erro: file '.$this->origem.' is not a image!', E_USER_ERROR );
                    log_it("File is not a image: " $this->origem.);
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
               trigger_error( 'Erro: image file not found!', E_USER_ERROR );
               log_it("Image file not found!");
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
        $this->widht              = $dimensoes[0];
        $this->height               = $dimensoes[1];

       /**
        * 1 = gif, 2 = jpeg, 3 = png, 6 = BMP
        * http://br2.php.net/manual/en/function.exif-imagetype.php
        **/
        $this->format               = $dimensoes[2];
        $this->size_html          = $dimensoes[3];
     } // end dimensoes

     /**
      * Search file data
      * @return void
      **/
     private function dadosfile()
     {
          // source image
          $pathinfo            = pathinfo( $this->origem );
          
          if(array_key_exists('extension', $pathinfo))
          {
                $this->extension = strtolower($pathinfo['extension']);
          }
          else
          {
                $this->extension = strtolower(str_replace('image/', '', $obj['mime']));
          }
             
          $this->file       = $pathinfo['basename'];
          $this->path     = $pathinfo['dirname'];
     } // end dadosfile

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
      * @param String $widht of the image to be created
      * @param String $height of the image to be created
      * @return Object current instance of the object, for chained method
      **/
     public function novaImagem( $widht, $height )
     {
          $this->widht     = $widht;
          $this->height     = $height;
          $this->img = imagecreatetruecolor( $this->widht, $this->height );
          
          $cor_fundo = color_background();

          imagefill( $this->img, 0, 0, $cor_fundo );
          $this->extension = 'jpg';
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
          $this->extension = strtolower( $pathinfo['extension'] );

          switch( $this->extension )
          {
               case 'jpg':
               case 'jpeg':
                    $this->format = 2;
                    break;
               case 'gif':
                    $this->format = 1;
                    break;
               case 'png':
                    $this->format = 3;
                    break;
               case 'bmp':
                    $this->format = 6;
                    break;
               default:
                    break;
          }

     $this->criaImagem();
     $this->widht     = imagesx( $this->img );
     $this->height     = imagesy( $this->img );
     return $this;
     } // end carregaUrl

     /**
      * Create image object for manipulation in GD
      * @return void
      **/
     private function criaImagem()
     {
          switch ( $this->format )
          {
               case 1:
                    $this->img = imagecreatefromgif( $this->origem );
                    $this->extension = 'gif';
                    break;
               case 2:
                    $this->img = imagecreatefromjpeg( $this->origem );
                    $this->extension = 'jpg';
                    break;
               case 3:
                    $this->img = imagecreatefrompng( $this->origem );
                    $this->extension = 'png';
                    break;
               case 6:
                    $this->img = imagecreatefrombmp( $this->origem );
                    $this->extension = 'bmp';
                    break;
               default:
                    trigger_error( 'file inválido!', E_USER_ERROR );
                    log_it("Invalid file!" E_USER_ERROR);
                    break;
          }
     } // end criaImagem

     /**
      * Stores the RGB values for resizing to fill
      * @param Values R, G e B
      * @return Object current instance of the object, for chained method
      **/
     public function rgb( $red, $green, $blue )
     {
          $this->rgb = array( $red, $green, $blue );
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

          if( strlen( $cor ) == 3 ) 
          {
            
            $cor .= $cor; // #fff, #000 etc.

          } 
          else 
          {

          }

          $this->rgb = array(
            hexdec( substr( $cor, 0, 2 ) ),
            hexdec( substr( $cor, 2, 2 ) ),
            hexdec( substr( $cor, 4, 2 ) ),
          );
          return $this;
     }// end hexa

     /**
      * Stores positions x and y for crop
      * @param Int x - position x of crop
			* @param Int y - position y of crop
			* @param Int w - width  - widhtOrigem (by OctaAugusto)
			* @param Int h - height - heightOrigem (by OctaAugusto)
      * @return Object current instance of the object, for chained method
      **/
     public function posicaoCrop( $x, $y, $w=0, $h=0 )
     {
          // no width or manually sitting height, image original handle
		  		if(!$w)
          {
            $w = $this->widht;
          }
		  		if(!$h)
          {
            $h = $this->height;
          } 

          $this->position_crop = array( $x, $y, $w, $h );

          return $this;
     }

     /**
      * Resize image
      * @param Int $new_widht value in pixels of the new image widht
      * @param Int $new_heigth value in pixels of the new image height
      * @param String $tipo method for scaling (default [empty], fill or crop)
      * @return Object current instance of the object, for chained method
      **/
     public function redimensiona( $new_widht = 0, $new_heigth = 0, $tipo = '' )
     {

          // to set variables passed via parameter
          $this->new_widht         = $new_widht;
          $this->new_heigth          = $new_heigth;

          // checks went height or width in percent
          // widht %
          $pos = strpos( $this->new_widht, '%' );

          if( $pos !== false && $pos > 0 )
          {
               $porcentagem               = ( ( int ) str_replace( '%', '', $this->new_widht ) ) / 100;
               $this->new_widht          = round( $this->widht * $porcentagem );
          }
          else
          {

          }
          // height %
          $pos = strpos( $this->new_heigth, '%' );

          if( $pos !== false && $pos > 0 )
          {
               $porcentagem               = ( ( int ) str_replace( '%', '', $this->new_heigth ) ) / 100;
               $this->new_heigth          = $this->height * $porcentagem;
          }
          else
          {

          }

          // sets whether just passed new width or height
          if ( !$this->new_widht && !$this->new_heigth )
          {
               return false;
          }
          // just pass height
          elseif ( !$this->new_widht )
          {
               $this->new_widht = $this->widht / ( $this->height/$this->new_heigth );
          }
          // just pass widht
          elseif ( !$this->new_heigth )
          {
               $this->new_heigth = $this->height / ( $this->widht/$this->new_widht );
          }
          else
          {

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
          $this->height     = $this->new_heigth;
          $this->widht     = $this->new_widht;

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
          $this->img_temp = imagecreatetruecolor( $this->new_widht, $this->new_heigth );

          imagecopyresampled( $this->img_temp, $this->img, 0, 0, 0, 0, $this->new_widht, 
          $this->new_heigth, $this->widht, $this->height );
          $this->img     = $this->img_temp;
     } // end redimensiona()

     /**
      * Add image to the background color
      * @return void
      **/
     private function preencheImagem()
     {
          $cor_fundo = color_background();
          
          imagefill( $this->img_temp, 0, 0, $cor_fundo );
     } // end preencheImagem

     /**
      * Resize image whitout crop, propotionaly
      * filling empty space with specified RGB color
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
          } 
          else 
          {
              $fator = $this->altura / $this->nova_altura;
          }

          $dif_w = $this->largura / $fator;
          $dif_h = $this->altura  / $fator;

          // copia com o novo tamanho, centralizando
          $dif_x = ( $dif_x - $dif_w ) / 2;
          $dif_y = ( $dif_y - $dif_h ) / 2;

          imagecopyresampled( $this->img_temp, $this->img, $dif_x, $dif_y, 0, 0, $dif_w, $dif_h, 

          $this->largura, $this->altura );
          $this->img     = $this->img_temp;
     } // end redimensionaPreenchimento()

     /**
      * Resize image without cutting in proportion and unfilled.
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
            } 
            else 
            {
               $dif_w = $this->nova_largura;
               $dif_h = $this->nova_largura/$ratio_orig;
            }

          // cria imagem de destino temporária
          $this->img_temp = imagecreatetruecolor( $dif_w, $dif_h );
         
          // Resample
          imagecopyresampled($this->img_temp, $this->img, 0, 0, 0, 0, $dif_w, $dif_h, $this->largura,
          $this->altura);
          $this->img   = $this->img_temp;
     } // fim redimensionaProporcional()


     /**
      * Calculate crop position
      * Indices 0 and 1 correspond to the x and y position of the crop in the image
      * The 2 indexes and 3 correspond to the size of the crop
      * @return void
      **/
     private function calculaPosicaoCrop()
     {
          // media widht/height
          $hm     = $this->height / $this->new_heigth;
          $wm     = $this->widht / $this->new_widht;

          // 50% para cálculo do crop
          $h_height = $this->new_heigth / 2;
          $h_width  = $this->new_widht / 2;

          // calcula novas widht e height
          if( !is_array( $this->position_crop ) )
          {
               if ( $wm > $hm )
               {
                    $this->position_crop[2]     = $this->widht / $hm;
                    $this->position_crop[3]     = $this->new_heigth;
                    $this->position_crop[0]     = ( $this->position_crop[2] / 2 ) - $h_width;
                    $this->position_crop[1]     = 0;
               }

               // widht <= height
               elseif ( ( $wm <= $hm ) )
               {
                    $this->position_crop[2]     = $this->new_widht;
                    $this->position_crop[3]     = $this->height / $wm;
                    $this->position_crop[0]     = 0;
                    $this->position_crop[1]     = ( $this->position_crop[3] / 2 ) - $h_height;
               }
               else
               {

               }
          }
     } // end calculaPosicaoCrop

     /**
      * Resize image
      * @return void
      **/
     private function redimensionaCrop()
     {
          // calculate crop position automaticaly
          if(!is_array($this->position_crop))
          {
<<<<<< HEAD
          	$auto=1; 
          	$this->calculaPosicaoCrop(); 
		  		}
		  		// crop position manualy
		  		else {
		  			$auto = 0;
		  		}
=======
            $auto=1; 
            $this->calculaPosicaoCrop(); 
          }
                // posicionamento do crop setado manualmente
                else 
                {
                    $auto = 0;
                }
>>>>>>> master

          // create temporary image
          $this->img_temp = imagecreatetruecolor( $this->new_widht, $this->new_heigth );

          // add background color 
          $this->preencheImagem();
          
          //inteligents arrays
          switch( $this->position_crop[ 0 ]  ){
            
            case 'esquerdo':
                            
                $this->position_x = 0;
            
            break;
            
        case 'direito':
        
            $this->position_x = $this->widht - $this->new_widht;
            
        break;
            
        case 'meio':
            
            $this->position_x = ( $this->widht - $this->new_widht ) / 2;
            
        break;
            
        default:
            
            $this->position_x = $this->position_crop[ 0 ];
                
        break;
        
           }
          
           switch( $this->position_crop[ 1 ] ){
            
            case 'topo':
                
                $this->position_y = 0;
            
        break;
            
        case 'inferior':
            
            $this->position_y = $this->height - $this->new_heigth;
            
        break;
            
        case 'meio':
            
            $this->position_y = ( $this->height - $this->new_heigth ) / 2;
                
        break;
            
        default:
            
            $this->position_y = $this->position_crop[ 1 ];
                
        break;
            
     }
        
      $this->position_crop[ 0 ] = $this->position_x;
      $this->position_crop[ 1 ] = $this->position_y;

          if($auto)
          {
                imagecopyresampled( $this->img_temp, $this->img, -$this->position_crop[0],
           -$this->position_crop[1], 0, 0, $this->position_crop[2], $this->position_crop[3], $this->widht,
            $this->height );
          }     
          else 
          {
            imagecopyresampled( $this->img_temp, $this->img, 0, 0, $this->position_crop[0], 
                $this->position_crop[1], $this->new_widht, $this->new_heigth, 
                $this->position_crop[2], $this->position_crop[3] );
          }
          $this->img     = $this->img_temp;
     } // end redimensionaCrop

     /**
      * flip/invert image
      * @param String $tipo flip type: h - horizontal, v - vertical
      * @return Object current instance of the object, for chained method
      **/
     public function flip( $tipo = 'h' )
     {
          $w = imagesx( $this->img );
          $h = imagesy( $this->img );

          $this->img_temp = imagecreatetruecolor( $w, $h );

          // vertical
          if ( 'v' == $tipo )
          {
               for ( $y = 0; $y < $h; $y = $y + 1 )
               {
                    imagecopy( $this->img_temp, $this->img, 0, $y, 0, $h - $y - 1, $w, 1 );
               }
          }
          // horizontal
          elseif ( 'h' == $tipo )
          {
               for ( $x = 0; $x < $w; $x = $x + 1 )
               {
                    imagecopy( $this->img_temp, $this->img, $x, 0, $w - $x - 1, 0, 1, $h );
               }
          }

          $this->img     = $this->img_temp;

          return $this;
     } // end flip

     /**
      * Rotate image
      * @param Int $graus grau para giro
      * @return Object instância atual do objeto, para métodos encadeados
      **/
     

     public function gira( $graus )
     {
          $cor_fundo = color_background();

          $this->img     = imagerotate( $this->img, $graus, $cor_fundo );

          imagealphablending( $this->img, true );
          imagesavealpha( $this->img, true );

          $this->widht = imagesx( $this->img );
          $this->height = imagesx( $this->img );

          return $this;
     } // fim girar

     /**
      * add text in the image
      * @param String $texto text to be added
      * @param Int $size font size
      * @param Int $x x position text in the image
      * @param Int $y y position text in the image
      * @param Array/String $cor_fundo array whith RGB colors or string with hexadecimal colors
      * @param Boolean $truetype true for font truetype, false for system font
      * @param String $fonte font name truetype to use
      * @return void
      **/
     public function legenda( $texto, $size = 5, $x = 0, $y = 0, $cor_fundo = '', 
        $truetype = false, $fonte = '' )
     {
          $cor_texto = imagecolorallocate( $this->img, $this->rgb[0], $this->rgb[1], $this->rgb[2] );

          /**
           * Sets size of the caption for fixed positions and legend background
           **/
          if( $truetype  === true )
          {
               $dimensoes_texto     = imagettfbbox( $size, 0, $fonte, $texto );
               $widht_texto          = $dimensoes_texto[4];
               $height_texto          = $size;
          }
          else
          {
               if( $size > 5 ) $size = 5;
               $widht_texto     = imagefontwidth( $size ) * strlen( $texto );
               $height_texto     = imagefontheight( $size );
          }

          if( is_string( $x ) && is_string( $y ) )
          {
               list( $x, $y ) = $this->calculaPosicaoLegenda( $x . '_' . $y, $widht_texto, $height_texto );
          }

          /**
           * Create a new image to use Legend background
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

               $this->img_temp = imagecreatetruecolor( $widht_texto, $height_texto );
               
               $cor_fundo = color_background();

               imagefill( $this->img_temp, 0, 0, $cor_fundo );

               imagecopy( $this->img, $this->img_temp, $x, $y, 0, 0, $widht_texto, $height_texto );
          }

          if ( $truetype === true )
          {
               $y = $y + $size;
               imagettftext( $this->img, $size, 0, $x, $y, $cor_texto, $fonte, $texto );
          }
          else
          {
               imagestring( $this->img, $size, $x, $y, $texto, $cor_texto );
          }
          return $this;
     } // end legenda

     public function color_background($cor_fundo)
     {
        $cor_fundo = imagecolorallocate( $this->img, $this->rgb[0], $this->rgb[1], $this->rgb[2] );
     }

    /**
     * Calculates the position of the legend according to string passed via parameter
     *
     * @param String $posicao predefined values(topo_esquerda, meio_centro etc.)
     * @param Integer $widht image widht
     * @param Integer $height image height
     * @return void
     **/
     private function calculaPosicaoLegenda( $posicao, $widht, $height )
     {
          // sets X and Y to position
          switch( $posicao )
          {
               case 'topo_esquerda':
                    $x = 0;
                    $y = 0;
                    break;
               case 'topo_centro':
                    $x = ( $this->widht - $widht ) / 2;
                    $y = 0;
                    break;
               case 'topo_direita':
                    $x = $this->widht - $widht;
                    $y = 0;
                    break;
               case 'meio_esquerda':
                    $x = 0;
                    $y = ( $this->height / 2 ) - ( $height / 2 );
                    break;
               case 'meio_centro':
                    $x = ( $this->widht - $widht ) / 2;
                    $y = ( $this->height - $height ) / 2 ;
                    break;
               case 'meio_direita':
                    $x = $this->widht - $widht;
                    $y = ( $this->height / 2) - ( $height / 2 );
                    break;
               case 'baixo_esquerda':
                    $x = 0;
                    $y = $this->height - $height;
                    break;
               case 'baixo_centro':
                    $x = ( $this->widht - $widht ) / 2;
                    $y = $this->height - $height;
                    break;
               case 'baixo_direita':
                    $x = $this->widht - $widht;
                    $y = $this->height - $height;
                    break;
               default:
                    return false;
                    break;
          } // end switch posicao

          return array( $x, $y );
     } // end calculaPosicaoLegenda

     const MAX_TRANSPARENCE_QUALITY = 100;
     const LOWER_TRANSPARENCE_QUALITY = 0;

     /**
      * add image watermark
      * @param String $imagem watermark image path
      * @param Int/String $x x position of the brand in the picture or constant for marcaFixa()
      * @param Int/Sring $y y position of the brand in the picture or constant for marcaFixa()
      * @return Boolean true/false depending on the result of the operation
      * @param Int $alfa alpha value (0-100)
      *                 -> using alpha, the imagecopymerge function does not preserve
      *                 -> the native alpha PNG
      * @return Object current instance of the object, for chained method
      **/
     public function marca( $imagem, $x = 0, $y = 0, $alfa = MAX_TRANSPARENCE_QUALITY)
     {
          // create temporary image for merge
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
                         trigger_error( 'Invalid whatermak file!', E_USER_ERROR );
                         log_it("Invalid whatermak file!");
                         return false;
               }
          }
          else
          {
               return false;
          }
<<<<<<  HEAD
          // sizes
          $marca_w     = imagesx( $marcadagua );
          $marca_h     = imagesy( $marcadagua );
          // return images with whatemarks
          if ( is_numeric( $alfa ) && ( ( $alfa > 0 ) && ( $alfa < 100 ) ) ) {
=======

          // dimensões
          $marca_w     = imagesx( $marcadagua );
          $marca_h     = imagesy( $marcadagua );

          // retorna imagens com marca d'água
          if ( is_numeric( $alfa ) && ( ( $alfa > LOWER_TRANSPARENCE_QUALITY ) && 
            ( $alfa < MAX_TRANSPARENCE_QUALITY ) ) ) 
          {
>>>>>>> master
               imagecopymerge( $this->img, $marcadagua, $x, $y, 0, 0, $marca_w, $marca_h, $alfa );
          } 
          else 
          {
               imagecopy( $this->img, $marcadagua, $x, $y, 0, 0, $marca_w, $marca_h );
          }
          return $this;
     } // end marca

     /**
      * add image watermark, with fixed values
      * @param String $imagem image path with whatermark
      * @param String $posicao position / orientation fixed watermark
      * @param Int $alfa value for transparency (0-100)
      * @return void
      **/
     private function marcaFixa( $imagem, $posicao, $alfa = MAX_TRANSPARENCE_QUALITY)
     {

          // watermark size
          list( $marca_w, $marca_h ) = getimagesize( $imagem );

          // sets X and Y to position
          switch( $posicao )
          {
               case 'topo_esquerda':
                    $x = 0;
                    $y = 0;
                    break;
               case 'topo_centro':
                    $x = ( $this->widht - $marca_w ) / 2;
                    $y = 0;
                    break;
               case 'topo_direita':
                    $x = $this->widht - $marca_w;
                    $y = 0;
                    break;
               case 'meio_esquerda':
                    $x = 0;
                    $y = ( $this->height / 2 ) - ( $marca_h / 2 );
                    break;
               case 'meio_centro':
                    $x = ( $this->widht - $marca_w ) / 2;
                    $y = ( $this->height / 2 ) - ( $marca_h / 2 );
                    break;
               case 'meio_direita':
                    $x = $this->widht - $marca_w;
                    $y = ( $this->height / 2) - ( $marca_h / 2 );
                    break;
               case 'baixo_esquerda':
                    $x = 0;
                    $y = $this->height - $marca_h;
                    break;
               case 'baixo_centro':
                    $x = ( $this->widht - $marca_w ) / 2;
                    $y = $this->height - $marca_h;
                    break;
               case 'baixo_direita':
                    $x = $this->widht - $marca_w;
                    $y = $this->height - $marca_h;
                    break;
               default:
                    return false;
                    break;
          } // end switch posicao

          // create brand
          $this->marca( $imagem, $x, $y, $alfa );
          return $this;
     } // end marcaFixa

    /**
      * Apply advanced filters to the brightness, contrast, pixelate, blur
      * Requires GD compiled with the imagefilter function ()
      * http://br.php.net/imagefilter
      * @param String $filtro constant / filter name
      * @param Integer $quantidade number of times the filter should be applied
      *            used in blur, edge, emboss, and pixel draft
      * @param $arg1, $arg2 e $arg3 - see function manual imagefilter
      * @return Object current instance of the object, for chained method
     **/
    public function filtra( $filtro, $quantidade = 1, $arg1 = NULL, $arg2 = NULL, $arg3 = NULL, $arg4 = NULL )
    {
         switch( $filtro )
         {
             case 'blur':
                if( is_numeric( $quantidade ) && $quantidade > 1 )
                {
                    for( $i = 1; $i <= $quantidade; $i = $i + 1 )
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
                    for( $i = 1; $i <= $quantidade; $i = $i + 1 )
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
                    for( $i = 1; $i <= $quantidade; $i = $i + 1 )
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
                    for( $i = 1; $i <= $quantidade; $i = $i + 1 )
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
                    for( $i = 1; $i <= $quantidade; $i = $i + 1 )
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
                    for( $i = 1; $i <= $quantidade; $i = $i + 1 )
                    {
                        imagefilter( $this->img, IMG_FILTER_SMOOTH, $arg1 );
                    }
                }
                else
                {
                    imagefilter( $this->img, IMG_FILTER_SMOOTH, $arg1 );
                }
                break;
            // JUST 5.3 or higher
            case 'pixel':
                if( is_numeric( $quantidade ) && $quantidade > 1 )
                {
                    for( $i = 1; $i <= $quantidade; $i = $i + 1 )
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
    } // end filtrar
    
    
    /**  
     *Adds the best filter to sharpen the images
     *Use GD image objects 
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
    
    const MAX_IMAGE_QUALITY = 100;

     /**
      * return output to screen or file
      * @param String $destino path and file name to be created
      * @param Int $qualidade image quality in the case of JPEG (0-100)
      * @return void
      **/
     public function grava( $destino='', $qualidade = MAX_IMAGE_QUALITY )
     {
          // target file data
          if ( $destino )
          {
               $pathinfo               = pathinfo( $destino );
               $dir_destino          = $pathinfo['dirname'];
               $extension_destino     = strtolower( $pathinfo['extension'] );

               // validate directory
               if ( !is_dir( $dir_destino ) )
               {
                    trigger_error( 'Invalid or absent path!', E_USER_ERROR );
                    log_it("Invalid or absent path!");
               }
          }

          if ( !isset( $extension_destino ) )
          {
               $extension_destino = $this->extension;
          }

          switch( $extension_destino )
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

     } // end grava

} // end of class


//------------------------------------------------------------------------------
// Support for handling BMP

/*********************************************/
/* Function: ImageCreateFromBMP              */
/* Author:   DHKold                          */
/* Contact:  admin@dhkold.com                */
/* Date:     The 15th of June 2005           */
/* Version:  2.0B                            */
/*********************************************/

function imagecreatefrombmp($filename) {
 //Ouverture du fichier en mode binaire
   if (! $f1 = fopen($filename,"rb")) 
   {
        return FALSE;
   }
   else
   {

   }
    

 //1 : Chargement des ent?tes FICHIER
   $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
   if ($FILE['file_type'] != 19778)
   {
        return FALSE;
   }
   else
   {

   } 

 //2 : Chargement des ent?tes BMP
   $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
                     '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
                     '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
   $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
   if ($BMP['size_bitmap'] == 0)
   {
        $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
   }
   else
   {

   }

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
   else
   {

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
      {
          $COLOR = @unpack("V",substr($IMG,$P,3).$VIDE);
      }
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
          if     (($P*8)%8 == 0) 
          {
            $COLOR[1] =  $COLOR[1] >>7;
          }
          elseif (($P*8)%8 == 1)
          {
            $COLOR[1] = ($COLOR[1] & 0x40)>>6;
          } 
          elseif (($P*8)%8 == 2) 
          {
            $COLOR[1] = ($COLOR[1] & 0x20)>>5; 
          }
          elseif (($P*8)%8 == 3)
          {
            $COLOR[1] = ($COLOR[1] & 0x10)>>4;
          } 
          elseif (($P*8)%8 == 4)
          {
            $COLOR[1] = ($COLOR[1] & 0x8)>>3;
          }
          elseif (($P*8)%8 == 5)
          {
             $COLOR[1] = ($COLOR[1] & 0x4)>>2;
          }
          elseif (($P*8)%8 == 6)
          {
            $COLOR[1] = ($COLOR[1] & 0x2)>>1;
          } 
          elseif (($P*8)%8 == 7)
          {
             $COLOR[1] = ($COLOR[1] & 0x1);
          }

          $COLOR[1] = $PALETTE[$COLOR[1]+1];
      }
      else
      {
        return FALSE;
      }    

      imagesetpixel($res,$X,$Y,$COLOR[1]);
      $X = $X + 1;
      $P = $P + $BMP['bytes_per_pixel'];
     }
     $Y = $Y - 1;
     $P = $P + $BMP['decal'];
   }

 //Fermeture du fichier
   fclose($f1);

 return $res;

} // fim function image from BMP
