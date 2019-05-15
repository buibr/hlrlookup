<?php 
require './vendor/autoload.php';
require './HlrException.php';
require './HlrApi.php';
require './Bulk.php';
require './objects/BulkSubmitObject.php';
require './objects/BulkStatusObject.php';
require './objects/BulkListObject.php';

use buibr\HLR\Bulk;
use buibr\HLR\HlrApi;
use buibr\HLR\objects\BulkSubmitObject;

$config = new HlrApi(['apikey'=>'K5bqsZAdSru65fOnMLjPDEcS0YFVcwSm','password'=>'5asUNv3g8t91']);
$lookup = new Bulk( $config );
// $batch  = $lookup->submit(true, ['38971789062', '38978283063', '38978225503', '37744325']);

$batch      = new BulkSubmitObject( '{"status":"OK","batchid":21529}' );

while(true){

    $status = $lookup->status($batch);
    
    if($status->getStatus() === 'complete'){
        $download   = $lookup->download($batch);

        foreach($download->getData() as $record) {
            print_r( "\n" );
            print_r( $record );
            print_r( "\n" );
        }

        break;
    }

    sleep(1);
}

print_r( "\n" );
print_r( "\n" );
print "FINISH";
// print_r( [ $batch, $status, $download] );
print_r( "\n" );
die;