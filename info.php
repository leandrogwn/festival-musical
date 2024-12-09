<?php
phpinfo();

$env = $_ENV[ 'APPLICATION_ENV' ];
if ( $env !== false ) {
    echo "APPLICATION_ENV está definida como: $env";
} else {
    echo 'APPLICATION_ENV não está definida';
}
?>