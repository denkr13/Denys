<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testn";
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_query($conn,'SET NAMES utf8');

if ($conn->connect_error) {
    die("Помилка підключення до бази даних: ". $conn->connect_error);
}
$tupe_user=1; //1-адмін    2-користувач

//видалення та оновлення учня
if (isset($_POST['update']))        {
                   
    $sql_upd = "UPDATE stud SET st_cl_id=".$_POST['class'].", st_pib='".$_POST['st_pib']."', st_birsday='".$_POST['st_birsday']."' WHERE st_id=".$_GET['stud_id'];
    echo $sql_upd;
    $result_upd = $conn->query($sql_upd);
}

if (isset($_POST['delete']))        
{    
    $sql = "DELETE FROM stud WHERE st_id=".$_GET['students'];
    //echo $sql;
    $result = $conn->query($sql);                
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $a=5;
        echo "
        <div>

        <table border=1 align=center> 
        <caption><h1> Оберіть номер класу </h1> </caption>
            <tr>";
        while($a<=12){
            echo "
            <th width=50px height=35px>
            <a href='?cl=".$a."'>".$a." класи</a>
            </th>";

            $a++;
        }
        echo "
        </tr> 
        </table>
        </div>
        ";  
    ?>
    <?php
if (isset($_GET['cl']))
{ 
    $sql = "SELECT cl_id, cl_name FROM class where cl_name like '%".$_GET['cl']."%'";
    $result = $conn->query($sql);
    If($result->num_rows > 0) 
    {
        echo "
        <h2 align=center>Оберіть клас</h2>
        <div>
        <table border=1 align=center>  <tr>";

        while ($row = $result->fetch_assoc())
        {
            echo 
                 "
                 <th width=50px height=35px>";
                      echo   "<a href='?cl=".$_GET['cl']."&st=".$row["cl_id"]."'>".$row["cl_name"]." класи</a> ";
                 echo "</th>";
        }

        echo "</tr> </table> </div>";   
    
    } else { "Не знайдено жодного запису";}   
}
    ?>
    <?php
if (isset($_GET['st']))
{
    $sql = "SELECT cl_name FROM class where cl_id=".$_GET['st'];
    $result = $conn->query($sql);
    $nameClass = '';
    while ($row = $result->fetch_assoc())
    {
      $nameClass=$row['cl_name'];
    } 

    $sql = "SELECT st_id, st_pib, st_birsday FROM stud where st_cl_id=".$_GET['st']." order by st_pib";
        $result = $conn->query($sql);
        
        If($result->num_rows > 0) 
         {
            echo "<div><table border=1 align=center>"; 
            echo "<caption><h3>Учні ".$nameClass." класу</h3></caption>";
              
            echo "<caption>";
              include("edit_stud.php");
            echo "</caption>";

             $np=1;
             echo"<tr><th>н/п</th>";
             echo"<th>Прізвище, ім`я</th>";
             echo"<th>ДН</th>";
             if($tupe_user==1)
             {
                echo"<th>Редагування</th>";
             }
             
             echo"</tr>";
                 while ($row = $result->fetch_assoc())
                {
                    echo "<tr><td>";
                       echo $np.".";

                    echo "</td>";
                    echo "<td>";
                       echo  $row['st_pib'];
                    echo "</td>";
                    echo "<td>";
                       echo  $row["st_birsday"];  
                    echo "</td>";
                    if($tupe_user==1)
                    {echo "<td>";
                        echo "<a href='?cl=".$_GET['cl']."&st=".$_GET['st']."&stud_id=".$row['st_id']."'>edit</a>";   
                     echo "</td>";
                    }
                    
                 $np++;
                } 
            echo "</tr> </table></div>";
    
            } else { "Не знайдено жодного запису";}   
        }
    ?>
</body>
</html>
<?php
// if (isset($_POST['but_select']))
// {
//     $sql = "SELECT cl_id, cl_name FROM class";
// $result = $conn->query($sql);
// If($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()){
//         echo "ID: " . $row["cl_id"]. " - ім'я: " . $row["cl_name"]."<br>";
//     }
// } else { "Не знайдено жодного запису";}
// //$conn->close();
// }


// if (isset($_POST['change_select']))
// {    
//     $newName = $_POST['inserttext_select']; 
//     $newBirthday = $_POST['inserttext2_select'];
//     $sql = "INSERT INTO stud (st_pib, st_birsday, st_cl_id) VALUES ('".$newName."','".$newBirthday."',".$_GET['st'].")";
//     if($conn->query($sql) === TRUE){
//         echo "Інформація туспішно встановлена. Останеній встановлений ID: ";
//     } else {
//         echo "Помилка вставки інформації: " . $conn->error;
//     }
//     //$conn->close();
// }
// if (isset($_POST['insertclasssub_select']))
// {    
//     $newName = $_POST['insertclass_select']; 
    
//     $sql = "INSERT INTO class (cl_name) VALUES ('$newName')";
//     if($conn->query($sql) === TRUE){
//         echo "Інформація туспішно встановлена. Останеній встановлений ID: ";
//     } else {
//         echo "Помилка вставки інформації: " . $conn->error;
//     }
    //$conn->close();
// }

/*
if (isset($_POST['new_select']))
{
// $newName = "hello";
$userId = 5;
$sql = "UPDATE test2 SET t_name='' WHERE t_id=$userId";
If($conn->query($sql) === TRUE) {
    echo " інформація оновлена успішно ";
} else {echo "Помилка оновлення інформації:" . $conn->error;}
$conn->close();
}
*/

// if (isset($_POST['update_select']))
// {
//     $newName = $_POST['new_select'];
//     $userId = $_POST['update2_select'];
//     $sql = "UPDATE class SET cl_name='".$newName."' WHERE cl_id=".$userId;
//     echo $sql;
//     if($conn->query($sql) === TRUE)
//     {
//         echo "Інформація успішно оновлена ";
//     } else {
//         echo "Помилка оновлення інформації: " . $conn->error;
//     }
    //$conn->close();
// }
// if (isset($_POST['delete_select'])){
//     $searchid=$_GET['st'];
// $sql = "DELETE FROM class WHERE cl_id=$searchid";
// if ($conn->query($sql) === TRUE)
// {
//     echo"інформація про користувача видалено успішно";
// } else {
//     echo "Помилка видалення інформації" . $conn->error;
// }
//$conn->close();
// }


// echo "<form method='post' action=''>

 
// <input type='text' name='inserttext_select' value=''>
// <input type='text' name='inserttext2_select' value=''>
//     <input type='submit' name='change_select' value='insert'>
 
//     <input type='submit' name='update_select' value='update'>
//     <input type='submit' name='delete_select' value='delete'>
//     <input type='text' name='insertclass_select' value=''>
//     <input type='submit' name='insertclasssub_select' value='insertclass'>
   

// </form>";




   // $conn->close();



        // $conn->close();

        // <th> ПІ </th>
        // <th> ДН </th>



// if (isset($_POST['but_select']))
// {
//     $sql = "SELECT st_id, st_name FROM students";
// $result = $conn->query($sql);
// If($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()){
//         echo "ID: " . $row["st_id"]. " - ім'я: " . $row["st_name"]."<br>" . $row["st_birthday"]."<br>";
//     }
// } else { "Не знайдено жодного запису";}
//$conn->close();
// }


// if (isset($_POST['change_selectі']))
// {    
//     $newBirthday =  $_POST['inserttextbirth_select'];
//     $newName = $_POST['inserttext_select'];   
//     $sql = "INSERT INTO stud (st_name, st_birthday) VALUES ('$newName', )";
//     if($conn->query($sql) === TRUE){
//         echo "Інформація туспішно встановлена. Останеній встановлений ID: ";
//     } else {
//         echo "Помилка вставки інформації: " . $conn->error;
//     }
   // $conn->close();


/*
if (isset($_POST['new_select']))
{
// $newName = "hello";
$userId = 5;
$sql = "UPDATE test2 SET t_name='' WHERE t_id=$userId";
If($conn->query($sql) === TRUE) {
    echo " інформація оновлена успішно ";
} else {echo "Помилка оновлення інформації:" . $conn->error;}
$conn->close();
}
*/

// if (isset($_POST['update_select']))
// {
//     $newName = $_POST['new_select'];
//     $userId = $_POST['update2_select'];
//     $sql = "UPDATE students SET st_name='".$newName."' WHERE st_id=".$userId;
//     echo $sql;
//     if($conn->query($sql) === TRUE)
//     {
//         echo "Інформація успішно оновлена ";
//     } else {
//         echo "Помилка оновлення інформації: " . $conn->error;
//     }
//     //$conn->close();
// }
// if (isset($_POST['delete_select'])){
//     $searchid=$_POST['newdel_select'];
// $sql = "DELETE FROM students WHERE st_id=$searchid";
// if ($conn->query($sql) === TRUE)
// {
//     echo"інформація про користувача видалено успішно";
// } else {
//     echo "Помилка видалення інформації" . $conn->error;
// }
//$conn->close();

?>