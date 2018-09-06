# ToDo
ToDo App Example for Resume.

## Note
This is an example of a simple CRUD application, there is not a significant focus on UI for this particular project. 

This is simply an example of utilization of basic MVC design principles and working with multiple programming languages.

# Installation and Setup.
In order to run the application, first download the project and place it in whichever directory you want.

## DB Setup
To setup the database, use a DB manager like [Sequel Pro](https://www.sequelpro.com/). 

In the ToDo project folder, you will notice a subfolder called **"init"**. 

Create a database in your DB manager. Then **import the ToDo_DB.sql** file to SequelPro and run it. 

This will create the necessary database structure for the application to run.

## Connect DB
Next, look for the **config.php** file in the top level of the project's folder. 

Open it up and modify the database connection settings to match the name and password for your Database manager.
 
# Running the application
To run the ToDo app, navigate to the project folder location in your terminal and run a local PHP server. 

Ex: `php -S localhost:3000`

Once the server is running, open a browser (Google Chrome recommended), and use localhost:3000 in the browser URL bar.

## Default Accounts
These are the default user accounts after importing the database SQL.

Usernames | Passwords | Emails
--------- | --------- | ------
admin | password | admin@todo.com
editor | password | editor@todo.com
user | password | user@todo.com

