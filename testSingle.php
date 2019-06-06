<?php 
require './vendor/autoload.php';
require './HlrException.php';
require './HlrApi.php';
require './HlrBase.php';
require './Single.php';
require './objects/SingleObject.php';

use buibr\HLR\Single;
use buibr\HLR\HlrApi;

$config = new HlrApi(['apikey'=>'xxx','password'=>'']);

$lookup = new Single( $config );
$object = $lookup->check('38971789062');

print_r( "\n" );
print_r( [$lookup->isOk(), $object->isVerified() ? 1: 0, $object, $object->getError()] );
print_r( "\n" );

die;