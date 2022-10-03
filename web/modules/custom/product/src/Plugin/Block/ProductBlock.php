<?php

namespace Drupal\product\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

/**
 * Provides a 'product' block.
 *
 * @Block(
 *   id = "product_detail_block",
 *   admin_label = @Translation("Product detail block"),
 *   category = @Translation("Product detail block")
 * )
 */

class ProductBlock extends BlockBase {

   /**
   * {@inheritdoc}
   */

   public function build() {

      $qrCode = new QrCode('https://www.google.com/');

      // Save black on white PNG image 100 px wide to filename.png. Colors are RGB arrays.
      $output = new Output\Png();
      $data = $output->output($qrCode, 100, [255, 255, 255], [0, 0, 0]);
      file_put_contents('filename.png', $data);

      // Echo a SVG file, 100 px wide, black on white.
      // Colors can be specified in SVG-compatible formats
      $output = new Output\Svg();
      echo $output->output($qrCode, 300, 'white', 'black');

   }
   
}