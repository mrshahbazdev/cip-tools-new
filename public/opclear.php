<?php
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "PHP OPcache Cleared!";
} else {
    echo "OPcache Reset function not available.";
}
