<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$CAPPING = 80 ;
$subjects = array (
  "science" => [
    "Sericulture",
    "Computer Applications",
    "Geology",
    "Mathematics",
    "Geography",
    "Statistics",
  ], "arts" => [
    "Education",
    "Economics",
    "Sociology",
    "Psychology",
    "Public Administration",
    "Hindi",
    "Political Science",
    "English"
  ]
) ;
?>
<!doctype html>
<link
        rel="stylesheet"

        href="https://site-assets.fontawesome.com/releases/v6.3.0/css/all.css"
      >

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"
  id="theme-styles"
/>

      
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

$_fields = array (
  "phone" => "Phone",
  "mail" => "Email",
  "major" => "MajorSubject",
  "minor" => "MinorSubject",
  "aec" => "AbilityEnhancementCourse",
  "vac1" => "ValueAddedCourse1",
  "vac2" => "ValueAddedCourse2"
);

$db = new PDO ("mysql:host=localhost;dbname=admission22;charset=utf8mb4", "ftop", "jennahaze");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$stream = null ;
if ($_POST != null) {
  echo "<script>data = " .json_encode ($_POST). "</script>";

  if ($_POST ["roll"] != null) {
    switch ($_POST ["roll"][4]) {
      case "1":
      default:
        $stream = "arts";
        break ;
      case "2":
        $stream = "commerce";
        break ;
      case "3":
        $stream = "science";
        break ;
      case "4":
        $stream = "bba";
        break ;
      case "5":
        $stream = "bca";
        break ;
    }
    
    $roll = strip_tags ($_POST ["roll"]);
    $reg = strip_tags ($_POST ["reg"]);

    $sql = "SELECT * FROM students WHERE uid = '$reg' and urollno = '$roll'";
    $ret = $db -> query ($sql) ->fetch () ;
    if ($ret === false) {
      $auth = null ;
      ?>
        <div class="alert alert-danger h4"><i class="fa-solid fa-shield-xmark me-2"></i>Incorrect Registration or Roll Number </div>
      <?php
    } else {
      $auth = $ret ;
      foreach ($_fields as $f => $v) {
        $auth [$v] = $ret [$f];
      }
      echo "<script>data = " .json_encode ($auth). "</script>";

    }
  } else {
    // set in db
    $md = $_POST ["md"];
    $sql = "SELECT * from students where md = '$md'";
    $ret = $db -> query ($sql) ->fetch () ;
    if ($ret === false)
      $ret = [] ;
    if (sizeof ($ret) >= $CAPPING) {
      echo "<div></div>";
      ?>
      <script>
        Swal.fire(
        'No seats available in ' + data ["md"],
        `There are no seats available in ${data ["md"]}.\n\nPlease choose another subject.`,
        'error'
      ) ;
      </script>
        
      <?php
      $roll = $_POST ["uroll"];
      $reg = $_POST ["ureg"];
      $name = $_POST ["name"];
      $_POST ["urollno"] = $roll ;
      $_POST ["uid"]= $reg ;
      $_POST ["name"]= $name ;
      $auth = $_POST ;

      unset ($_POST ["md"]);
      echo "<script>data = " .json_encode ($_POST). "</script>";

    } else {

      $roll = $_POST ["uroll"];
      $reg = $_POST ["ureg"];
      $name = $_POST ["name"];
      $auth = array (
        "urollno"=> $roll,
        "uid"=> $reg,
        "name"=> $name
      ) ;

      $major = $_POST ["MajorSubject"];
      $minor = $_POST ["MinorSubject"];
      $aec = $_POST ["AbilityEnhancementCourse"];
      $vac1 = $_POST ["ValueAddedCourse1"];
      $vac2 = $_POST ["ValueAddedCourse2"];
      $phone = $_POST ["Phone"];
      $email = $_POST ["Email"];
      $sql = "UPDATE students set phone = '$phone', mail = '$email', md='$md', major = '$major', minor = '$minor', aec = '$aec', vac1 = '$vac1', vac2 = '$vac2' where urollno = '$roll' and uid = '$reg'";
      //  var_dump ($sql);
      $ret = $db -> query ($sql) ->fetch () ;

      //  var_dump ($ret);
      if ($ret === false) {
        ?>
        <div></div>
        <script>
          Swal.fire(
          'Application submitted successfully',
          'Your form was filled successfully.',
          'success'
        ) ;
        </script>
        <?php
      }
    }
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
        <?php }  else  {
          if ($_POST ["md"] != null) {?>
            <div class="alert alert-success h3"><i class="fa-solid fa-circle-check me-2"></i> Form filled successfully</div>
          <?php } ?>
          Name / Father's Name / Mother's Name: <h3 class="text-center"><?php echo $auth ["name"] ;?></h3>
          University Roll Number: <h3 class="text-center"><?php echo $auth ["urollno"] ;?></h3>
          University Registration Number: <h3 class="text-center"><?php echo $auth ["uid"] ;?></h3>

          <div class="d-flex justify-content-center">
            <a href="javascript:logout ()" class="btn btn-danger shadow">Logout</a>
          </div>
          <?php foreach ($fields as $f) { ?>
            <div class="input-group m-2">
              <span class="input-group-text" id="basic-addon1"><?php echo $f ;?></span>
              <input required id="<?php echo str_replace (" ", "", $f);?>"  name="<?php echo str_replace (" ", "", $f);?>" type="text" class="form-control" >
            </div>
          <?php } ?>
          <div class="input-group mb-3">
            <label class="input-group-text bg-info text-white" for="inputGroupSelect01">Multi Disciplinary</label>
            <select name="md" class="form-select" id="md">
              <?php foreach ($subjects as $stream_ => $subject) {
                if ($stream == $stream_)
                  continue ;
                foreach ($subject as $s)
                  echo "<option>$s</option>";
              }
              ?>
            </select>
          </div>

          <div class="form-check" id="check">
            <input required class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
              This is my final choice for Multidisciplinary subject, and <b class="text-danger">I understand this subject cannot be later on</b>.
            </label>
          </div>
        <?php } ?>

        <input type="hidden" name="uroll" value="<?php echo $auth ["urollno"] ;?>">
        <input type="hidden" name="ureg" value="<?php echo $auth ["uid"] ;?>">
        <input type="hidden" name="name" value="<?php echo $auth ["name"] ;?>">
        <button id="submit" type="submit" class="btn btn-primary m-2 shadow">Submit</button>
      </div>
    </form>
  </body>
</html>

<script>
  if (data != null) {
    for (i in data) {
      el = document.getElementById (i)
      if (el) {
        if (data [i] != null)
          el.value = data [i]
        if (data ["md"] != null) {
          el.setAttribute ("disabled", true)
        }
      }
      else
        console.error (`cannot find element ${i}`)

      if (data.hasOwnProperty ("md")) {
        document.getElementById ("submit").classList.add ("d-none")
        document.getElementById ("check").classList.add ("d-none")
      }
    }
  }

function logout () {
  Swal.fire({
  title: 'Log out?',
  text: "Are you sure you want to log out?",
  icon: 'warning',
  showCancelButton: true,
  cancelButtonColor: '#3085d6',
  confirmButtonColor: '#d33',
  confirmButtonText: 'Logout'
}).then((result) => {
  if (result.isConfirmed) {
    /*
    Swal.fire(
      'Logged out',
      'You have been logged out.',
      'success'
    )
    */
   location.href = "/"
  }
})  
}
</script>