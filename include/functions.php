<?php


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
  
  
  //  function to get any information in any table by id
  function get_by_id ($table ,$id, $attribute ){  //$attribute == column
    global $conn;
    $sql = "SELECT * FROM $table";
    $stm = $conn->prepare($sql);
    $stm -> execute();
    $allRows = $stm -> fetchAll();
    //$search = $vlaue;
    foreach($allRows as $row){
        if($row['id'] == $id){
            return $row[$attribute];
        }
    }
  }
  
  function fetch_table_counts($table_name)
  {
    global $conn;
    $sql = "SELECT count(*) FROM $table_name"; 
    $result = $conn->prepare($sql); 
    $result->execute(); 
    $number_of_rows = $result->fetchColumn(); 
    return $number_of_rows;
  }
  
  function fetch_recipe_counts_where($catid)
  {
    global $conn;
    $sql = "SELECT count(*) FROM recipe WHERE cat_id=:cat_id"; 
    $result = $conn->prepare($sql); 
    $result->execute(array("cat_id"=>$catid)); 
    $number_of_rows = $result->fetchColumn(); 
    return $number_of_rows;
  }


  //search in a table to looking for a certain value and return true(1) OR flase(0)
  //eg.    in_table('usrs', 'Email', 'acb@gmail.com');       // (email) is an attribute in users table.
  
  function in_table ($table,$attribute, $vlaue ){//$attribute == column
    global $conn;
  
    $sql = "SELECT * FROM $table";
    $stm = $conn->prepare($sql);
    $stm -> execute();
    $allRows = $stm -> fetchAll();
    $search = $vlaue;
    foreach($allRows as $row){
        if($row[$attribute] == $search){
            return 1;
        }
    }
    return 0;
  }
  function get_sys_date()
  {
    global $conn;
    $sql= "SELECT DATE(SYSDATE())";
              $stm= $conn->prepare($sql);
              $stm->execute();
              $r = $stm -> fetchAll();
              return $r[0][0];
  }
  

  
function get_cat_by_id($catID)
{
    global $conn; 
    $sql = "SELECT * FROM categories where id=:cat_id ";
    $stm = $conn->prepare($sql);
    $stm -> execute(array("cat_id"=>$catID));
    $rows = $stm -> fetchAll();
    echo $rows[0]['name'];
}

/////////////////random recipes/////////////////////

$sql = "SELECT * FROM recipe ";
$stm = $conn->prepare($sql);
$stm -> execute();
$allRows = $stm -> fetchAll();



//generates 20 unique random numbers
function randomGen($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}
$random_index = randomGen(0,$stm->rowCount()-1,10); 

?>