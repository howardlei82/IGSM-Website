<?php
define ('TTW_DEFAULT_THEME','Twenty Ten');
define ('TTW_START_THEME','Wheat');
define ('TTW_TRANS','2010-weaver');

define ('TTW','Twenty Ten Weaver');
define ('W2010','2010 Weaver');

/* need to set these for each indivitual distribution */

define ('TTW_VERSION','V1.5.4');
define ('TTW_VERSION_ID',154);

define ('TTW_THEMENAME', W2010);  /* pick one of the above two */

define ('TTW_THEMEVERSION',TTW_THEMENAME . ' ' . TTW_VERSION);
/* special case definitions */

if (TTW_THEMENAME == W2010) {    /* 2010 Weaver */
    define('TTW_IS_CHILD',false);
} else {                            /* default: TTW */
    define('TTW_IS_CHILD',true);
}

define('TTW_MULTISITE_ALLOPTIONS', true);  // Set to true to allow all options for users on multisite
?>
