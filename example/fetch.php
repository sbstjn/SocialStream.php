<?php

// Set default timezone
date_default_timezone_set('UTC');

// Load SocialStreams.php
require_once dirname(__FILE__) . '/../SocialStream.php';

// Initialize and configure SocialStream
$stream = new SocialStream();
$stream->configure('pinboard',      'user:token');
$stream->configure('lastfm',        'user', 'token');
$stream->configure('foursquare',    'token');
$stream->configure('instagram',     'userid', 'token');
$stream->configure('twitter',       'username', 'key', 'secret', 'key', 'token');
$stream->configure('static:first',  dirname(__FILE__) . '/static-1.yml');
$stream->configure('static:second', dirname(__FILE__) . '/static-2.yml');

// Show data
print_r($stream->get());
