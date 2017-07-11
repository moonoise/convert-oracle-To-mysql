<?php 
define('OCI_USERNAME', "",true);
define('OCI_PASSWORD', "",true);
define('OCI_LOCALHOST', "",true);
define('OCI_NAMEDATABASE', "",true);


 
define('MYSQL_LOCALHOST',"localhost",true);
define('MYSQL_USERNAME',"",true);
define('MYSQL_PASSWORD',"",true);
define('MYSQL_NAMEDATABASE',"",true);


   $sqlconn = mysqli_connect(MYSQL_LOCALHOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_NAMEDATABASE);
// Check connection
if (!$sqlconn) {
    die("Connection failed: " . mysqli_connect_error());
}
  mysqli_select_db($sqlconn,MYSQL_NAMEDATABASE);
  mysqli_query($sqlconn,"SET character_set_results=UTF8");
  mysqli_query($sqlconn,"SET character_set_client=UTF8");
  mysqli_query($sqlconn,"SET character_set_connection=UTF8");





$conn = oci_connect(OCI_USERNAME, OCI_PASSWORD, OCI_LOCALHOST."/".OCI_NAMEDATABASE,'AL32UTF8');
     if (!$conn) {
          $e = oci_error();
          trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        mysqli_query($sqlconn,"DELETE FROM tbl_rid_person");  //Delete old table first run always.
        sleep(1);
        echo "Delete data.... <br>";
      $oci_sql =    "SELECT PER_PERSONAL.PER_ID,
                      PER_PERSONAL.PER_CARDNO,
                      PER_POSITION.POS_NO,
                      PER_PRENAME.PN_NAME,
                      PER_PERSONAL.PER_NAME,
                      PER_PERSONAL.PER_SURNAME,
                      PER_MGT.PM_NAME,
                      PER_LINE.PL_NAME,
                      PER_LEVEL.LEVEL_NAME,
                      PER_ORG.ORG_NAME,
                      PER_ORG1.ORG_NAME AS ORG_NAME1,
                      PER_ORG2.ORG_NAME AS ORG_NAME2,
                      PER_PERSONAL.PER_BIRTHDATE,
                      PER_PERSONAL.PER_RETIREDATE,
                      PER_PERSONAL.PER_TYPE,
                      PER_PERSONAL.PER_STATUS,
                      PER_PERSONAL.PER_EMAIL,
                      PER_PERSONAL.PER_STARTDATE AS PER_STARTDATE1,
                      PER_RELIGION.RE_NAME,
                      PER_PERSONAL.PER_ADD1 AS PER_ADD11,
                      PER_PROVINCE.PV_NAME,
                      EDUCATE.EL_NAME
                    FROM PER_PERSONAL
                    LEFT JOIN PER_PRENAME
                    ON PER_PRENAME.PN_CODE = PER_PERSONAL.PN_CODE
                    LEFT JOIN PER_POSITION
                    ON PER_POSITION.POS_ID = PER_PERSONAL.POS_ID
                    LEFT JOIN PER_MGT
                    ON PER_MGT.PM_CODE = PER_POSITION.PM_CODE
                    LEFT JOIN PER_LINE
                    ON PER_LINE.PL_CODE = PER_POSITION.PL_CODE
                    INNER JOIN PER_LEVEL
                    ON PER_LEVEL.LEVEL_NO = PER_PERSONAL.LEVEL_NO
                    LEFT JOIN PER_ORG
                    ON PER_POSITION.ORG_ID = PER_ORG.ORG_ID
                    LEFT JOIN PER_ORG PER_ORG1
                    ON PER_POSITION.ORG_ID_1 = PER_ORG1.ORG_ID
                    LEFT JOIN PER_ORG PER_ORG2
                    ON PER_POSITION.ORG_ID_2    = PER_ORG2.ORG_ID
                    LEFT JOIN PER_RELIGION
                    ON PER_PERSONAL.RE_CODE = PER_RELIGION.RE_CODE
                    LEFT JOIN PER_PROVINCE
                    ON PER_PERSONAL.PV_CODE     = PER_PROVINCE.PV_CODE
                    LEFT JOIN EDUCATE
                    ON PER_PERSONAL.PER_ID = EDUCATE.PER_ID
                    WHERE PER_PERSONAL.PER_TYPE = 1
                    AND (PER_PERSONAL.PER_STATUS = 1 OR PER_PERSONAL.PER_STATUS = 0)";

      $stid = oci_parse($conn, $oci_sql);
                    oci_execute($stid);
             
            $sql = "";
            $i = 1 ;
            $counter = 1;
            while (($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {

                  $per_id     =   $row['PER_ID'];
                  $per_cardno =   $row['PER_CARDNO'];
                  $pos_no     =   $row['POS_NO'];
                  $pn_name    =   $row['PN_NAME'];
                  $per_name   =   $row['PER_NAME'];
                  $per_surname =  $row['PER_SURNAME'];
                  $pm_name    =   $row['PM_NAME'];
                  $pl_name    =   $row['PL_NAME'];
                  $level_name =   $row['LEVEL_NAME'];
                  $org_name   =   $row['ORG_NAME'];
                  $org_name1  =   $row['ORG_NAME1'];
                  $org_name2  =   $row['ORG_NAME2'];
                  $per_birthdate =   $row['PER_BIRTHDATE'];
                  $per_retiredate =   $row['PER_RETIREDATE'];
                  $per_type   =   $row['PER_TYPE'];
                  $per_status =   $row['PER_STATUS'];
                  $per_email  =   $row['PER_EMAIL'];
                  $per_startdate1 =    $row['PER_STARTDATE1'];
                  $re_name    =   $row['RE_NAME'];
                  $per_add11  =   $row['PER_ADD11'];
                  $pv_name    =   $row['PV_NAME'];
                  $el_name    =   $row['EL_NAME'];

              $sql .= "NULL,$per_id,$per_cardno,$pos_no,$pn_name,$per_name,$per_surname,$pm_name,$pl_name,$level_name,$org_name,$org_name1,$org_name2,$per_birthdate,$per_retiredate,$per_type,$per_status,$per_email,$per_startdate1,$re_name,$per_add11,$pv_name,$el_name\n";
              $counter++;
              if ($counter == 1000) {
                
                $myfile = fopen("pertype1_".$i.".csv", "w") or die("Unable to open file!");
                fwrite($myfile, $sql);
                sleep(1);
                echo "create file "."pertype1_".$i.".csv"."<br>";
                fclose($myfile); 
                $i++;
                $sql = "";
                $counter = 1; 
              }
              
            }
              $myfile = fopen("pertype1_".$i.".csv", "w") or die("Unable to open file!");
              fwrite($myfile, $sql);
                fclose($myfile); 
              echo "create file "."pertype1_".$i.".csv"."<br>";
              
            echo "file created ...<br>";
              $numFile = $i;

             for ($i=1; $i <=$numFile ; $i++) { 
                  $fh = fopen("pertype1_".$i.".csv", "r"); 
                  $filename = "pertype1_".$i.".csv";
                   $db_sql = "LOAD DATA LOCAL INFILE '$filename' INTO TABLE tbl_rid_person
                   FIELDS TERMINATED BY ',';";
                  $db_res = mysqli_query($sqlconn,$db_sql) or die($db_sql);
                  sleep(1);
                  echo "drump file ".$filename."<br>";
                  fclose($fh);   
                }   
                echo "Delete file ...<br>";
             for ($i=1; $i <=$numFile ; $i++) { 
                  $fh = fopen("pertype1_".$i.".csv", "a"); 
                  $filename = "pertype1_".$i.".csv";
                  chown($filename, 666);
                  chmod($filename, 0777);
                  fclose($fh);
                  
                  if ( unlink($filename) ){
                          echo "delete file success <br>";
                     } else {
                          echo "delete file fail";
                          echo " delete file ".$filename."<br>";
                    }

                }
           mysqli_close($sqlconn);





 ?>

//credit by moonoise@gmail.com