<!doctype html>
<link
        rel="stylesheet"

        href="https://site-assets.fontawesome.com/releases/v6.3.0/css/all.css"
      >

<?php
$fields = [
  "Phone",
  "Email",
  "Major Subject",
  "Minor Subject",
  "Ability Enhancement Course",
  "Value Added Course 1",
  "Value Added Course 2"
];

$db = new PDO ("mysql:host=localhost;dbname=admission22;charset=utf8mb4", "domino", "remembermyname");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


if ($auth == null && $_POST != null) {
  var_dump ($_POST);

  if ($_POST ["roll"] != null) {
    $roll = strip_tags ($_POST ["roll"]);
    $reg = strip_tags ($_POST ["reg"]);

    $sql = "SELECT * FROM students WHERE uid = '$reg' and urollno = '$roll'";
    $ret = $db -> query ($sql) ->fetch () ;

    if (sizeof ($ret) == 0) {
      $auth = null ;
    } else {
      $auth = $ret ;
    }
  } else {
    $roll = $_POST ["uroll"];
    $reg = $_POST ["ureg"];
    $auth = array (
      "roll"=> $roll,
      "reg"=> $reg
     ) ;

     $major = $_POST ["MajorSubject"];
     $minor = $_POST ["MinorSubject"];
     $aec = $_POST ["AbilityEnhancementCourse"];
     $vac1 = $_POST ["ValueAddedCourse1"];
     $vac2 = $_POST ["ValueAddedCourse2"];
     $phone = $_POST ["Phone"];
     $email = $_POST ["Email"];
     $md = $_POST ["md"];
     $sql = "UPDATE students set phone = '$phone', mail = '$email', md='$md', major = '$major', minor = '$minor', aec = '$aec', vac1 = '$vac1', vac2 = '$vac2' where urollno = '$roll' and uid = '$reg'";
     var_dump ($sql);
     $ret = $db -> query ($sql) ->fetch () ;
     var_dump ($ret);
  }
} 
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GDC Udhampur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <form method="post" class="row  justify-content-center">
      <div class="border shadow p-4 col-md-5 m-5 row justify-content-center d-flex">
        <img class="img-fluid col-12" src="/logo.png" width="300">
        <h4 class="p-2 alert alert-primary m-2 text-center"><i class="fa-solid fa-pen-to-square me-2"></i>Semester 2 Subject Preference</h4>
        <?php if ($auth == null) {?>
        <div class="input-group  m-2">
          <span class="input-group-text" id="basic-addon1">University Roll No</span>
          <input required name="roll" type="text" class="form-control" placeholder="Enter roll number" aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <div class="input-group m-2">
          <span class="input-group-text" id="basic-addon1">University Registration No</span>
          <input required name="reg" type="text" class="form-control" placeholder="Registration number" aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <?php }  else  {?>
          Name / Father's Name / Mother's Name: <h3 class="text-center"><?php echo $auth ["name"] ;?></h3>
          University Roll Number: <h3 class="text-center"><?php echo $auth ["urollno"] ;?></h3>
          University Registration Number: <h3 class="text-center"><?php echo $auth ["uid"] ;?></h3>

          <?php foreach ($fields as $f) { ?>
            <div class="input-group m-2">
              <span class="input-group-text" id="basic-addon1"><?php echo $f ;?></span>
              <input required name="<?php echo str_replace (" ", "", $f);?>" type="text" class="form-control" >
            </div>
          <?php } ?>
          <div class="input-group mb-3">
            <label class="input-group-text bg-info text-white" for="inputGroupSelect01">Multi Disciplinary</label>
            <select name="md" class="form-select" id="inputGroupSelect01">
              <option>English</option>
              <option>Hindi</option>
              <option>Math</option>
            </select>
          </div>

        <?php } ?>


        <input type="hidden" name="uroll" value="<?php echo $auth ["urollno"] ;?>">
        <input type="hidden" name="ureg" value="<?php echo $auth ["uid"] ;?>">
        <button type="submit" class="btn btn-primary m-2 shadow">Submit</button>
      </div>
    </form>
  </body>
</html>
