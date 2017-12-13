<?php

namespace App\Helpers;
 
class SimpleImage {
   
   var $image;
   var $image_type;
 
    function load($filename) 
    {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if( $this->image_type == IMAGETYPE_JPEG ) 
        {
            $this->image = imagecreatefromjpeg($filename);
        } 
        elseif( $this->image_type == IMAGETYPE_GIF ) 
        {
            $this->image = imagecreatefromgif($filename);
        }
        elseif( $this->image_type == IMAGETYPE_PNG ) 
        {
            $this->image = imagecreatefrompng($filename);
            //$this->image = imagecreatetruecolor($this->getWidth(),  $this->getHeight());
            imageAlphaBlending($this->image, false);
            imageSaveAlpha($this->image, true);
            $black = imagecolorallocatealpha($this->image, 255, 255, 255,127);
            imagecolortransparent($this->image,$black);
        }
    }
   
    function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) 
    {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
    }
   
    function output($image_type=IMAGETYPE_JPEG) 
    {
       if( $image_type == IMAGETYPE_JPEG ) {
          imagejpeg($this->image);
       } elseif( $image_type == IMAGETYPE_GIF ) {
          imagegif($this->image);         
       } elseif( $image_type == IMAGETYPE_PNG ) {
            imagepng($this->image,NULL,9);
       }   
    }
    
    function display($filename,$resize = false) 
    {
        if(!file_exists($filename))            
            return false;
        header( 'Content-type: '.$this->image_type );
        $this->load($filename);
        if($resize)
            $this->resizeToWidth($resize);
        $this->output($this->image_type);
        imagedestroy($this->image);
        return true;
    }

    function getWidth() 
    {
       return imagesx($this->image);
    }

    function getHeight() 
    {
       return imagesy($this->image);
    }

    function resizeToHeight($height) 
    {
       $ratio = $height / $this->getHeight();
       $width = $this->getWidth() * $ratio;
       $this->resize($width,$height);
    }

    function resizeToWidth($width) 
    {
       $ratio = $width / $this->getWidth();
       $height = $this->getheight() * $ratio;
       $this->resize($width,$height);
    }

    function scale($scale) 
    {
       $width = $this->getWidth() * $scale/100;
       $height = $this->getheight() * $scale/100; 
       $this->resize($width,$height);
    }

    function resize($width,$height) 
    {
       $new_image = imagecreatetruecolor($width, $height);
       if( $this->image_type == IMAGETYPE_PNG ) 
       {
           //imageAlphaBlending($this->image, false);
            //imageSaveAlpha($this->image, true);
            $black = imagecolorallocatealpha($this->image, 255, 255, 255,127);
            imagealphablending( $new_image, false );
            imagecolortransparent($this->image,$black);
            imagesavealpha( $new_image, true );
       }
       imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
       $this->image = $new_image;   
    }      
}
?>