[![Build Status][ico-build]][link-build]
[![Code Quality][ico-cq]][link-cq]
[![Code Coverage][ico-cc]][link-cc]

# NiceDuration
Converts a duration in seconds into something human readable

## Usage
It's pretty simple. You feed it a bunch of seconds, it returns a formatted string.

```PHP
<?php
$duration = 1364.14;

$nd = new \NiceDuration\NiceDuration($duration);

$nd->format(); // Returns "22:44.140"

// A cutoff for fractions can be set (in seconds).
// Only durations below the cutoff will include fractions.
$nd->setFractionCutoff(600);

$nd->format(); // Returns "22:44"
```

## Testing

```bash
$ phpunit
```

## Licence
This code is released under the MIT Licence (MIT). Please refer to [LICENCE.md](LICENSE.md) for details.

## Note
NiceDuration *does not* do rounding. This is on purpose. Since if e.g. 0.7 seconds have passed, a full second hasn't, hence truncating makes more sense than rounding in this context.

[ico-build]: https://img.shields.io/travis/lillesvin/NiceDuration/master.svg?style=flat-square
[ico-cq]: https://img.shields.io/scrutinizer/g/lillesvin/NiceDuration.svg?style=flat-square
[ico-cc]: https://img.shields.io/scrutinizer/coverage/g/lillesvin/NiceDuration.svg?style=flat-square

[link-build]: https://travis-ci.org/lillesvin/NiceDuration
[link-cq]: https://scrutinizer-ci.com/g/lillesvin/NiceDuration
[link-cc]: https://scrutinizer-ci.com/g/lillesvin/NiceDuration/code-structure

