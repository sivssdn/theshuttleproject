towards jahangirpuri is people2,waitlist2,register2
password:
paras bhattrai 11
admin sahab ashoka@123
ashoka Ashoka@123


changes made in httpd.conf
After some time poking around in the httpd.conf file I saw that there were 2 "AllowOverride" statements that needed to be set to all. (Following instructions above, I had only changed the first "AllowOverride". Here's what I did, and it worked:

In httpd.conf:
uncomment this line:
LoadModule rewrite_module modules/mod_rewrite.so
Do a Find on "AllowOverride"
Change to: AllowOverride All
Should be two "AllowOverride All" statements.

update::manage.php, remove CONFIRMED to make it fit for parker


