alter session set "_ORACLE_SCRIPT"=true;
BEGIN
    DECLARE
        found INTEGER;
    BEGIN
        SELECT COUNT(*)
        INTO found
        FROM dba_users
        WHERE username = 'GALACTICUNIONDBUSER';
        -- If user doesn't exist: create user with default password 
        IF found = 0 THEN
            EXECUTE IMMEDIATE 'CREATE USER GALACTICUNIONDBUSER IDENTIFIED BY securepassword';

            -- Grant permissions
            EXECUTE IMMEDIATE 'GRANT CONNECT, RESOURCE TO GALACTICUNIONDBUSER';
        END IF;
    END;
END;
/
COMMIT;