# advanced-file-monitor
System Integrity Check plugin for Osclass

This plugin was initially created buy Jay, but it was abandoned after last public release 1.3 or 1.4.
Afterwards, I have took the plugin and continued it's development privately. Now, it is released for public use and it's free!

Please note that there are many ideas for improvements, but I cannot promise when they'll be implemented.
Suggestions & Contributions from other developers is welcomed.

I strongly suggest to use this plugin on powerfull or high-end servers, because scanning filesystem and calculating hashes can be intensive task for budget lowend boxes.

If you have problems installing the plugin (during which initial scan is performed for reference), please before reporting an ISSUE, enable Osclass MySQL debug log and see what error do you receive.
If you receive Error 2006 MySQL server has gone away, you have reached the timeout limit on your server (or low memory problem). In this case, you will either have to upgrade your server, or add more directories in the excluded list MANUALLY inside plugin's index.php file (~ lines 44+) BEFORE trying to install plugin again.
