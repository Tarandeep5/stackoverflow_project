<?php
$dbconnect = mysqli_connect("localhost", "root", "", "stackoverflow_project")  or die(mysqli_error($con)); 
extract($_POST);

if(isset($_POST['readrecord'])){
    $data = '<table class="table table-bordered table-striped">
            <tr>
            <th> ID</th>
            <th>TITLE </th>
            <th>BODY </th>
            <th> TAG</th>
            <th> CREATED ON</th>
            <th> EDIT ACTION</th>
            <th>DELETE ACTION </th>
            </tr>';
    $displayquery = "SELECT * FROM `question_table`";
    $result = mysqli_query($dbconnect,$displayquery);
    if(mysqli_num_rows($result) > 0 ){
        
        $number = 1;
        while($row  = mysqli_fetch_array($result)){
            $data .= '<tr>
                <td>'.$number.'</td>
                <td>'.$row['Title'].'</td>  
                <td>'.$row['Body'].'</td>  
                <td>'.$row['Tag'].'</td> 
                 <td>'.$row['CreatedOn'].'</td> 
                    <td>
                   <button onclick="GetUserDetails('.$row['id'].')" class ="btn sbtn-warning"> EDIT </button>
                    </td>
                    <td>
                   <button onclick="DeleteUserData('.$row['id'].')" class ="btn sbtn-warning"> DELETE </button>
                    </td>
                   </tr>';
                    $number++;
                }
             }
            $data.= '</table>';
            echo $data;
    
}

if(isset($_POST['Title']) && isset($_POST['Body']) && isset($_POST['Tag']) ){
    
    $query = " INSERT INTO `question_table`(`Title`, `Body`, `Tag`) VALUES ('$Title' , '$Body' , '$Tag')";
    mysqli_query($dbconnect,$query);
}

if(isset($_POST['deleteid'])){
    $userid = $_POST['deleteid'];
    $deletequery = " DELETE FROM `question_table` WHERE id='$userid'";
    mysqli_query($dbconnect,$deletequery);
    
}




/// get user details 
if(isset($_POST['id']) && isset($_POST['id'])!="")   
{
  $user_id = $_POST['id'];
  $query = "SELECT * FROM question_table WHERE id = '$user_id'";
  if(!$result = mysqli_query($dbconnect,$query)){
      exit(mysqli_error());
  }  
  $response = array();
  
  if(mysqli_num_rows($result)> 0){
      while($row = mysqli_fetch_assoc($result)){
          $response = $row;
      }
  }
  else{
      $response['status'] = 200;
      $response['message'] = "Data not found!";
  }
  echo json_encode($response);  
}
else
{
  $response['status'] = 200;
      $response['message'] = "invalid request!";  
}
  


/// to update the table

if(isset($_POST['hidden_user_idupd'])){ //'hidden_user_idupd'
    $hidden_user_idupd = $_POST['hidden_user_idupd'];
    $Titletochange = $_POST['Titletochange'];
    $Bodytochange = $_POST['Bodytochange'];
    $Tagtochange = $_POST['Tagtochange'];
    
    $query = "UPDATE `question_table` SET `Title` = '$Titletochange' , `Body` ='$Bodytochange', `Tag` ='$Tagtochange' WHERE `id` ='$hidden_user_idupd'";    
    mysqli_query($dbconnect,$query);
        
    
}

?>
