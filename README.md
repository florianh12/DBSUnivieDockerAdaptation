# DBSUnivieDockerAdaptation
This is the administrative Website of the Panvican Union, for Unionemployees. Only trusted administrators have access to this internal website, that keeps track of the Panvican governments human (and alien) resources. Vidra Vidris!

(Database project for the University of Vienna [third Semester of Bachelor studies], went offline because it was hosted over university database and server and access to database was revoked [probably account deleted after finishing course])

## Setup
In order to start the database, go into the project's main directory and command docker to compose up your project.<br>(This project was developed on Linux, you might have to change some filepaths in order for it to work on Windows.)

In order to deploy the java-Code download ojbdc11.jar from this website: "https://download.oracle.com/otn-pub/otn_software/jdbc/218/ojdbc11.jar" (direct download-link) <br>
If that doesn't work, try it from this link: "https://www.oracle.com/database/technologies/appdev/jdbc-downloads.html".
<br>
Next download Intellij from the official Website and install it (direct database Connections only with Intellij Ultimate [free for university students]).
<br>
Then create a new java Project, go to File/Project Structure, choose Modules in the newly opened window, click the right plus-button, choose jars or directories, 
choose your downloaded ojbdc11.jar-file from your filesystem, click ok and/or apply and close the window.
<br>
To create your tables, click on the Database button on the top right of the Intellij-window (Ultimate), click on the plus-button of the window, hover over Data Source 
and choose oracle on the popup menu. 

Enter the following connection-string (under URL) into the new window: "jdbc:oracle:thin:@localhost:1521:FREE" 

Enter your database-username and password, default (generated on startup of database, inf nonexistent):
 - Username: GALACTICUNIONDBUSER
 - Password: securepassword
 
Next click on Test Connection and press apply and/or ok on success. If the test fails check your details.

Then take all the files in the java and sql folder and copy or transfer them into the src-folder of your Intellij-Project. 
<br>
Open the "create.sql" file, select the dropdown menu of "\<data source\>" and select your database, as well as the schema for your database-user, execute all sql-queries by going into line 0, character 0, press the left play-button and 
choose the option that selects all queries and click it. 
<br>
Click the checkmark to commit the changes, go into the Main.java file and press the top right playbutton.
After the programm terminates, your database should have all required tables and be populated with random generated data.
<br>

The php-Code should get automatically deployed. Since docker reads the data live from ypur filesystem, it is possible to change the code without needing to redeploy the docker container.
If you go to the website: "http://localhost:8080" 
you will be able to see that the website works, if you followed the steps above.

To LogIn on the website for the first time use:
 - Username: "admin1"
 - Password: "1234"