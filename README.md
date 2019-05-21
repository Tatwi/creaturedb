# Tarkin's Revenge Creature Database
This is a SQL database driven web page that allows players to view and gather infomration about the various animals on the Tarkin's Revenge server. We felt it was neccasary to create this user friendly tool, due to the vast amount of updates and improvements that we've made to the creatures on Tarkin's Revenge.  

[Visit the live site here!](http://creature.tarkinswg.com/)  

## Development Status

*May 21st, 2019*  
The software is functionally complete, however I have not yet finished taking pictures of all the critters. Creature images will be added in batches over time, to the maximum extent of my sanity.  

## Requirements

- SQL compatible database server (such as MariaDB).
- Web server with PHP7 and the SQL addon for PHP (php7.0-mysql package in Debian).
- Created using Devuan Linux 2.0, Apache 2.4.25-3, PHP 7.0.33, Geany 1.33, GIMP 2.8.22

## Credits

- **Programming, Database, Design, Graphics:** [R. Bassett Jr. (Tatwi)](https://github.com/Tatwi/)
- **Spreadsheet (Lua -Excel):** [stacy19201325 (Liakhara)](https://github.com/stacy19201325)
- **Graphics:** [Skolten](https://tarkinswg.com/index.php?/profile/7-skolten/)
- **Database:** Generated from an Excel spreadsheet using [SQLizer](https://sqlizer.io)

## Installation Instructions

- Install your operating system, web server, and database software. Add PHP 7 and its MYSQL addon, as noted in the requirements section.  
- Setup your database. This example is valid for 10.1.38-MariaDB for Debian Linux.  

In a terminal type:  

sudo mysql_secure_installation  

Say "yes" to all the prompts and set the root user password. This initialized MYSQL (on a Debian-based system).  

In a terminal type:  

echo 'CREATE DATABASE creatures;' | sudo mysql -uroot -p123456  

Where -p123456 is the password you set for the root user. This creates the database.  

In a terminal type:  

echo 'GRANT ALL ON *.* TO `youLocalUserName`@`localhost` IDENTIFIED BY "123456";' | sudo mysql -uroot -p123456  

Where youLocalUserName is your Linux user account and 123456 is your password. This grants your Linux user account access to the database.  

In a terminal type:  

mysql -uMyName -p123456 -e source -e Tarkin_Creatures.sql  

Finally, this populates the database with the creature data.  

- Create a new directory on your website where the page will be hosted, such as creaturedb. This will show to the outside world as mywebpage.com/creaturedb/  

- Download this repository, extract it to the creaturedb directory you made above, and edit the dbinfo.php file so that it contains your linux user name and your *database* password. 

- **Extra:** If you are concerned about the security of your SQL database and you're using an Apache web server, you can move the dbinfo.php file to a directory called "include", and change the path to it in all the files where it is referenced from  

<?php include("dbinfo.php"); ? 

to   

<?php include("include/dbinfo.php"); ? 

After that, add a file called .htaccess inside the include directory that contains the following code to prevent outside users from accessing anything in the include directory  

Deny from all

If you're using a different web server, you may wish to look into how it accomplishes the same task. I didn't do it this way by default, because some folks don't use Apache and it's not strictly necessary for the software to function.  

Provided the file permissions are all correct for your web server and so forth, the Creature Database will now be up and running!

## How it Works

The software in this repository is a web front end for a MYSQL database. The pages are built using PHP, which is a server side scripting language that is used to build web pages dynamically when the user requests them. The PHP script works does its work on the server and then sends the result to the user as a normal, complete HTML based web page. This is super handy, because it allows for the automatic generation of content that would otherwise be extremely repetitious or that could be taxing on the end user's computer or Internet connection if done on their end using on JavaScript.  

The Creature Database is made up of the following 17 web pages:  

- **index.php**: The main page, which is put together using many smaller PHP files simply for the sake of simplicity when creating/maintaining the software.
- **creaturepage.php:** This is the "hockey card" page for the creatures. It shows statistics and an image of the creature in question, which it pulls from the SQL database based on the creature's name.
- **advsearch-output.php:** Initiated from the form at the bottom section of the main page, the Advance Search results are generated on this page. There are some design elements that are unique to this page in order to accommodate extremely wide search result tables.
- **sortbyletter.php:** On the sidebar of all pages (except advsearch-output.php), there are links that will show the user all the creatures that begin with a single letter of the alphabet. This is the page that generates those results, based upon the letter chosen.
- **sortbyplanet.php:** This page the same as the one that sorts by letter of the alphabet, only it sorts the creatures by the planet they live on instead.
- **a01.php to a012.php:** Each of these 12 pages handles the generation of an answer to the corresponding "quick question" on the main page. Having a separate file for each answer makes it much easier to create/maintain the software, because you're only dealing one logic block at time.  

The remaining PHP files are those that are used to build the pages listed above. Here is a description for each:  

- **dbinfo.php:** This is where the SQL database credentials are stored. It is injected into the top of every page that performs a query.
- **design-top.php:** Contains the HTML, style sheet, JavaScript, sidebar, title image, and site title that is the starting point (the "top") of every page (except advsearch-output.php, which has its own custom layout that is wider and excludes the sidebar).
- **design-sidebar.php:** The sidebar is injected into pages inside the design-top.php file so that every page has the handy links on the right side of the main content box. 
- **design-bottom.php:** This is the final file to be used when building the page. It contains the closing tags for the main content div, as well as the html body and and the footer message.  

In addition to the above files, the following are also used to display the Creature Database:  

- **style.css:** The Cascading Style Sheet that handles the looks and layout of the page, baring a few over-rides in some of the php files.
- **img/bg.jpg:** Site background image.
- **img/btn.png:** Button background image.
- **img/hambar.png:** Stylized background some data on the creature information page.
- **img/texture.png:** Background for the title bars and questions.
- **img/title.png:** Main title graphic for the website.
- **img/titlebar.png:** The background image for the page headings, such as Quick Questions and Advanced Search.
- **img/creatures/default.jpg:** This image is loaded should a picture of a creature can not be found.
- **img/creatures/*.jpg:** There is image one file per creature, with each file having a name that corresponds to the creature name as stored in the database, such as dwarf_gronda.  

When the user visits the site, the server runs the index.php file which in turn runs each of the above noted files (that build the page which gets sent to the end user) in the following order:  

1. design-top.php  
2. design-sidebar.php (from within design-top.php)  
3. q01.php  
4. q02.php  
5. q03.php  
6. q04.php  
7. q05.php  
8. q06.php  
9. q07.php  
10. q08.php  
11. q09.php  
12. q010.php  
13. q011.php  
14. q012.php  
15. advsearch-input.php  
16. design-bottom.php  

Beyond that, the functionality of the site is really just a matter of:  

1. Collecting user input by way of "forms" (drop downs and buttons).
2. Translating said input into a SQL query.
3. Connecting to the SQL database, performing the query, and saving the results.
4. Displaying the results to the user, most often in a simple html table.  

Form data is "passed into" the file that handles making the query and displaying the results by way of variables with names such as, $_POST["My_Variable"]. Links that open new pages pass their variables as URL arguments, such as creaturepage.php?argument1=sharnaff. The logic within those pages then uses the data passed to them to generate the SQL query and display the results. I tried my best to make the code as readable, commented, and structured as possible so it will hopefully make sense (my one regret is not using camelCase for all the variable name lol...).  

## Updating the Database

There are two ways to look at this, one being that you can do all of your editing to the database directly using a [MYSQL editor](https://www.mysql.com/products/workbench/), and the other being you edit the spreadsheet and use SQLizer to generate a new SQL insert script. Personally, I would use a MYSQL editor, because it allows me to modify/backup/restore the database without the use of a third party site, however I understand that may not be everyone's preferred work environment. With that in mind, here are the steps to update the database.  

1. Make your changes to the Tarkin_Creatures.xlsx spreadsheet.  
2. Convert the spreadsheet to a new Tarkin_Creatures.sql insert script using [SQLizer](https://sqlizer.io). If the SQLizer site is no longer available, search for something else does the same thing.  
3. Copy the new Tarkin_Creatures.sql file to the server using your normal method for putting files on the server.  
4. Open a command line and use the following command to run the script. It will update any existing records that have changed, as well as adding new records, however **it will not remove any existing records** (that you need to do using a manually generated SQL script, with DELETE FROM entries like the ones near the end of [this file](https://github.com/Tatwi/solozeroth/blob/solozeroth/sql/custom/world/2017_05_26_00_world.sql) or by using MYSQL editor).  

**mysql -uMyName -p123456 -e source -e Tarkin_Creatures.sql**  

Where -uMyName and -p123456 are your database user name and password respectively.  And that's it, your database is up to date!

## Modifying Webpages

The Creature Database website was built using the most plain and simple tools for creating dynamic web pages, PHP, SQL, JavaScript, CSS, and HTML. No fancy frameworks, libraries, etc. to confuse matters. As such, I highly recommend referring to the [W3Schools](https://www.w3schools.com) website, because it has **all** of the documentation required to understand and modify this software. When in doubt, a web search can be invaluable as well, because chances are likely that you are not the first person to ask the same question and there are several sites which are dedicated to answering programming related questions.  

That said, I designed the software to be easy to work with and as automated as possible for adding new content, such as new creatures to. To add a new creature, all you need to do is the following:  

1. Update the database with the values for the creature.   
2. Put an image for the critter in img/creatures/new_critter_name.jpg  

That's it! The database handles the rest.   

Adding new columns of data to the database is no big deal, just stick them in there under new headings, but how do you make so that the end user can interact with the new data? Consider the following example, where you've added Bio-Engineer crafting values for every creature.  

1. You would need to have a place on the website for player to search this information. How about adding a new box for it on the main page under the Advance Search box? Using the Advanced Search as an example, you'd need to add new div in the index.php file to contain it:  

```
<div class="contentbox">
	<div class="contentboxtitle"><span>Advanced Search</span></div>
	<?php include("advsearch-input.php"); ?>
</div>
```  
If you have a look at advsearch-input.php, you will find that it has all the standard bits and bobs for an HTML form and that submitting the form points to the advsearch-output.php file. Your new setup for searching the Bio-Engineer crafting data would be built the same way, just with different form content and handling of the query variables. Otherwise, it would largely be the same as the code used for the advanced search, because at the end of the day all you are really doing is  

1. Using the form input to build an SQL query.
2. Displaying the results of the query to the user in a human readable format.  

As far as adding the Bio-Engineer crafting data to the creature's "hockey card" page, that only requires some thought as to where to place it on the page and then adding the results handling in the same manner as the other data on the page. For that page the query is already configured to grab all data columns for the given creature name, so you'd really just have to put the code in to display it (using the existing code as an example of how to do so).  

## Current Screenshots

![Quick Questions](https://tatwi.files.wordpress.com/2019/05/creature_database05.png) 

![Quick Answer](https://tatwi.files.wordpress.com/2019/05/creature_database06.png) 

![Advanced Search](https://tatwi.files.wordpress.com/2019/05/creature_database04.jpg) 

## Development Screenshots

![Still in development](https://tatwi.files.wordpress.com/2019/05/creature_database01.jpg)  

![Still in development](https://tatwi.files.wordpress.com/2019/05/creature_database02.jpg)  

![Still in development](https://tatwi.files.wordpress.com/2019/05/creature_database03.jpg) 