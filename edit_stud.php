<?php
 if (isset($_GET['stud_id']))
 {
        
         $sql_stud = "SELECT st_pib, st_birsday, cl_name FROM stud, class where st_id=".$_GET['stud_id'];
         //echo $sql;
         $result_stud = $conn->query($sql_stud);
 
         if ($result_stud->num_rows > 0) 
         {
                 while ($row = $result_stud->fetch_assoc()) 
                 {
                  $rr=$row['st_pib'];
                  $gg=$row['st_birsday'];
                  $cc=$row['cl_name'];
                 }
         }
 }
else{$rr="";
$gg="";
$cc="";   
}

if (isset($_GET['stud_id']))   {            
    echo "<form action='' method='post'>";

            $sql_cl = "SELECT cl_id, cl_name FROM class where cl_name like '%".$_GET['cl']."%'";
            //echo $sql;
            $result_cl = $conn->query($sql_cl);
            echo "<select name='class' id='class'>";               
            if ($result_cl->num_rows > 0) {
                    $ii=1; 
                    echo "<option value='0'>-</option>";
                    $sel="";
                    while ($row = $result_cl->fetch_assoc())
                    {
                            $sel="";
                            if($_GET['st']==$row['cl_id']){$sel=" selected";}else{$sel="";}
                                    echo "<option value='".$row['cl_id']."'".$sel.">".$row['cl_name']."</option>";   
                            }
                    } 
            echo "</select>";         
            echo "<input type='text' name='st_pib' value='".$rr."'>";
            echo "<input type='text' name='st_birsday' value='".$gg."' maxlenght='10' size='15'>";  
            echo "<input type='submit' name='update' value='update'>"; 
            echo "<input type='submit' name='delete' value='delete'><br><br>";
           
            "</form>";        
}

?>