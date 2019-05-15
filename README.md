
Lookup phone numbers from hlrlookup.com


Install
----------------
```bash
composer require buibr/hlrlookup
```
```bash
"buibr/hlrlookup": "dev-master"
```

Usage Single Lookup
----------------
```
use buibr\HLR\Single;

$config = new buibr\HLR\HlrApi(['apikey'=>'','password'=>'']);
$lookup = new Single( $config );
$object = $lookup->check('38971789062');
```

Usage Bulk Lookup
----------------
```
use buibr\HLR\Bulk;

$config = new HlrApi(['apikey'=>'','password'=>'']);
$lookup = new Bulk( $config );

$batch      = $lookup->submit(true, ['38971789062', '38971789062', '38971789062']);

while(true){

    $status     = $lookup->status($batch);

    if($status->getStatus() === 'complete'){
        $download   = $lookup->download($batch);

        foreach($download->getData() as $record) {
            ....
        }

        break;
    }

    sleep(1);
}
```