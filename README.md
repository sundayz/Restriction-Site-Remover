# Restriction Site Remover

## Build status
| Branch | Status | Coverage |
|:------:|:------:|:--------:|
|**master**|[![Build Status](https://travis-ci.org/sundayz/Restriction-Site-Remover.svg?branch=master)](https://travis-ci.org/sundayz/Restriction-Site-Remover)| [![Coverage Status](https://coveralls.io/repos/github/sundayz/Restriction-Site-Remover/badge.svg?branch=master)](https://coveralls.io/github/sundayz/Restriction-Site-Remover?branch=master)|
|**v2**|[![Build Status](https://travis-ci.org/sundayz/Restriction-Site-Remover.svg?branch=v2)](https://travis-ci.org/sundayz/Restriction-Site-Remover)| [![Coverage Status](https://coveralls.io/repos/github/sundayz/Restriction-Site-Remover/badge.svg?branch=v2)](https://coveralls.io/github/sundayz/Restriction-Site-Remover?branch=v2)|

## Dependencies
- PHP >= 7.1
- Composer (dependency management)
- Twig (html templates)
- Flight (php framework)
- PHPUnit (testing)

## Installing
1. Run ```composer install```.
2. Move everything to your webserver root directory.
3. Ensure that users cannot access directories outside of _/public_.
4. For _Apache_, use the following rewrite rules:
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```
_Note:_ If using vhosts, you should rewrite to ```%{DOCUMENT_ROOT}/index.php``` rather than just ```index.php```.

## Copyright
License: MIT

Read file [LICENSE](../master/LICENSE).
