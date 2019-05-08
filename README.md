<h1>hlrlookup.com api for checking phone numbers.</h1>


Install
----------------
```bash
composer require burhani/hlrlookup
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
$status     = $lookup->status($batch);
$download   = $lookup->download($batch);

foreach($download->getData() as $record) {
    ....
}

```