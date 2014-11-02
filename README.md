# SocialStream.php

Framework for fetching recent events from Foursquare, Instagram, Last.FM, Pinboard, Twitter or local JSON files. 

## Usage

```php
$stream = new SocialStream();
$stream->configure('pinboard',      'user:token');
$stream->configure('lastfm',        'username', 'tokeb');
$stream->configure('foursquare',    'token');

print_r($stream->get());
```

## License

SocialStream.php is available under MIT License. 