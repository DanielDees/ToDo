# ToDo
ToDo App Example for Resume

# Installation and Setup.
In order to run the application, first download the project and place it in whichever directory you want.

To setup the database, use a DB manager like SequelPro and create a new database. In the ToDo project folder, you will notice a subfolder called "init". Import the ToDo_DB.sql file to SequelPro and run it. This will create the necessary database structure for the application to run.

Next, look for the config.php file in the top level of the project's folder. Open it up and modify the database connection settings to match the name and password for your Database manager.
 
# Running the application
To run the ToDo app, navigate to the project folder's location in your terminal and run a local PHP server. 

Ex: php -S localhost:3000

Once the server is running, simply open up a browser (Google Chrome recommended), and use localhost:3000 in the browser URL bar.

