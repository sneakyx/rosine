# rosine
A. Introduction
 
This program is for writing and managing offers, orders, delivery notes, invoices and payments.
It fits neatly in EGroupware and uses the EGroupware address book (no secondary addressbook nessesary).
The goal was to make it accesable by touch screen - this is why the layout is bigger than in EGroupware.
In the beginning, it was a fork of php Rechnung also known as PHP Invoice by (Edy Corak)- but it is now completly rewritten, but you can import the phpinvoice data.

See pictures: https://sourceforge.net/projects/rosin/

B. Installation

B.1. Installation via docker file -recommended
At the moment, there is just a community edition available, but soon there is also an epl version available
See https://hub.docker.com/r/sneaky/egroupware-extended/ for more information!

B.2. manual installation via zip-File:
The installation goes in 5 steps

B.2.1. Download

Usually, you have to download the files from https://github.com/sneakyx/rosine - Klick on "Clone or Download" and then on "Download ZIP"
Don't use the source forge version, it is older!
The downloaded file contains one folder "rosine-master", in this directory is another directory called "ROSInE" - everything that is in this folder, you have to copy to Your egroupware folder ( /usr/share/egroupware/rosine )- don't call the folder "ROSInE"!

B.2.2. Change for HTML5

I'm sorry, I had to do this, because my first customer wanted to use a tablet and PCs with touch screen to use the app, this is the reason my app has so big buttons- usually EGroupware doesn't work on HTML 5, so there is one file to change- The other apps aren't affected- I tested it!
nano /usr/share/egroupware/pixelegg/head.tpl
Line 1 has to be:

`<!-- BEGIN head --><!DOCTYPE html>`

Line 2 has to be:

`<html>`


Save the file (CTRL + X, Y for save)


B.2.3. Install / activate app in egroupware setup -> www.yourinstallation.com/egroupware/setup  -> setup/config admin login -> Step 4 (Manage applications) -> rosine (Install) -> Save
If there was no error, go to next step

B.2.4. Activate App for user / group

Click on "Back to user login" Login in as Administrator and enable the app
Admin -> User Accounts or User Groups
Right click on Group or User -> access control
select "... rights for applications" - klick on "+" (on the upper left side)
select "rosine" -> OK
Logout and Login Again (right user / group)
You should now see the rosine logo within the other apps.

B.2.5. Creating your templates

when You click the first time on the rosine app, the templates are created - you can find them in the same folder on your webserver than the file folder
/var/lib/egroupware/default/rosine/templates

The files there affect the whole rosine-Installation. Interesting would be to change the file
print-paperwork.html and print.css
(print.css for papersize and print-paperwork.html for adding Your own logo)
If you have problems building your own template, I can do that for you.



C. Thanks go to:

- Edy Corac for the idea of phprechnung. phprechnung was the blue print for this program
https://www.loenshotel.de/phpRechnung/

- Corvin Gröning from webmasterpro.de for the template system 
http://www.webmasterpro.de/coding/article/php-ein-eigenes-template-system.html

- Chris Coyier for the article "make an editable/printable HTML Invoice
https://css-tricks.com/html-invoice/

And, of course, EGroupware GmbH for making such a great groupware tool!
http://www.egroupware.org/
