<?php
class DatabaseHelper
{

    const username = 'GALACTICUNIONDBUSER'; 
    const password = 'securepassword'; 
    const con_string = '//oracle-db:1521/FREE';

    
    protected $conn;

    
    public function __construct()
    {
        try {
            //AL32UTF8 is necessary, because DB uses non-ASCII signs
            $this->conn = oci_connect(
                DatabaseHelper::username,
                DatabaseHelper::password,
                DatabaseHelper::con_string,
				'AL32UTF8'
            );


            if (!$this->conn) {
                die("DB error: Connection can't be established!");
            }

        } catch (Exception $e) {
            die("DB error: {$e->getMessage()}");
        }
    }

    public function __destruct()
    {
        oci_close($this->conn);
    }

   
    //Allrounder function, can be used to search for a specific Employee, can be used to get infos about several
    public function searchAllEmployees($employee_id, $surname, $name, $jobdescription, $type)
    {
      
        if($type != '') {

            if($employee_id !='') {

                $sql = "SELECT * FROM Unionemployee NATURAL JOIN {$type}
                    WHERE upper(EmployeeID) = '{$employee_id}'
                    AND upper(Surname) LIKE upper('%{$surname}%')
                    AND upper(FirstName) LIKE upper('%{$name}%')
                    AND upper(Jobdescription) LIKE upper('%{$jobdescription}%')
                    ORDER BY EmployeeID ASC";

            } else {

                $sql = "SELECT * FROM Unionemployee NATURAL JOIN {$type}
                WHERE upper(Surname) LIKE upper('%{$surname}%')
                AND upper(FirstName) LIKE upper('%{$name}%')
                AND upper(Jobdescription) LIKE upper('%{$jobdescription}%')
                ORDER BY EmployeeID ASC";

            }
        } else {

            if($employee_id !='') {

                $sql = "SELECT * FROM Unionemployee 
                    WHERE upper(EmployeeID) = '{$employee_id}'
                    AND upper(Surname) LIKE upper('%{$surname}%')
                    AND upper(FirstName) LIKE upper('%{$name}%')
                    AND upper(Jobdescription) LIKE upper('%{$jobdescription}%')
                    ORDER BY EmployeeID ASC";

            } else {

                $sql = "SELECT * FROM Unionemployee
                WHERE upper(Surname) LIKE upper('%{$surname}%')
                  AND upper(FirstName) LIKE upper('%{$name}%')
                  AND upper(Jobdescription) LIKE upper('%{$jobdescription}%')
                ORDER BY EmployeeID ASC";

            }

        }


        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);
        
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        oci_free_statement($statement);

        return $res;
    }

    //fetches all Zipcodes, useful to give options for adding Employees or chanigng their infos
    public function selectallZIPcodes() {
       
        $sql = "SELECT * FROM ZIPCODE ORDER BY CITY,PLANET ASC";

        $statement = oci_parse($this->conn, $sql); 

        oci_execute($statement);

        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        oci_free_statement($statement);

        return $res; 
    }

    //Gets only Soldiers, but with Name, used in addEmployeeForm and changeInfoForm to give options
    public function selectallSoldiers() {
       
        $sql = "SELECT * FROM SOLDIER NATURAL JOIN UNIONEMPLOYEE ORDER BY EMPLOYEEID ASC";

        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);

        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        oci_free_statement($statement);

        return $res; 
    }

    //Gets courts, used in addEmployeeForm and changeInfoForm to give options
    public function selectallCourts() {

        $sql = "SELECT * FROM COURT ORDER BY COURTID ASC";

        $statement = oci_parse($this->conn, $sql); 

        oci_execute($statement);

        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        oci_free_statement($statement);

        return $res; 
    }

    //Gets senates, used in addEmployeeForm and changeInfoForm to give options
	public function selectallSenates() {

        $sql = "SELECT * FROM SENATE ORDER BY SENATEID ASC";

        $statement = oci_parse($this->conn, $sql); 

        oci_execute($statement);

        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        oci_free_statement($statement);

        return $res; 
    }
    public function selectAllAdmins() {

        $sql = "SELECT USERNAME FROM Administrator ORDER BY USERNAME ASC";

        $statement = oci_parse($this->conn, $sql); 

        oci_execute($statement);

        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        oci_free_statement($statement);

        return $res; 
    }

    //gets Employee with known ID, throws Exception if ID not found, as sign of grave error within system/website, shouldn't occur
    //returns an array with result on pos 0 and employeetype on pos 1
    public function selectEmployeeByID($employee_id)
    {

       
        $sql = "SELECT * FROM UNIONEMPLOYEE NATURAL JOIN ZIPCODE NATURAL JOIN SOLDIER WHERE EMPLOYEEID = '{$employee_id}'";
       
        $statement = oci_parse($this->conn, $sql);
        
        oci_execute($statement);

        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

		oci_free_statement($statement);

		if(sizeof($res)) {

			return array($res,0);
		}


		$sql = "SELECT * FROM UNIONEMPLOYEE NATURAL JOIN ZIPCODE NATURAL JOIN JUDICIALOFFICER WHERE EMPLOYEEID = '{$employee_id}'";
        
        $statement = oci_parse($this->conn, $sql);
        
        oci_execute($statement);

        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

		oci_free_statement($statement);

		if(sizeof($res)) {

			return array($res,1);
		}


		$sql = "SELECT * FROM UNIONEMPLOYEE NATURAL JOIN ZIPCODE NATURAL JOIN POLITICIAN WHERE EMPLOYEEID = '{$employee_id}'";

        $statement = oci_parse($this->conn, $sql);
        
        oci_execute($statement);

        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        
		oci_free_statement($statement);

		if(sizeof($res)) {

			return array($res,2);
		} else {

			throw new Exception("Function Error: No Entry found!");

		}
       
    }

    //selects court with specific ID, used in details
	public function selectCourtByID($id) {

        $sql = "SELECT * FROM COURT WHERE COURTID = '{$id}'";

        $statement = oci_parse($this->conn, $sql); 

        oci_execute($statement);

        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        oci_free_statement($statement);

        return $res; 
    }

    //selects senate with specific ID, used in details
	public function selectSenateByID($id) {

        $sql = "SELECT * FROM SENATE WHERE SENATEID = '{$id}'";

        $statement = oci_parse($this->conn, $sql); 

        oci_execute($statement);

        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        
        oci_free_statement($statement);

        return $res; 
    }


    // This function creates and executes a SQL insert statement into soldier and Unionemployee 
    //using a stored procedure in order to allow multiple inserts at the same time, 
    //without potentially compromising the ID integrety between Unionemployee and Soldier
    public function insertIntoSoldier($name, $surname, $socialsecurity, $telephone, $jobdescr, $street, $house, $complex, $door, $zip, $rank, $department, $sector, $commandingofficer)
    {
       
        $sql = "BEGIN insertSoldier('{$name}', '{$surname}', '{$socialsecurity}', '{$telephone}', 
        '{$jobdescr}', '{$street}', '{$house}', '{$complex}', '{$door}', '{$zip}', 
        '{$rank}', '{$department}', '{$sector}', '{$commandingofficer}'); END;";

        $statement = oci_parse($this->conn, $sql);

        $success = oci_execute($statement) && oci_commit($this->conn);

        oci_free_statement($statement);
        return $success;
    }

    //insertIntoSoldier but instead of inserting into soldier, inserts into judicialofficer 
    public function insertIntoJudicialOfficer($name, $surname, $socialsecurity, $telephone, $jobdescr, $street, $house, $complex, $door, $zip, $jtitle, $jobexperience, $jobexperiencetime, $court)
    {

        $sql = "BEGIN insertJudicialOfficer('{$name}', '{$surname}', '{$socialsecurity}', '{$telephone}', 
        '{$jobdescr}', '{$street}', '{$house}', '{$complex}', '{$door}', '{$zip}', 
        '{$jtitle}', '{$jobexperience}', '{$jobexperiencetime}', '{$court}'); END;";

        $statement = oci_parse($this->conn, $sql);

        $success = oci_execute($statement) && oci_commit($this->conn);

        oci_free_statement($statement);

        return $success;
    }

    //insertIntoSoldier but instead of inserting into soldier, inserts into politician
	public function insertIntoPolitican($name, $surname, $socialsecurity, $telephone, $jobdescr, $street, $house, $complex, $door, $zip, $ptitle, $party, $senate)
    {

        $sql = "BEGIN insertPolitician('{$name}', '{$surname}', '{$socialsecurity}', '{$telephone}', 
        '{$jobdescr}', '{$street}', '{$house}', '{$complex}', '{$door}', '{$zip}', 
        '{$ptitle}', '{$party}', '{$senate}'); END;";

        $statement = oci_parse($this->conn, $sql);

        $success = oci_execute($statement) && oci_commit($this->conn);

        oci_free_statement($statement);

        return $success;
    }
   

    //updates entry with specified ID in Unionemployee
    public function updateEmployee($id, $name, $surname, $socialsecurity, $telephone, $jobdescr, $street, $house, $complex, $door, $zip) 
    {
        $sql = "UPDATE UNIONEMPLOYEE 
        SET SOCIALSECURITY = '{$socialsecurity}', TELEPHONENUMBER = '{$telephone}', JOBDESCRIPTION = '{$jobdescr}', 
        FIRSTNAME = '{$name}', SURNAME = '{$surname}', 
        STREET = '{$street}', HOUSENUMBER = '{$house}', 
        COMPLEXNUMBER = '{$complex}', DOORNUMBER = '{$door}', 
        ZIPCODE = '{$zip}'
        WHERE EMPLOYEEID = '{$id}'";

        $statement = oci_parse($this->conn, $sql);

        $success = oci_execute($statement) && oci_commit($this->conn);

        oci_free_statement($statement);

        return $success;
    }

    //updates entry with specified ID in soldier
    public function updateSoldier($id, $rank, $department, $sector, $commandingofficer) 
    {

        $sql = "UPDATE SOLDIER 
        SET RANK = '{$rank}', DEPARTMENT = '{$department}', ASSIGNEDSECTOR = '{$sector}', 
        COMMANDINGOFFICERID = '{$commandingofficer}'
        WHERE EMPLOYEEID = '{$id}'";

        $statement = oci_parse($this->conn, $sql);

        $success = oci_execute($statement) && oci_commit($this->conn);
        
        oci_free_statement($statement);

        return $success;
    }

     //updates entry with specified ID in judicialofficer
    public function updateJudicialOfficer($id, $jtitle, $jobexperience, $jobexperiencetime, $court) 
    {

        $sql = "UPDATE JUDICIALOFFICER 
        SET TITLE = '{$jtitle}', JOBEXPERIENCE = '{$jobexperience}', EXPERIENCETIMEUNIT = '{$jobexperiencetime}', 
        COURTID = '{$court}'
        WHERE EMPLOYEEID = '{$id}'";

        $statement = oci_parse($this->conn, $sql);

        $success = oci_execute($statement) && oci_commit($this->conn);

        oci_free_statement($statement);

        return $success;
    }

    //updates entry with specified ID in politician
    public function updatePolitican($id, $ptitle, $party, $senate) 
    {

        $sql = "UPDATE POLITICIAN 
        SET TITLE = '{$ptitle}', PARTY = '{$party}', SENATEID = '{$senate}' 
        WHERE EMPLOYEEID = '{$id}'";

        $statement = oci_parse($this->conn, $sql);

        $success = oci_execute($statement) && oci_commit($this->conn);

        oci_free_statement($statement);

        return $success;
    }


    //deletes employee in all relevant tables, needs $etype to work, $officcer can be null/''
    public function deleteEmployee($person_id, $etype, $officer)
    {

        switch ($etype) {
            case 0:

                //removes childentries from rule
                $sql = "DELETE FROM RULE WHERE EMPLOYEEID = '{$person_id}'";

                $statement = oci_parse($this->conn, $sql);

                oci_execute($statement);

                oci_commit($this->conn);

                oci_free_statement($statement);


                //Updates officers lead by soldier to be deleted to commanding offficer, 
                //if commanding officer is null, lead soldiers updated to null
                $sql = "UPDATE SOLDIER SET COMMANDINGOFFICERID = '{$officer}' WHERE COMMANDINGOFFICERID = '{$person_id}'";

                $statement = oci_parse($this->conn, $sql);

                oci_execute($statement);

                oci_commit($this->conn);

                oci_free_statement($statement);


                //removes childentries from carryout
                $sql = "DELETE FROM CARRYOUT WHERE EMPLOYEEID = '{$person_id}'";

                $statement = oci_parse($this->conn, $sql);

                oci_execute($statement);

                oci_commit($this->conn);

                oci_free_statement($statement);


                //actually delete Soldier
                $sql = "DELETE FROM SOLDIER WHERE EMPLOYEEID = '{$person_id}'";

                $statement = oci_parse($this->conn, $sql);

                oci_execute($statement);

                oci_commit($this->conn);

                oci_free_statement($statement);

                break;
                
            case 1:

                //deletes judicial officer in question
                $sql = "DELETE FROM JUDICIALOFFICER WHERE EMPLOYEEID = '{$person_id}'";

                $statement = oci_parse($this->conn, $sql);

                oci_execute($statement);

                oci_commit($this->conn);

                oci_free_statement($statement);

                break;

            case 2:

                $sql = "DELETE FROM POLITICIAN WHERE EMPLOYEEID = '{$person_id}'";

                $statement = oci_parse($this->conn, $sql);

                oci_execute($statement);

                oci_commit($this->conn);
                
                oci_free_statement($statement);
        
    }
        
        //Deletes Parent entry in Unionemployee
        $sql = "DELETE FROM UNIONEMPLOYEE WHERE EMPLOYEEID = '{$person_id}'";
        $statement = oci_parse($this->conn, $sql);


        oci_execute($statement);
		oci_commit($this->conn);
        
        oci_free_statement($statement);
    
        return 1;
    }
    public function registerUser($username, $password)
    {
        
        $sql = "INSERT INTO Administrator VALUES('{$username}', '{$password}')";

        $statement = oci_parse($this->conn, $sql); 

        $success = oci_execute($statement) && oci_commit($this->conn);

        return $success;
    }
    public function gethash($username) {
        $sql = "SELECT PWD FROM Administrator WHERE USERNAME = '{$username}'";

        $statement = oci_parse($this->conn, $sql); 

        oci_execute($statement);

        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        oci_free_statement($statement);
        if(isset($res[0]['PWD'])) {
            return $res[0]['PWD'];
        } else {
            return -1;
        }
    }

    public function deleteAdministrator($username)
    {

                $sql = "DELETE FROM Administrator WHERE USERNAME = '{$username}'";

                $statement = oci_parse($this->conn, $sql);

                oci_execute($statement);

                oci_commit($this->conn);

                oci_free_statement($statement);
                
                return 1;

    }

}
