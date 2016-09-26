<?php
session_start();
 
$codigoCaptcha = substr(md5(time()),0,6);
$_SESSION["captcha"] = $codigoCaptcha;
$imagemCaptcha = imagecreatefrompng("fundocaptcha.png");
$fonteCaptcha = imageloadfont("anonymous.gdf");
$cor = rand(0,500);
$corCaptcha = imagecolorallocate($imagemCaptcha,$cor,0,$cor);

imagestring($imagemCaptcha,$fonteCaptcha,15,5,$codigoCaptcha,$corCaptcha);
header("Content-type: image/png");
imagepng($imagemCaptcha);
imagedestroy($imagemCaptcha);
?>