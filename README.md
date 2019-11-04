This is just another fork from the repository:
mgdev/responsive-wedding

The main differences are the PHP and SQL development for the guest management system.
It allows to register your guest, let them retrieve their invitation and confirm
the attendance online. Also select their preferrred food.
There is also a small makefile to speed up the Sync process.

For testing it can be deployed locally using XAMPP or similar.

TODOs -Future work:\
PHP-to-email connection to send the invitations automatically.\
Playlist suggestion.\
Bugfix.\
Backend improvements.

Follow these steps for a fast local installation of the website:

1. I decided to use the XAMPP package to host locally.
   Download and install in your computer.
   https://www.apachefriends.org/de/download.html

2. After installing run XAMPP -> Manage Servers -> Start All.\
   If SQL Server does not start you might need to go to a terminal an type:\
   ,,sudo service mysql stop"\
   Go to your local installation path. For Linux: /opt/lampp/htdocs/ \
   The file 'index.php' is the main landing in your localhost. As default
   it points to the dashboard application, later you can change it to point to your site.

3. Grant group permissions to use /htdocs/ folder.\
   Go to a terminal and type:\
   ,,sudo chmod g+rwx /opt/lampp/htdocs/"

4. Use the makefile to create the new /html/ directory and copy all files
   on the localhost. e.g. /opt/lampp/html -You may need to manually update line 26 of the Makefile-
   In a terminal go to the place where you downloaded the project and type:\
   make clean && make dirs && make

5. Import your databse using the interface ,,Import / Export Database on XAMPP phpMyAdmin"\
   Import using the provided file: db_dump.sql

6. Open your web browser and type 'http://localhost/html/'

7. Manage your invitations typing 'http://localhost/html/php/menu.php'

I guess no one is going to reuse this code and therefore I will not
spend much effort in a detailed documentation. In such a case, you can
always drop an email!

![Preview](https://github.com/rocadura/responsive-wedding/blob/master/Prev_1.png?raw=true)
![Preview](https://github.com/rocadura/responsive-wedding/blob/master/Prev_2.png?raw=true)
![Preview](https://github.com/rocadura/responsive-wedding/blob/master/Prev_3.png?raw=true)
![Preview](https://github.com/rocadura/responsive-wedding/blob/master/Prev_4.png?raw=true)
![Preview](https://github.com/rocadura/responsive-wedding/blob/master/Prev_5.png?raw=true)
![Preview](https://github.com/rocadura/responsive-wedding/blob/master/Prev_6.png?raw=true)
![Preview](https://github.com/rocadura/responsive-wedding/blob/master/Prev_7.png?raw=true)
![Preview](https://github.com/rocadura/responsive-wedding/blob/master/Prev_8.png?raw=true)



responsive-wedding
------------------

An HTML5 responsive design using jquery waypoints & scroll-to for a pleasant single-page navigation. This template makes use of media queries and scales well for all mobile form-factors.

A live demo can be viewed at:

   http://sarahlovesbradley.com

========

![Preview](https://github.com/bmgdev/responsive-wedding/blob/master/preview.png?raw=true)

## LICENSE

(The MIT License)

Copyright © Scal.io, LLC [Bradley Greenwood](http://github.com/bmgdev/)

Permission is hereby granted, free of charge, to any person obtaining a
copy of this software and associated documentation files (the "Software"),
to deal in the Software without restriction, including without
limitation the rights to use, copy, modify, merge, publish, distribute,
sublicense, and/or sell copies of the Software, and to permit persons
to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
