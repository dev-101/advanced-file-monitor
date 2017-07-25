# advanced-file-monitor
System Integrity Check plugin for Osclass

This plugin was initially created buy Jay, but it was abandoned after last public release 1.3 or 1.4.
Afterwards, I have took the plugin and continued it's development privately. Now, it is released for public use and it's free!

Please note that there are many ideas for improvements, but I cannot promise when they'll be implemented.
Suggestions & Contributions from other developers is welcomed.

I strongly suggest to use this plugin on powerfull or high-end servers, because scanning filesystem and calculating hashes can be intensive task for budget lowend boxes.

If you have problems installing the plugin (during which initial scan is performed for reference), please before reporting an ISSUE, enable Osclass MySQL debug log and see what error do you receive.
If you receive Error 2006 MySQL server has gone away, you have reached the timeout limit on your server (or low memory problem). In this case, you will either have to upgrade your server, or add more directories in the excluded list MANUALLY inside plugin's index.php file (~ lines 44+) BEFORE trying to install plugin again.

# FAQ

Q: What is Advanced File Monitor plugin?
A: File System Integrity Scanner, in one sentence. Plugin will scan your files, create a "snapshot" of their signatures (not the full backup! - but, there's a nice idea :-) ), and store them for later. When the next execution cycle via CRON kicks in, it will perform another scan and do a cross-comparison with the original results from before. Needless to say, this may pose additional stress to your server, so I strongly suggest that you avoid using it on cheap hosting plans, bad hosting with low reputation, lowend VPS boxes etc. It will mostly work, but not without limits and potential problems.

Q: I cannot install it! I receive "plugin installed" flash message, but it is still in red color and not installed! What the?
A: Enable Osclass MySQL debugging and see what error you get. If it is "Error 2006", your MySQL server connection has timed-out and the plugin could not save the initial scan results during the installation procedure. You must either try to tweak MySQL server to allow longer connection time, or upgrade to a more powerful server. Another 'hack' exists to limit scan directories directly inside plugin's index.php file around line ~40, and try again.

Q: I haven't received any alert email.
A: Check your SPAM folder. Because of the huge size of emails and their structure, Google usually marks it as spam for the first time. Once you 'report' it as not spam, it should no longer end up there.

# LINKS

forum:
https://forums.osclass.org/plugins/(free-plugin)-advanced-file-monitor-file-system-integrity-scanner/
