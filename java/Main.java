import java.io.*;
import java.util.*;
import java.util.random.RandomGenerator;
import java.sql.*;

public class Main {
//Instance Variables and DB Variables
    private static final RandomGenerator r = new Random();
    private static final File firstNamesFile = new File("src\\FirstNames.dat");
    private static final File surnamesFile = new File("src\\Surnames.dat");
    private static final File planetsFile = new File("src\\Planets.dat");
    private static final File streetsFile = new File("src\\Streets.dat");
    private static final File citiesFile = new File("src\\Cities.dat");
    private static final File lawtextFile = new File("src\\LawText.dat");
    private static final File deparmyFile = new File("src\\Department.dat");
    private static final File stypeFile = new File("src\\SoldierTypes.dat");
    private static final File titlesFile = new File("src\\Titles.dat");
    private static final File lawareasFile = new File("src\\LawAreas.dat");
    private static final File partiesFile = new File("src\\Parties.dat");
    private static final File pjobsFile = new File("src\\PoliticianSpecialJobs.dat");


    private static ArrayList<String> surnames = new ArrayList<>(), firstNames = new ArrayList<>(), planets = new ArrayList<>(), streets = new ArrayList<>(), cities = new ArrayList<>(), deparmy = new ArrayList<>(), depspace = new ArrayList<>(), titles = new ArrayList<>(), parties = new ArrayList<>(), pjobs = new ArrayList<>(), stype = new ArrayList<>(), lawareas = new ArrayList<>(), lawtexts = new ArrayList<>();
    private static ArrayList<Integer> soldierIDs = new ArrayList<>();
    private static Set<Integer> ZIPlist = new HashSet<>(), socialseclist = new HashSet<>(), telephonelist = new HashSet<>();
    private static final String database = "jdbc:oracle:thin:@localhost:1521:FREE";
    private static final String user = "GALACTICUNIONDBUSER";
    private static final String pass = "securepassword";

    private static Connection con;
    private static PreparedStatement ZIPcode, employee, soldier, justice, politician, court, senate, rule, mission, carryout, law, currUID, currCID, currSenID, currMID, existingZIPcodes, existingSocialSec, existingtelephone, admin, curradminct;
    private static Integer UnionID, CID, SenID, MissionID, adminct;
    //Generate Functions
    public static int generateInteger() {
        return r.nextInt(999999999);
    }

    public static String generateFirstName() {
        return firstNames.get(r.nextInt(firstNames.size()));
    }

    public static String generateSurname() {
        return surnames.get(r.nextInt(surnames.size()));
    }

    public static String generatePlanet() {
        return planets.get(r.nextInt(planets.size()));
    }

    public static String generateStreet() {
        return streets.get(r.nextInt(streets.size()));
    }
    //generates a list with sz of 3, but 2o of 3 can be nullvalues
    public static List<Integer> generateAddrNr() {
        List<Integer> tmp = new ArrayList<>();
        tmp.add(r.nextInt(1, 999));
        if(r.nextInt(0, 100) < 60) {
            if (r.nextInt(0, 100) > 60)
                tmp.add(r.nextInt(1, 50));
            else
                tmp.add(null);
            tmp.add(r.nextInt(1, 1000));
        } else {
            tmp.add(null);
            tmp.add(null);
        }
        return tmp;
    }
    public static String generateCity() {
        return cities.get(r.nextInt(cities.size()));
    }
    @SuppressWarnings("unchecked")
    public static ArrayList<String> getListFromFile(File f) throws IOException, ClassNotFoundException {
        ObjectInputStream o = new ObjectInputStream(new FileInputStream(f));
        return (ArrayList<String>) o.readObject();
    }

    public static void readInNames() throws IOException {
        File f = new File("src\\FirstNames.txt");
        File s = new File("src\\Surnames.txt");
        if (!f.exists())
            throw new IllegalArgumentException("Firstnameserror");
        if (!s.exists())
            throw new IllegalArgumentException("Surnameserror");
        BufferedReader rf = new BufferedReader(new FileReader(f));
        BufferedReader rs = new BufferedReader(new FileReader(s));
        String line;
        while ((line = rf.readLine()) != null) {
            firstNames.add(line);
        }
        while ((line = rs.readLine()) != null) {
            surnames.add(line);
        }
        if (!firstNamesFile.exists())
            firstNamesFile.createNewFile();
        else {
            firstNamesFile.delete();
            firstNamesFile.createNewFile();
        }
        if (!surnamesFile.exists())
            surnamesFile.createNewFile();
        else {
            surnamesFile.delete();
            surnamesFile.createNewFile();
        }
        ObjectOutputStream first = new ObjectOutputStream(new FileOutputStream(firstNamesFile));
        first.writeObject(firstNames);
        first.close();
        ObjectOutputStream sur = new ObjectOutputStream(new FileOutputStream(surnamesFile));
        sur.writeObject(surnames);
        sur.close();
    }

    public static void readInPlanets() throws IOException {
        File f = new File("src\\Planets.txt");
        if (!f.exists())
            throw new IllegalArgumentException("Planetserror");
        BufferedReader sn = new BufferedReader(new FileReader(f));
        String line;
        while ((line = sn.readLine()) != null) {
            planets.add(line);
        }

        if (!planetsFile.exists())
            planetsFile.createNewFile();
        else {
            planetsFile.delete();
            planetsFile.createNewFile();
        }
        ObjectOutputStream o = new ObjectOutputStream(new FileOutputStream(planetsFile));
        o.writeObject(planets);
        o.close();
    }

    public static void readInStreets() throws IOException {
        File f = new File("src\\Streets.txt");
        if (!f.exists())
            throw new IllegalArgumentException("Streetserror");
        BufferedReader r = new BufferedReader(new FileReader(f));
        String line = "";
        while ((line = r.readLine()) != null) {
            streets.add(line);
        }

        if (!streetsFile.exists())
            streetsFile.createNewFile();
        else {
            streetsFile.delete();
            streetsFile.createNewFile();
        }
        ObjectOutputStream planets = new ObjectOutputStream(new FileOutputStream(streetsFile));
        planets.writeObject(streets);
        planets.close();
    }

    public static void readInCities() throws IOException {
        File f = new File("src\\Cities.txt");
        if (!f.exists())
            throw new IllegalArgumentException("Citieserror");
        BufferedReader r = new BufferedReader(new FileReader(f));
        String line = "";
        while ((line = r.readLine()) != null) {
            cities.add(line);
        }

        if (!citiesFile.exists())
            citiesFile.createNewFile();
        else {
            citiesFile.delete();
            citiesFile.createNewFile();
        }
        ObjectOutputStream planets = new ObjectOutputStream(new FileOutputStream(citiesFile));
        planets.writeObject(cities);
        planets.close();
    }
    public static void readInLawtexts() throws IOException {
        File l = new File("src\\LawText.txt");
        if (!l.exists())
            throw new IllegalArgumentException("Planetserror");
        BufferedReader sn = new BufferedReader(new FileReader(l));
        String line;
        String txt = "";
        while ((line = sn.readLine()) != null) {
            txt += line;
        }
        for(String s : txt.split("/!"))
            lawtexts.add(s);
        if (!lawtextFile.exists())
            lawtextFile.createNewFile();
        else {
            lawtextFile.delete();
            lawtextFile.createNewFile();
        }
        ObjectOutputStream law = new ObjectOutputStream(new FileOutputStream(lawtextFile));
        law.writeObject(lawtexts);
        law.close();
    }
    public static void readIndeparmy() throws IOException {
        File f = new File("src\\Departments.txt");
        if (!f.exists())
            throw new IllegalArgumentException("Departmenterror");
        BufferedReader r = new BufferedReader(new FileReader(f));
        String line;

        while ((line = r.readLine()) != null) {
            deparmy.add(line);
        }
        if (!deparmyFile.exists())
            deparmyFile.createNewFile();
        else {
            deparmyFile.delete();
            deparmyFile.createNewFile();
        }
        ObjectOutputStream o = new ObjectOutputStream(new FileOutputStream(deparmyFile));
        o.writeObject(deparmy);
        o.close();
    }
    public static void readInstype() throws IOException {
        File f = new File("src\\SoldierTypes.txt");
        if (!f.exists())
            throw new IllegalArgumentException("SoldierTypeerror");
        BufferedReader r = new BufferedReader(new FileReader(f));
        String line;

        while ((line = r.readLine()) != null) {
            stype.add(line);
        }
        if (!stypeFile.exists())
            stypeFile.createNewFile();
        else {
            stypeFile.delete();
            stypeFile.createNewFile();
        }
        ObjectOutputStream o = new ObjectOutputStream(new FileOutputStream(stypeFile));
        o.writeObject(stype);
        o.close();
    }
    public static void readInTitles() throws IOException {
        File f = new File("src\\Titles.txt");
        if (!f.exists())
            throw new IllegalArgumentException("Titleserror");
        BufferedReader r = new BufferedReader(new FileReader(f));
        String line;
        //titles null-entry
        titles.add(null);
        while ((line = r.readLine()) != null) {
            titles.add(line);
        }
        if (!titlesFile.exists())
            titlesFile.createNewFile();
        else {
            titlesFile.delete();
            titlesFile.createNewFile();
        }
        ObjectOutputStream o = new ObjectOutputStream(new FileOutputStream(titlesFile));
        o.writeObject(titles);
        o.close();
    }
    public static void readInlawareas() throws IOException {
        File f = new File("src\\LawAreas.txt");
        if (!f.exists())
            throw new IllegalArgumentException("LawAreaserror");
        BufferedReader r = new BufferedReader(new FileReader(f));
        String line;
        while ((line = r.readLine()) != null) {
            lawareas.add(line);
        }
        if (!lawareasFile.exists())
            lawareasFile.createNewFile();
        else {
            lawareasFile.delete();
            lawareasFile.createNewFile();
        }
        ObjectOutputStream o = new ObjectOutputStream(new FileOutputStream(lawareasFile));
        o.writeObject(lawareas);
        o.close();
    }
    public static void readInParties() throws IOException {
        File f = new File("src\\Parties.txt");
        if (!f.exists())
            throw new IllegalArgumentException("Partieserror");
        BufferedReader r = new BufferedReader(new FileReader(f));
        String line;
        //parties null-entry
        parties.add(null);
        while ((line = r.readLine()) != null) {
            parties.add(line);
        }
        if (!partiesFile.exists())
            partiesFile.createNewFile();
        else {
            partiesFile.delete();
            partiesFile.createNewFile();
        }
        ObjectOutputStream o = new ObjectOutputStream(new FileOutputStream(partiesFile));
        o.writeObject(parties);
        o.close();
    }
    public static void readInpjobs() throws IOException {
        File f = new File("src\\PoliticianSpecialJobs.txt");
        if (!f.exists())
            throw new IllegalArgumentException("PoliticianSpecialJobserror");
        BufferedReader r = new BufferedReader(new FileReader(f));
        String line;
        while ((line = r.readLine()) != null) {
            pjobs.add(line);
        }
        if (!pjobsFile.exists())
            pjobsFile.createNewFile();
        else {
            pjobsFile.delete();
            pjobsFile.createNewFile();
        }
        ObjectOutputStream o = new ObjectOutputStream(new FileOutputStream(pjobsFile));
        o.writeObject(pjobs);
        o.close();
    }

    public static void init() throws IOException, SQLException, ClassNotFoundException {
        firstNames = getListFromFile(firstNamesFile);
        surnames = getListFromFile(surnamesFile);
        planets = getListFromFile(planetsFile);
        streets = getListFromFile(streetsFile);
        cities = getListFromFile(citiesFile);
        lawtexts = getListFromFile(lawtextFile);
        deparmy = getListFromFile(deparmyFile);
        stype = getListFromFile(stypeFile); //Soldier-Types
        titles = getListFromFile(titlesFile);
        lawareas = getListFromFile(lawareasFile); //all lawareas except for 'All'
        parties = getListFromFile(partiesFile);
        pjobs = getListFromFile(pjobsFile); //Special jobs for Politicians per senate
        Class.forName("oracle.jdbc.driver.OracleDriver"); //loads Oracle Driver
        con = DriverManager.getConnection(database, user, pass); //establishes Connection
        //Prepared Statements for Insert
        ZIPcode = con.prepareStatement("INSERT INTO ZIPcode VALUES (?, ?, ?)");
        employee = con.prepareStatement("INSERT INTO Unionemployee VALUES (DEFAULT, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        soldier = con.prepareStatement("INSERT INTO Soldier VALUES (?, ?, ?, ?, ?)");
        justice = con.prepareStatement("INSERT INTO JudicialOfficer VALUES (?, ?, ?, ?, ?)");
        politician = con.prepareStatement("INSERT INTO Politician VALUES (?, ?, ?, ?)");
        court = con.prepareStatement("INSERT INTO Court VALUES (DEFAULT, ?, ?, ?)");
        senate = con.prepareStatement("INSERT INTO Senate VALUES (DEFAULT, ?, ?)");
        law = con.prepareStatement("INSERT INTO Law VALUES (?, ?, ?, ?)");
        rule = con.prepareStatement("INSERT INTO rule VALUES (?, ?, ?)");
        mission = con.prepareStatement("INSERT INTO Mission VALUES (DEFAULT, ?, ?)");
        carryout = con.prepareStatement("INSERT INTO carryout VALUES (?, ?)");
        currUID = con.prepareStatement("SELECT UnionID.CURRVAL FROM DUAL");
        currCID = con.prepareStatement("SELECT CID.CURRVAL FROM DUAL");
        currSenID = con.prepareStatement("SELECT MAX(SenateID) FROM Senate");
        currMID = con.prepareStatement("SELECT MAX(MissionID) FROM Mission");
        existingZIPcodes = con.prepareStatement("SELECT ZIPcode FROM ZIPcode");
        existingSocialSec = con.prepareStatement("SELECT SocialSecurity FROM Unionemployee");
        existingtelephone = con.prepareStatement("SELECT Telephonenumber FROM Unionemployee");
        admin = con.prepareStatement("INSERT INTO Administrator VALUES (?, ?)");
        curradminct = con.prepareStatement("SELECT COUNT(*) FROM Administrator");
        //prepare PLZ
        ResultSet tmp = existingZIPcodes.executeQuery();
        while (tmp.next()) {
            ZIPlist.add(tmp.getInt(1));
        }
        tmp = existingSocialSec.executeQuery();
        while (tmp.next()) {
            socialseclist.add(tmp.getInt(1));
        }
        tmp = existingtelephone.executeQuery();
        while (tmp.next()) {
            telephonelist.add(tmp.getInt(1));
        }
        tmp = curradminct.executeQuery();
        tmp.next();
        adminct = tmp.getInt(1);
    }

    public static void ZIPcodeInsert(int zip) throws SQLException {
        ZIPcode.setInt(1, zip);
        ZIPcode.setString(2, generateCity());
        ZIPcode.setString(3, generatePlanet());
        //add addbatch used to minimize runtime
        ZIPcode.addBatch();
    }
    public static void UnionemployeeInsert(String job) throws SQLException {
        int tmpn = generateInteger();
        while (socialseclist.contains(tmpn)) {
            tmpn = generateInteger();
        }
        socialseclist.add(tmpn);
    employee.setInt(1, tmpn);
        tmpn = generateInteger();
        while (telephonelist.contains(tmpn)) {
            tmpn = generateInteger();
        }
        telephonelist.add(tmpn);
    employee.setInt(2, tmpn);
    employee.setString(3, job);
    employee.setString(4, generateFirstName());
    employee.setString(5, generateSurname());
    employee.setString(6, generateStreet());
    List<Integer> tmp = generateAddrNr();
    if(tmp.get(0) != null)
        employee.setInt(7, tmp.get(0).intValue());
    else
        employee.setNull(7, Types.INTEGER);
    if(tmp.get(1) != null)
        employee.setInt(8, tmp.get(1).intValue());
    else
        employee.setNull(8, Types.INTEGER);
    if(tmp.get(2) != null)
        employee.setInt(9, tmp.get(2).intValue());
    else
        employee.setNull(9, Types.INTEGER);
    int plzi = generateInteger();
        employee.setInt(10, plzi);
    if(!ZIPlist.contains(plzi)) {
        ZIPlist.add(plzi);
        ZIPcodeInsert(plzi);
    }
    employee.addBatch();
        if(UnionID == null) {
            ZIPcode.executeBatch();
            employee.executeBatch(); //neccessary to get a value for current UnionID in Dual
            ResultSet tset = currUID.executeQuery();
            tset.next();
            UnionID = tset.getInt(1);
        } else
            UnionID++;
}
    public static void SoldierInsert(String job, String rank, String department, String sector, Integer commandingOfficerID) throws SQLException {
        UnionemployeeInsert(job);
        soldier.setInt(1, UnionID);
        soldier.setString(2, rank);
        soldier.setString(3, department);
        soldier.setString(4, sector);
        if(commandingOfficerID == null)
            soldier.setNull(5, Types.INTEGER);
        else
            soldier.setInt(5, commandingOfficerID);
        soldier.addBatch();
    }
    public static void JudicialOfficerInsert(String job, String title, Integer experience, String experienceTimeUnit, Integer courtID) throws SQLException {
       UnionemployeeInsert(job);
        justice.setInt(1, UnionID);
        justice.setString(2, title);
        justice.setInt(3, experience);
        justice.setString(4, experienceTimeUnit);
        if(courtID == null)
            justice.setNull(5, Types.INTEGER);
        else
            justice.setInt(5, courtID);
        justice.addBatch();
    }
    public static void PoliticianInsert(String job, String party, String title, Integer senateID) throws SQLException {
        UnionemployeeInsert(job);
        politician.setInt(1, UnionID);
        politician.setString(2, party);
        politician.setString(3, title);
        if(senateID == null)
            politician.setNull(4, Types.INTEGER);
        else
            politician.setInt(4, senateID);
        politician.addBatch();
    }

    public static void CourtInsert(String name, String sector, String areaoflaw) throws SQLException {
        court.setString(1, name);
        court.setString(2, sector);
        court.setString(3, areaoflaw);
        court.addBatch();
        if(CID == null) {
            court.executeBatch(); //neccessary to get a value for current CID in Dual
            ResultSet tset = currCID.executeQuery();
            tset.next();
            CID = tset.getInt(1);
        } else
            CID++;

        for(int j = 0; j < 4; j++) {
            JudicialOfficerInsert("Judge", "Dr.",r.nextInt(5,67),"Years",CID);
        }
        for (int pr = 0; pr < 6; pr++) {
            int tmp = r.nextInt(3,67);
            JudicialOfficerInsert("Prosecutor", r.nextInt(0,100) <= 50?"Dr.":"Mag.",tmp,((tmp<12 && r.nextInt(100) < 50)?"Months":"Years"),CID);
        }
    }
    public static void SenateInsert(String name, String sector) throws SQLException {

        senate.setString(1, name);
        senate.setString(2, sector);
        senate.addBatch();
        if(SenID == null) {
            senate.executeBatch();
            ResultSet tset = currSenID.executeQuery();
            tset.next();
            SenID = tset.getInt(1);
        } else
            SenID++;
        for (int i= 0; i < pjobs.size();i++) {
            PoliticianInsert(pjobs.get(i), parties.get(r.nextInt(parties.size())), titles.get(r.nextInt(titles.size())), SenID);
        }
        for (int s = 0; s < (100-pjobs.size()); s++) {
            PoliticianInsert("Senator", parties.get(r.nextInt(parties.size())), titles.get(r.nextInt(titles.size())), SenID);
        }
        int limit = r.nextInt(2,6);
        for (int g = 1; g < limit;g++) {
            LawInsert(SenID,g);
        }
    }
    public static void ruleInsert(Integer employeeID, Integer courtID, Integer senateID) throws SQLException {
       rule.setInt(1,employeeID.intValue());
       rule.setInt(2,courtID.intValue());
       rule.setInt(3, senateID.intValue());
       rule.addBatch();
    }
    public static void MissionInsert(String goal) throws SQLException {
        mission.setString(1,goal);
        mission.setInt(2,generateInteger());
        mission.addBatch();
        if(MissionID == null) {
            mission.executeBatch();
            ResultSet tset = currMID.executeQuery();
            tset.next();
            MissionID = tset.getInt(1);
        } else
            MissionID++;
    }
    public static void carryoutInsert(Integer missionID, Integer employeeID) throws SQLException {
        carryout.setInt(1, missionID.intValue());
        carryout.setInt(2, employeeID.intValue());
        carryout.addBatch();
    }
    public static void LawInsert(Integer SenateID, Integer referenceCode) throws SQLException {
        law.setInt(1,SenateID.intValue());
        law.setInt(2, referenceCode.intValue());
        int i = r.nextInt((lawtexts.size()-1));
        if(i%2 == 1) {
                ++i;
        }
        law.setString(3, lawtexts.get(i));
        law.setString(4, lawtexts.get((i+1)));
        law.addBatch();
    }
    public static void AdministratorInsert(String pwdhash) throws SQLException {
        admin.setString(1,"admin"+(++adminct));
        admin.setString(2, pwdhash);
        admin.addBatch();
    }
    public static void main(String[] args) throws SQLException, ClassNotFoundException, IOException {
        if (args.length > 0) {
            switch (args[0]) {
                case "setnames":
                case "setNames": {
                    try {
                        readInNames();
                    } catch (Exception e) {
                        System.out.println(e.getMessage());
                        throw new RuntimeException(e);
                    }
                    System.out.println("Names updated successfully!");
                    return;
                }

                case "setplanets":
                case "setPlanets": {
                    try {
                        readInPlanets();
                    } catch (Exception e) {
                        System.out.println(e.getMessage());
                        throw new RuntimeException(e);
                    }
                    System.out.println("Planets updated successfully!");
                    return;
                }

                case "setstreets":
                case "setStreets": {
                    try {
                        readInStreets();
                    } catch (Exception e) {
                        System.out.println(e.getMessage());
                        throw new RuntimeException(e);
                    }
                    System.out.println("Streets updated successfully!");
                    return;
                }

                case "setcities":
                case "setCities": {
                    try {
                        readInCities();
                    } catch (Exception e) {
                        System.out.println(e.getMessage());
                        throw new RuntimeException(e);
                    }
                    System.out.println("Cities updated successfully!");
                    return;
                }

                case "setlawtexts": //each entry seperated by '/!' and entries always even, 1. denomination (50 char) and 2. content block of text, etc.
                case "setLawtexts": {
                    try {
                        readInLawtexts();
                    } catch (Exception e) {
                        System.out.println(e.getMessage());
                        throw new RuntimeException(e);
                    }
                    System.out.println("Lawtexts updated successfully!");
                    return;
                }

                case "setdepartments"://Special Order: first Tactical (officers), then 6 Army and then 6 Spacenavy, for more always add 6 entries, very important!
                case "setDepartments": {
                    try {
                        readIndeparmy();
                    } catch (Exception e) {
                        System.out.println(e.getMessage());
                        throw new RuntimeException(e);
                    }
                    System.out.println("Departments updated successfully!");
                    return;
                }

                case "setsoldiertypes"://only allows entries in the predefined Sectors, see code in else
                case "setSoldierTypes": {
                    try {
                        readInstype();
                    } catch (Exception e) {
                        System.out.println(e.getMessage());
                        throw new RuntimeException(e);
                    }
                    System.out.println("Soldier-Types updated successfully!");
                    return;
                }

                case "settitles":
                case "setTitles": {
                    try {
                        readInTitles();
                    } catch (Exception e) {
                        System.out.println(e.getMessage());
                        throw new RuntimeException(e);
                    }
                    System.out.println("Titles updated successfully!");
                    return;
                }

                case "setlawareas"://three at the moment excluding "All"
                case "setLawAreas": {
                    try {
                        readInlawareas();
                    } catch (Exception e) {
                        System.out.println(e.getMessage());
                        throw new RuntimeException(e);
                    }
                    System.out.println("Areas of Law updated successfully!");
                    return;
                }

                case "setparties":
                case "setParties": {
                    try {
                        readInParties();
                    } catch (Exception e) {
                        System.out.println(e.getMessage());
                        throw new RuntimeException(e);
                    }
                    System.out.println("Titles updated successfully!");
                    return;
                }

                case "setpoliticiansspecialjobs":
                case "setPoliticiansSpecialJobs": {
                    try {
                        readInpjobs();
                    } catch (Exception e) {
                        System.out.println(e.getMessage());
                        throw new RuntimeException(e);
                    }
                    System.out.println("Titles updated successfully!");
                    return;
                }

                case "setall":
                case "setAll": {
                    try {
                        readInNames();
                        readInPlanets();
                        readInStreets();
                        readInCities();
                        readInLawtexts();
                        readIndeparmy();
                        readInstype();
                        readInTitles();
                        readInlawareas();
                        readInParties();
                        readInpjobs();
                    } catch (Exception e) {
                        System.out.println(e.getMessage());
                        throw new RuntimeException(e);
                    }
                    System.out.println("Everything updated successfully!");
                    return;
                }

            }
        }//Set new Randomgenerator Values for Names, cities, etc.
            long startTime = System.nanoTime();
            init();

            int ctg = 0;
            int cts = 0;
            for (int i = 0; i < 2; i++) {
                String sector = "Entire Union";
                SoldierInsert(stype.get(i), "General", deparmy.get(0), sector, null);
                soldierIDs.add(UnionID);
                int l0 = UnionID;
                if (i != 0) {
                    CID -= ctg;
                    SenID -= cts;
                }
                for (int crt = 0; (crt < 3); crt++) {

                    if (crt == 0) {
                        if (i == 0) {
                            CourtInsert("Supreme Court of Justice", sector, "All");
                            SenateInsert("General Senate of The Panvican Union", sector);
                            ctg++;
                            cts++;
                        } else {
                            CID++;
                            SenID++;
                        }

                        ruleInsert(l0, CID, SenID);
                    }
                    if (i == 0) {
                        CourtInsert("Union Court of Appeals", sector, "All");
                        ctg++;
                    } else
                        CID++;
                    ruleInsert(l0, CID, SenID);
                    if (crt < 2) {
                        int ctj = 0;
                        if (crt > 2)
                            ctj = 0;
                        for (; ctj < 3; ctj++) {
                            if (i == 0) {
                                CourtInsert("Union Court of Justice", sector, lawareas.get(ctj));
                                ctg++;
                            } else
                                CID++;
                            ruleInsert(l0, CID, SenID);
                        }
                    }
                }//General
                int s0 = SenID;
                for (int c = 1; c < 4; c++) {
                    sector = "Sector A" + c;
                    SoldierInsert(stype.get(i),"Colonel", deparmy.get(0), sector, l0);
                    soldierIDs.add(UnionID);
                    int l1 = UnionID;
                    for (int crt = 0; (crt < 3); crt++) {

                        if (crt == 0) {
                            if (i == 0) {
                                CourtInsert("Sector Supreme Court", sector, "All");
                                SenateInsert("Panvican Union Sectorial Senate", sector);
                                ctg++;
                                cts++;
                            } else {
                                CID++;
                                SenID++;
                            }
                            ruleInsert(l0, CID, s0);
                            ruleInsert(l1, CID, SenID);
                        }
                        if (i == 0) {
                            CourtInsert("Sector Court of Appeals", sector, "All");
                            ctg++;
                        } else
                            CID++;
                        ruleInsert(l0, CID, s0);
                        ruleInsert(l1, CID, SenID);
                        if (crt < 2) {
                            int ctj = 0;
                            if (crt > 2)
                                ctj = 0;
                            for (; ctj < 3; ctj++) {
                                if (i == 0) {
                                    CourtInsert("Sector Court of Justice", sector, lawareas.get(ctj));
                                    ctg++;
                                } else
                                    CID++;
                                ruleInsert(l0, CID, s0);
                                ruleInsert(l1, CID, SenID);
                            }
                        }
                    }//Sector
                    int s1 = SenID;
                    for (int m = 1; m < 3; m++) {
                        sector = "Sector A" + c + "." + m;
                        SoldierInsert(stype.get(i),"Major", deparmy.get(0), sector, l1);
                        soldierIDs.add(UnionID);
                        int l2 = UnionID;
                        for (int crt = 0; (crt < 3); crt++) {

                            if (crt == 0) {
                                if (i == 0) {
                                    SenateInsert("Panvican Union Sub-Sectorial Senate", sector);
                                    cts++;
                                } else {
                                    SenID++;
                                }
                            }
                            if(crt < 2) {
                                if (i == 0) {
                                    CourtInsert("Sub-Sector Court of Appeals", sector, "All");
                                    ctg++;
                                } else
                                    CID++;
                                ruleInsert(l0, CID, s0);
                                ruleInsert(l1, CID, s1);
                                ruleInsert(l2, CID, SenID);
                            }
                            int ctj = 0;
                            if (crt > 1)
                                ctj = 1;
                            for (; ctj < 3; ctj++) {
                                if (i == 0) {
                                    CourtInsert("Sub-Sector Court of Justice", sector, lawareas.get(ctj));
                                    ctg++;
                                } else
                                    CID++;
                                ruleInsert(l0, CID, s0);
                                ruleInsert(l1, CID, s1);
                                ruleInsert(l2, CID, SenID);
                            }
                        }//Subsector
                        int s2 = SenID;
                        for (int cap = 1; cap < 4; cap++) {
                            sector = "Sector A" + c + "." + m + "." + cap;
                            SoldierInsert(stype.get(i), "Captain", deparmy.get(0), sector, l2);
                            soldierIDs.add(UnionID);
                            int l3 = UnionID;
                            for (int crt = 0; (crt < 3); crt++) {

                                if (crt == 0) {
                                    if (i == 0) {
                                        SenateInsert("Panvican Union District Senate", sector);
                                        cts++;
                                    } else {
                                        SenID++;
                                    }
                                }
                                if (crt < 2) {
                                    if (i == 0) {
                                        CourtInsert("District Court of Appeals", sector, "All");
                                        ctg++;
                                    } else
                                        CID++;
                                    ruleInsert(l0, CID, s0);
                                    ruleInsert(l1, CID, s1);
                                    ruleInsert(l2, CID, s2);
                                    ruleInsert(l3, CID, SenID);
                                }
                                int ctj = 0;
                                if (crt > 1)
                                    ctj = 1;
                                for (; ctj < 3; ctj++) {
                                    if (i == 0) {
                                        CourtInsert("District Court of Justice", sector, lawareas.get(ctj));
                                        ctg++;
                                    } else
                                        CID++;
                                    ruleInsert(l0, CID, s0);
                                    ruleInsert(l1, CID, s1);
                                    ruleInsert(l2, CID, s2);
                                    ruleInsert(l3, CID, SenID);
                                }
                            }//District
                            for (int l = 1; l < 7; l++) {
                                SoldierInsert(stype.get(i), "Lieutenant", deparmy.get(0), sector, l3);
                                int l4 = UnionID;
                                for (int priv = 1; priv < 9; priv++) {
                                    SoldierInsert(stype.get(i), "Private", deparmy.get((i%((deparmy.size()-1)/6))*6+l), sector, l4); //only works if deparmy.size() == 7
                                }
                            }
                        }
                    }
                }
            }

            MissionInsert("Border Defense");
            int startmission = MissionID;
            MissionInsert("Patrol");
            MissionInsert("Fortification");
            MissionInsert("Planetary Defense Construction");
            MissionInsert("Dropship Test");
            MissionInsert("Blockade Dissolvement");
            MissionInsert("Anti-Terrorist Campaign");
            MissionInsert("Anti-Piracy Campaign");
            MissionInsert("Insurgency Termination");

            for (int i = startmission; i < (MissionID +1); i++) {
                int limit = r.nextInt(1, soldierIDs.size());
                ArrayList<Integer> tmp = new ArrayList<>();
                tmp.addAll(soldierIDs);
                for (int j = 0; j  < limit; j++) {
                    int del = r.nextInt(tmp.size());
                    carryoutInsert(i, tmp.get(del));
                    tmp.remove(del);
                }
            }
            AdministratorInsert("$2y$10$Hzxd1b3p.0Le0OIhYLORO.wcm1R94zhqH6Y88BBB/a9w8PcM0LQ9C"); // hash of 1234, corresponds to admin1
            ZIPcode.executeBatch();
            employee.executeBatch();
            soldier.executeBatch();
            employee.executeBatch();
            court.executeBatch();
            justice.executeBatch();
            employee.executeBatch();
            senate.executeBatch();
            politician.executeBatch();
            rule.executeBatch();
            mission.executeBatch();
            carryout.executeBatch();
            law.executeBatch();
            admin.executeBatch();
            long endTime = System.nanoTime();
            ResultSet confirmset = currUID.executeQuery();
            confirmset.next();
            assert(confirmset.getInt(1) == UnionID.intValue());
            System.out.println("Employees: "+UnionID.intValue());
            System.out.println("Senates: "+SenID.intValue());
            System.out.println("Courts: "+CID.intValue());
            System.out.println("Missions: "+ MissionID.intValue());
            System.out.println("Runtime: "+(endTime-startTime)*Math.pow(10,(-9)));


    }
}