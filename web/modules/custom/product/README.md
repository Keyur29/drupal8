Module is regarding custom product content type and QR code generate. This module will work on Drupal 9 version with Olivero theme as set block to "sidebar" region of Olivero theme.

As per instruction on https://github.com/Dineshkushwaha/sph-test, used "mpdf/qrcode" library for QR code generation mentioned in link (https://packagist.org/?q=php%20qrcode&p=0) which is provided by you.

After installing Drupal 9, you need to run the following command to install "mpdf/qrcode" library :
Command : composer require mpdf/qrcode

After installing "mpdf/qrcode" library, enable "product" module.

Once the "product" module is enabled, "prodcut" content type will be created with Title, Description and image fields. Also create QR code and automatically set region "sidebar" (Olivero theme).

Create product pages.

List down the page URL/s in block configure on which QR code to be displayed.

NOTE : As of now we have set QR code for "https://www.google.com/". When user scan QR code, it will redirect to "https://www.google.com/". 

Demo site :
Site URL : https://dev-product-details-with-qr-code.pantheonsite.io/

