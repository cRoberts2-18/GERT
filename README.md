# GERT

with the full change the system now functions slightly differently

In order to access the original site which is now in the OldGERT folder you will instead have to go to http://18.169.22.165/GERT/OldGERT/GertHome.php. if you want to edit this version then you will be pulling to the VM using "sudo ./pull.sh"

for the new system that uses flask, the main python controller gert.py should be edited to accomodate the addition of new pages. flask doesnt use .php files so we will have to install a python or flask mysql module to recreate the login system. other than this, any jQuery that runs back end php functions should function correctly although i havent tested them yet and they may need to be changed slightly idk

to access the python page just to to http://18.169.22.165/gert/ and in order to change this page you will be pulling using "sudo ./pullpy.sh". this should update the page but if it doesnt the just do "sudo systemctl restart apache2". 

If when adding to or editing the python page you get errors "sudo nano /var/log/apache2/error.log" opens the error log

# UPDATE

gert.py api call now takes from the gert home page mostly. so the dataset you have made selectable on the webiste doesnt seem to have the 4 variables we are giving them to select. Due to this I left it as the one you had in the api call in the python script orignially. that dataset doesnt have carbon dioxide so you'll get an error if you select that one but you can do the other three and they work fine even if you choose more than one. the timeframe on the datasets we allow them to select needs to be specified somewhere as if you have the wrong timeframe youll get an error with no explanation. for the api call though you can stick variables in so changing the current dataset name with the variable will work once we can select a dataset that has the variables we want. filname now functions such that any file requested is saved as UserID+Filename+fileExtension where if filemame is left blank the filename is set to "Default"

# Matt (Leady) Update

The API function calls, we have changed carbon dioxide to methane as that was not possible before. Things that need adding to this function leadtime hours to have 1 - ~130 ish im sure theres a way to do this. The exat number of options we need is on the dataset website. A way to input area if they wish default is -90 +90 180 -180. Validation of the form. Also a confirm message and a success message ( when its fully downloaded) - i may do this now
A way they can see that they have done this data. A way to get specific data at specific times and area ( what patrick was doing) this uses py girb. using cams lib from MUNDI to display the data. Then its just sort of backend stuff like saving their faves and being able to look at the data they have saved.
