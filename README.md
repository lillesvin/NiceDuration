[![Build Status](https://travis-ci.org/lillesvin/NiceDuration.svg?branch=master)](https://travis-ci.org/lillesvin/NiceDuration)

# NiceDuration
Converts a duration in seconds into something human readable

## Usage
It's pretty simple. You feed it a bunch of seconds, it returns a formatted string.

```PHP
<?php
// Minutes, seconds and miliseconds
$duration = (60 * 22) + 44.14; // 22 minutes, 44.14 seconds
$nd = new \NiceDuration\NiceDuration($duration);
$nd->format(); // Returns "22:44.140"

// Hours, minutes, seconds and miliseconds
$duration = (3600 * 8) + (60 * 42) + 39.1466667; // 8 hours, 42 minutes, 39.1466667 seconds
$nd = new \NiceDuration\NiceDuration($duration);
$nd->format(); // Returns "08:42:39.146"

// Without fractions
$duration = (3600 * 8) + (60 * 42) + 39.1466667; // 8 hours, 42 minutes, 39.1466667 seconds
$nd = new \NiceDuration\NiceDuration($duration);
$nd->setFractionCutoff(0); // Durations below this threshold will not have fractions returned
$nd->format(); // Returns "08:42:39"
```

## Note
NiceDuration *does not* do rounding. This is on purpose. Since if e.g. 0.7 seconds have passed, a full second hasn't, hence truncating makes more sense than rounding in this context.
