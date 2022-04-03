# GERT

with the full change the system now functions slightly differently

In order to access the original site which is now in the OldGERT folder you will instead have to go to http://18.169.22.165/GERT/OldGERT/GertHome.php. if you want to edit this version then you will be pulling to the VM using "sudo ./pull.sh"

for the new system that uses flask, the main python controller gert.py should be edited to accomodate the addition of new pages. flask doesnt use .php files so we will have to install a python or flask mysql module to recreate the login system. other than this, any jQuery that runs back end php functions should function correctly although i havent tested them yet and they may need to be changed slightly idk

to access the python page just to to http://18.169.22.165/gert/ and in order to change this page you will be pulling using "sudo ./pullpy.sh". this should update the page but if it doesnt the just do "sudo systemctl restart apache2". 

If when adding to or editing the python page you get errors "sudo nano /var/log/apache2.error.log" opens the error log
