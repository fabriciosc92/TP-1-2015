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
    private $origin, $img, $img_temp;

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
     public function __construct( $origin = '' )
     {

          $this->origin = $origin;

          if ( $this->origin )
          {
               $this->data();
          }

          // RGB default -> white
     $this->rgb( 255, 255, 255 );
     } // end constructor
     
     /**
      * Reset variables in order to use object in long threads
      * @return void
      **/
     public function reset()
     {
	
		    $reset_variables = $this->origin = $this->img = $this->img_temp = $this->widht = $this->height = 
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
     private function data()
     {

          // checks for image
          if ( is_file( $this->origin ) )
          {

               // files data
               $this->datafile();

               // checks if is an image
               if ( !$this->eImage() )
               {
                    trigger_error( 'Erro: file '.$this->origin.' is not a image!', E_USER_ERROR );
                    log_it("File is not a image: " $this->origin.);
               }
               else
               {
                    // search dimensions of the sent image
                    $this->dimensions();

                    // create image for php
                    $this->createImage();
               }
          }
          else
          {
               trigger_error( 'Erro: image file not found!', E_USER_ERROR );
               log_it("Image file not found!");
          }

     } // end dataimage

     /**
      * Load a new image outside builder
      * @param String path of the image to load
      * @return Object current instance of the object, for chained method
      **/
     public function load( $origin = '' )
     {
          $this->origin = $origin;
          $this->data();
          return $this;
     } // end load

     /**
      * Search dimensions and real image format
      * @return void
      **/
     private function dimensions()
     {
        $dimensions                  = getimagesize( $this->origin );
        $this->widht              = $dimensions[0];
        $this->height               = $dimensions[1];

       /**
        * 1 = gif, 2 = jpeg, 3 = png, 6 = BMP
        * http://br2.php.net/manual/en/function.exif-imagetype.php
        **/
        $this->format               = $dimensions[2];
        $this->size_html          = $dimensions[3];
     } // end dimensions

     /**
      * Search file data
      * @return void
      **/
     private function datafile()
     {
          // source image
          $pathinfo            = pathinfo( $this->origin );
          
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
     } // end datafile

     /**
      * Checks if the specified file is an image
      * @return Boolean true/false
      **/
     private function eImage()
     {
          // filter extension
          $valida = getimagesize( $this->origin );
          if ( !is_array( $valida ) || empty( $valida ) )
          {
              return false;
          }
          else
          {
              return true;
          }
     } // end validaimage

     /**
      * Create a new image to be worked with texts, etc.
      * Note: the color image must be passed before, via rgb () or hex ()
      * @param String $widht of the image to be created
      * @param String $height of the image to be created
      * @return Object current instance of the object, for chained method
      **/
     public function newImage( $widht, $height )
     {
          $this->widht     = $widht;
          $this->height     = $height;
          $this->img = imagecreatetruecolor( $this->widht, $this->height );
          
          $color_background = color_background();

          imagefill( $this->img, 0, 0, $color_background );
          $this->extension = 'jpg';
          return $this;
    } // end newImage

    /**
     * Upload an image via URL
     * Note: depends on the server settings for remote access files
     * @param String $url image path
     * @return Object current instance of the object, for chained method
     **/
     public function loadUrl( $url )
     {
          $this->origin = $url;
          $pathinfo = pathinfo( $this->origin );
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

     $this->createImage();
     $this->widht     = imagesx( $this->img );
     $this->height     = imagesy( $this->img );
     return $this;
     } // end loadUrl

     /**
      * Create image object for manipulation in GD
      * @return void
      **/
     private function createImage()
     {
          switch ( $this->format )
          {
               case 1:
                    $this->img = imagecreatefromgif( $this->origin );
                    $this->extension = 'gif';
                    break;
               case 2:
                    $this->img = imagecreatefromjpeg( $this->origin );
                    $this->extension = 'jpg';
                    break;
               case 3:
                    $this->img = imagecreatefrompng( $this->origin );
                    $this->extension = 'png';
                    break;
               case 6:
                    $this->img = imagecreatefrombmp( $this->origin );
                    $this->extension = 'bmp';
                    break;
               default:
                    trigger_error( 'file inválido!', E_USER_ERROR );
                    log_it("Invalid file!" E_USER_ERROR);
                    break;
          }
     } // end createImage

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
			* @param Int w - width  - widhtOrigin (by OctaAugusto)
			* @param Int h - height - heightOrigin (by OctaAugusto)
      * @return Object current instance of the object, for chained method
      **/
     public function cropPosition( $x, $y, $w=0, $h=0 )
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
     public function resize( $new_widht = 0, $new_heigth = 0, $tipo = '' )
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
                    $this->resizeCrop();
                    break;
               case 'preenchimento':
                    $this->resizeFill();
                    break;
               case 'proporcional': 
                   // proportionally unfilled
                    $this->resizeProportionl();
                    break;      
               default:
                    $this->resizeSimple();
                    break;
          }

          // update image dimensions
          $this->height     = $this->new_heigth;
          $this->widht     = $this->new_widht;

          return $this;
     } // end resize

     /**
      * Resize image, standard mode without crop or fill
      * (distorting case has passed both height and width)
      * @return void
      **/
     private function resizeSimple()
     {
          // create temporary destination image
          $this->img_temp = imagecreatetruecolor( $this->new_widht, $this->new_heigth );

          imagecopyresampled( $this->img_temp, $this->img, 0, 0, 0, 0, $this->new_widht, 
          $this->new_heigth, $this->widht, $this->height );
          $this->img     = $this->img_temp;
     } // end resize()

     /**
      * Add image to the background color
      * @return void
      **/
     private function fillImage()
     {
          $color_background = color_background();
          
          imagefill( $this->img_temp, 0, 0, $color_background );
     } // end fillImage

     /**
      * Resize image whitout crop, propotionaly
      * filling empty space with specified RGB color
      * @return void
      **/
     private function resizeFill()
     {
          // create temporary image path
          $this->img_temp = imagecreatetruecolor( $this->new_widht, $this->new_heigth );

          // add backgroung color to new imaage
          $this->fillImage();

          // saved variables for centralization
          $dif_x = $dif_w = $this->new_widht;
          $dif_y = $dif_h = $this->new_heigth;

         /**
          * Verify height e widht
          */
          if ( ($this->widht / $this->new_widht ) > ( $this->height / $this->new_heigth ) )
          {
              $fator = $this->widht / $this->new_widht;
          } 
          else 
          {
              $fator = $this->height / $this->new_heigth;
          }

          $dif_w = $this->widht / $fator;
          $dif_h = $this->height  / $fator;

          // copia com o novo tamanho, centralizando
          $dif_x = ( $dif_x - $dif_w ) / 2;
          $dif_y = ( $dif_y - $dif_h ) / 2;

          imagecopyresampled( $this->img_temp, $this->img, $dif_x, $dif_y, 0, 0, $dif_w, $dif_h, 

          $this->widht, $this->height );
          $this->img     = $this->img_temp;
     } // end resizeFill()

     /**
      * Resize image without cutting in proportion and unfilled.
      * @return void
      **/
     private function resizeProportionl()
     {
          /**
           * Verifica height e widht proporcional.
           **/
            $ratio_orig = $this->widht/$this->height;
            if ($this->new_widht/$this->new_heigth > $ratio_orig) {
               $dif_w = $this->new_heigth*$ratio_orig;
               $dif_h = $this->new_heigth;
            } 
            else 
            {
               $dif_w = $this->new_widht;
               $dif_h = $this->new_widht/$ratio_orig;
            }

          // cria image de path temporária
          $this->img_temp = imagecreatetruecolor( $dif_w, $dif_h );
         
          // Resample
          imagecopyresampled($this->img_temp, $this->img, 0, 0, 0, 0, $dif_w, $dif_h, $this->widht,
          $this->height);
          $this->img   = $this->img_temp;
     } // fim resizeProportionl()


     /**
      * Calculate crop position
      * Indices 0 and 1 correspond to the x and y position of the crop in the image
      * The 2 indexes and 3 correspond to the size of the crop
      * @return void
      **/
     private function calculateCropPosition()
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
     } // end calculateCropPosition

     /**
      * Resize image
      * @return void
      **/
     private function resizeCrop()
     {
          // calculate crop position automaticaly
          if(!is_array($this->position_crop))
          {
<<<<<< HEAD
          	$auto=1; 
          	$this->calculateCropPosition(); 
		  		}
		  		// crop position manualy
		  		else {
		  			$auto = 0;
		  		}
=======
            $auto=1; 
            $this->calculateCropPosition(); 
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
          $this->fillImage();
          
          //inteligents arrays
          switch( $this->position_crop[ 0 ]  ){
            
            case 'left':
                            
                $this->position_x = 0;
            
            break;
            
        case 'right':
        
            $this->position_x = $this->widht - $this->new_widht;
            
        break;
            
        case 'middle':
            
            $this->position_x = ( $this->widht - $this->new_widht ) / 2;
            
        break;
            
        default:
            
            $this->position_x = $this->position_crop[ 0 ];
                
        break;
        
           }
          
           switch( $this->position_crop[ 1 ] ){
            
            case 'top':
                
                $this->position_y = 0;
            
        break;
            
        case 'bottom':
            
            $this->position_y = $this->height - $this->new_heigth;
            
        break;
            
        case 'middle':
            
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
     } // end resizeCrop

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
      * @return Object current instance of the object, for chained method
      **/
     

     public function rotate( $graus )
     {
          $color_background = color_background();

          $this->img     = imagerotate( $this->img, $graus, $color_background );

          imagealphablending( $this->img, true );
          imagesavealpha( $this->img, true );

          $this->widht = imagesx( $this->img );
          $this->height = imagesx( $this->img );

          return $this;
     } // fim rotate

     /**
      * add text in the image
      * @param String $text text to be added
      * @param Int $size font size
      * @param Int $x x position text in the image
      * @param Int $y y position text in the image
      * @param Array/String $color_background array whith RGB colors or string with hexadecimal colors
      * @param Boolean $truetype true for font truetype, false for system font
      * @param String $fonte font name truetype to use
      * @return void
      **/
     public function subtitle( $text, $size = 5, $x = 0, $y = 0, $color_background = '', 
        $truetype = false, $fonte = '' )
     {
          $cor_text = imagecolorallocate( $this->img, $this->rgb[0], $this->rgb[1], $this->rgb[2] );

          /**
           * Sets size of the caption for fixed positions and legend background
           **/
          if( $truetype  === true )
          {
               $dimensions_text     = imagettfbbox( $size, 0, $fonte, $text );
               $widht_text          = $dimensions_text[4];
               $height_text          = $size;
          }
          else
          {
               if( $size > 5 ) $size = 5;
               $widht_text     = imagefontwidth( $size ) * strlen( $text );
               $height_text     = imagefontheight( $size );
          }

          if( is_string( $x ) && is_string( $y ) )
          {
               list( $x, $y ) = $this->calculateSubtitlePosition( $x . '_' . $y, $widht_text, $height_text );
          }

          /**
           * Create a new image to use Legend background
           **/
          if( $color_background )
          {
               if( is_array( $color_background ) )
               {
                    $this->rgb = $color_background;
               }
               elseif( strlen( $color_background ) > 3 )
               {
                    $this->hexa( $color_background );
               }

               $this->img_temp = imagecreatetruecolor( $widht_text, $height_text );
               
               $color_background = color_background();

               imagefill( $this->img_temp, 0, 0, $color_background );

               imagecopy( $this->img, $this->img_temp, $x, $y, 0, 0, $widht_text, $height_text );
          }

          if ( $truetype === true )
          {
               $y = $y + $size;
               imagettftext( $this->img, $size, 0, $x, $y, $cor_text, $fonte, $text );
          }
          else
          {
               imagestring( $this->img, $size, $x, $y, $text, $cor_text );
          }
          return $this;
     } // end subtitle

     public function color_background($color_background)
     {
        $color_background = imagecolorallocate( $this->img, $this->rgb[0], $this->rgb[1], $this->rgb[2] );
     }

    /**
     * Calculates the position of the legend according to string passed via parameter
     *
     * @param String $position predefined values(topo_esquerda, meio_centro etc.)
     * @param Integer $widht image widht
     * @param Integer $height image height
     * @return void
     **/
     private function calculateSubtitlePosition( $position, $widht, $height )
     {
          // sets X and Y to position
          switch( $position )
          {
               case 'top_left':
                    $x = 0;
                    $y = 0;
                    break;
               case 'top_center':
                    $x = ( $this->widht - $widht ) / 2;
                    $y = 0;
                    break;
               case 'top_right':
                    $x = $this->widht - $widht;
                    $y = 0;
                    break;
               case 'middle_left':
                    $x = 0;
                    $y = ( $this->height / 2 ) - ( $height / 2 );
                    break;
               case 'middle_center':
                    $x = ( $this->widht - $widht ) / 2;
                    $y = ( $this->height - $height ) / 2 ;
                    break;
               case 'middle_right':
                    $x = $this->widht - $widht;
                    $y = ( $this->height / 2) - ( $height / 2 );
                    break;
               case 'bottom_left':
                    $x = 0;
                    $y = $this->height - $height;
                    break;
               case 'bottom_center':
                    $x = ( $this->widht - $widht ) / 2;
                    $y = $this->height - $height;
                    break;
               case 'bottom_right':
                    $x = $this->widht - $widht;
                    $y = $this->height - $height;
                    break;
               default:
                    return false;
                    break;
          } // end switch position

          return array( $x, $y );
     } // end calculateSubtitlePosition

     const MAX_TRANSPARENCE_QUALITY = 100;
     const LOWER_TRANSPARENCE_QUALITY = 0;

     /**
      * add image watermark
      * @param String $image watermark image path
      * @param Int/String $x x position of the brand in the picture or constant for markFixed()
      * @param Int/Sring $y y position of the brand in the picture or constant for markFixed()
      * @return Boolean true/false depending on the result of the operation
      * @param Int $alpha alpha value (0-100)
      *                 -> using alpha, the imagecopymerge function does not preserve
      *                 -> the native alpha PNG
      * @return Object current instance of the object, for chained method
      **/
     public function mark( $image, $x = 0, $y = 0, $alpha = MAX_TRANSPARENCE_QUALITY)
     {
          // create a temporary image for merge
          if ( $image ) {
               if( is_string( $x ) && is_string( $y ) )
               {
                    return $this->markFixed( $image, $x . '_' . $y, $alpha );
               }
               $pathinfo = pathinfo( $image );
               switch( strtolower( $pathinfo['extension'] ) )
               {
                    case 'jpg':
                    case 'jpeg':
                         $whatermark = imagecreatefromjpeg( $image );
                         break;
                    case 'png':
                         $whatermark = imagecreatefrompng( $image );
                         break;
                    case 'gif':
                         $whatermark = imagecreatefromgif( $image );
                         break;
                    case 'bmp':
                         $whatermark = imagecreatefrombmp( $image );
                         break;
                    default:
                         trigger_error( 'Arquivo de mark d\'água inválido.', E_USER_ERROR );
                         log_it("Invalid watermark file!");
                         return false;
               }
          }
          else
          {
               return false;
          }
          // dimensões
          $mark_w     = imagesx( $whatermark );
          $mark_h     = imagesy( $whatermark );
          // retorna imagens com mark d'água
          if ( is_numeric( $alpha ) && ( ( $alpha > LOWER_TRANSPARENCE_QUALITY ) && 
            ( $alpha < MAX_TRANSPARENCE_QUALITY ) ) ) 
          {
               imagecopymerge( $this->img, $whatermark, $x, $y, 0, 0, $mark_w, $mark_h, $alpha );
          } 
          else 
          {
               imagecopy( $this->img, $whatermark, $x, $y, 0, 0, $mark_w, $mark_h );
          }
          return $this;
     } // fim mark

     /**
      * add image watermark, with fixed values
      * @param String $image image path with whatermark
      * @param String $position position / orientation fixed watermark
      * @param Int $alpha value for transparency (0-100)
      * @return void
      **/
     private function markFixed( $image, $position, $alpha = MAX_TRANSPARENCE_QUALITY)
     {

          // watermark size
          list( $mark_w, $mark_h ) = getimagesize( $image );

          // sets X and Y to position
          switch( $position )
          {
               case 'top_left':
                    $x = 0;
                    $y = 0;
                    break;
               case 'top_center':
                    $x = ( $this->widht - $mark_w ) / 2;
                    $y = 0;
                    break;
               case 'top_right':
                    $x = $this->widht - $mark_w;
                    $y = 0;
                    break;
               case 'middle_left':
                    $x = 0;
                    $y = ( $this->height / 2 ) - ( $mark_h / 2 );
                    break;
               case 'middle_center':
                    $x = ( $this->widht - $mark_w ) / 2;
                    $y = ( $this->height / 2 ) - ( $mark_h / 2 );
                    break;
               case 'middle_right':
                    $x = $this->widht - $mark_w;
                    $y = ( $this->height / 2) - ( $mark_h / 2 );
                    break;
               case 'bottom_left':
                    $x = 0;
                    $y = $this->height - $mark_h;
                    break;
               case 'bottom_center':
                    $x = ( $this->widht - $mark_w ) / 2;
                    $y = $this->height - $mark_h;
                    break;
               case 'bottom_right':
                    $x = $this->widht - $mark_w;
                    $y = $this->height - $mark_h;
                    break;
               default:
                    return false;
                    break;
          } // end switch position

          // create brand
          $this->mark( $image, $x, $y, $alpha );
          return $this;
     } // end markFixed

    /**
      * Apply advanced filters to the brightness, contrast, pixelate, blur
      * Requires GD compiled with the imagefilter function ()
      * http://br.php.net/imagefilter
      * @param String $fillter constant / filter name
      * @param Integer $quantity number of times the filter should be applied
      *            used in blur, edge, emboss, and pixel draft
      * @param $arg1, $arg2 e $arg3 - see function manual imagefilter
      * @return Object current instance of the object, for chained method
     **/
    public function fillters( $fillter, $quantity = 1, $arg1 = NULL, $arg2 = NULL, $arg3 = NULL, $arg4 = NULL )
    {
         switch( $fillter )
         {
             case 'blur':
                if( is_numeric( $quantity ) && $quantity > 1 )
                {
                    for( $i = 1; $i <= $quantity; $i = $i + 1 )
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
                if( is_numeric( $quantity ) && $quantity > 1 )
                {
                    for( $i = 1; $i <= $quantity; $i = $i + 1 )
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
                if( is_numeric( $quantity ) && $quantity > 1 )
                {
                    for( $i = 1; $i <= $quantity; $i = $i + 1 )
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
                if( is_numeric( $quantity ) && $quantity > 1 )
                {
                    for( $i = 1; $i <= $quantity; $i = $i + 1 )
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
                if( is_numeric( $quantity ) && $quantity > 1 )
                {
                    for( $i = 1; $i <= $quantity; $i = $i + 1 )
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
                if( is_numeric( $quantity ) && $quantity > 1 )
                {
                    for( $i = 1; $i <= $quantity; $i = $i + 1 )
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
                if( is_numeric( $quantity ) && $quantity > 1 )
                {
                    for( $i = 1; $i <= $quantity; $i = $i + 1 )
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
    } // end fillters
    
    
    /**  
     *Adds the best filter to sharpen the images
     *Use GD image objects 
     **/
    function imagesharpen() {
    
        $quality = array(
            array(-1, -1, -1),
            array(-1, 16, -1),
            array(-1, -1, -1),
        );
    
        $division = array_sum(array_map('array_sum', $quality));
        $offset = 0; 
        imageconvolution($this->img, $quality, $division, $offset);
        
        return $this;
    }   
    
    const MAX_IMAGE_QUALITY = 100;

     /**
      * return output to screen or file
      * @param String $path path and file name to be created
      * @param Int $quality image quality in the case of JPEG (0-100)
      * @return void
      **/
     public function save( $path='', $quality = MAX_IMAGE_QUALITY )
     {
          // target file data
          if ( $path )
          {
               $pathinfo               = pathinfo( $path );
               $dir_path          = $pathinfo['dirname'];
               $extension_path     = strtolower( $pathinfo['extension'] );

               // validate directory
               if ( !is_dir( $dir_path ) )
               {
                    trigger_error( 'Invalid or absent path!', E_USER_ERROR );
                    log_it("Invalid or absent path!");
               }
          }

          if ( !isset( $extension_path ) )
          {
               $extension_path = $this->extension;
          }

          switch( $extension_path )
          {
               case 'jpg':
               case 'jpeg':
               case 'bmp':
                    if ( $path )
                    {
                         imagejpeg( $this->img, $path, $quality );
                    }
                    else
                    {
                         header( "Content-type: image/jpeg" );
                         imagejpeg( $this->img, NULL, $quality );
                         imagedestroy( $this->img );
                    }
                    break;
               case 'png':
                    if ( $path )
                    {
                         imagepng( $this->img, $path );
                    }
                    else
                    {
                         header( "Content-type: image/png" );
                         imagepng( $this->img );
                         imagedestroy( $this->img );
                    }
                    break;
               case 'gif':
                    if ( $path )
                    {
                         imagegif( $this->img, $path );
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

     } // end save

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
