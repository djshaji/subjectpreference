<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
if($_SERVER['SERVER_NAME'] != "admission6.devikacloud.in" && filter_var($_SERVER ["HTTP_X_FORWARDED_FOR"], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
  header("Location: https://admission6.devikacloud.in");
  // $ip = $_SERVER ["REMOTE_ADDR"] ;
  // echo "<div class='alert alert-info'>" ;
  // var_dump ($_SERVER) ;
  // echo "</div>";
  die();
    
}

$full = false ;
$CAPPING = 85 ;
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
  "Class Roll Number",
  // "Major Subject",
  // "Minor Subject",
  "Ability Enhancement Course",
  "Value Added Course 1",
  "Value Added Course 2"
];

$fields_tooltip = [
  "Enter WhatsApp Phone Number",
  "Enter Working Email for notification",
  "in Semester 1",
  "in Semester 1",
  "in Semester 1",
  "in Semester 1",
  "in Semester 1",
  "in Semester 1"
];

$_fields = array (
  "phone" => "Phone",
  "mail" => "Email",
  "crollno"=> "ClassRollNumber",
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
    $ret = $db -> query ($sql) ->fetchAll () ;
    if ($ret === false)
      $ret = [] ;
    if (sizeof ($ret) >= $CAPPING) {
      echo "<div></div>";
      $full = true ;
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
      $crollno = $_POST ["ClassRollNumber"];
      $aec = $_POST ["AbilityEnhancementCourse"];
      $vac1 = $_POST ["ValueAddedCourse1"];
      $vac2 = $_POST ["ValueAddedCourse2"];
      $phone = $_POST ["Phone"];
      $email = $_POST ["Email"];
      $sql = "UPDATE students set crollno = '$crollno', phone = '$phone', mail = '$email', md='$md', major = '$major', minor = '$minor', aec = '$aec', vac1 = '$vac1', vac2 = '$vac2' where urollno = '$roll' and uid = '$reg'";
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
<script>

subjects = {
  "Science": [
    "Bio-Technology",
    "Botany",
    "Chemistry",
    "Computer Applications",
    "Electronics",
    "Geography",
    "Geology",
    "Mathematics",
    "Physics",
    "Sericulture",
    "Statistics",
    "Zoology"
  ], "Arts": [
    "Business Management",
    "Dogri",
    "English / English Literature",
    "Hindi",
    "Management",
    "Marketing Management",
    "Music",
    "Urdu"
  ], "Social": [
    "Education",
    "Philosophy",
    "Psychology",
    "Public Administration",
    "Economics",
    "History",
    "Political Science",
    "Sociology"
  ], "BCA": [
    "Problem Solving using C",
    "Computer Fundamentals"
  ]
} ;

multi = {
  "Science": [
    "Computer Applications",
    "Geography",
    "Geology",
    "Mathematics",
    "Sericulture",
    "Statistics"
  ], "Arts": [
    "English",
    "Hindi"
  ], "Social": [
    "Education",
    "Psychology",
    "Public Administration",
    "Economics",
    "Political Science",
    "Sociology"
  ]
} ;
</script>
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
        <img class="img-fluid col-12" src="logo.png" width="300">
        <h4 class="p-2 alert alert-primary m-2 text-center"><i class="fa-solid fa-pen-to-square me-2"></i>Semester 2 Subject Preference</h4>
        <?php if ($auth == null) {?>
        <div class="m-2 alert alert-warning shadow">
        The  enrolment  process for Semester-2nd is commencing in 1st week of March, 2023 vide University letter <b>No.Exam/BP-I/2023/7818-7903 dated: 27-02-2023</b> and as per the University statutes (NEP-2020), the Multidisciplinary Course shall not be repeated in any semester. <br><br>
        In this regard <b>all the students of Semester 1st are directed to fill this form for allotment of MD/ID by or before <b class="text-danger"> March 10, 2023.</b>  </b><br><br>The choice of MD subject is with the condition that <ol><li>the student will choose his/her MD subject from the stream other than the stream of his/her Major Course</li><li> the allotment shall be done on First Come First serve basis.</li></ol>           
        </div>
        <div class="input-group  m-2 mt-3">
          <span class="input-group-text" id="basic-addon1">University Roll No</span>
          <input required name="roll" type="text" class="form-control" placeholder="Enter roll number" aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <div class="input-group m-2">
          <span class="input-group-text" id="basic-addon1">University Registration No</span>
          <input required name="reg" type="text" class="form-control" placeholder="Registration number" aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <div class="form-check m-2" id="check">
          <input required class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault">
            I agree to abide by guidelines of subject preference as prescribed.
          </label>
        </div>

        <?php }  else  {
          if (!$full && ($_POST ["md"] != null || $auth ["md"] != null)) {?>
            <div class="alert alert-success h3"><i class="fa-solid fa-circle-check me-2"></i> Form filled successfully</div>
          <?php } ?>
          Name / Father's Name / Mother's Name: <h3 class="text-center"><?php echo $auth ["name"] ;?></h3>
          University Roll Number: <h3 class="text-center"><?php echo $auth ["urollno"] ;?></h3>
          University Registration Number: <h3 class="text-center"><?php echo $auth ["uid"] ;?></h3>

          <div class="d-flex justify-content-center">
            <a href="javascript:logout ()" class="btn btn-danger shadow">Logout</a>
          </div>

          <div class="input-group m-2 mt-3">
            <label class="input-group-text bg-info text-white" for="inputGroupSelect01">Major Subject</label>
            <select required onchange="check()" name="MajorSubject" class="form-select" id="MajorSubject">
            </select>
          </div>

          <div class="input-group m-2">
            <label class="input-group-text bg-info text-white" for="inputGroupSelect01">Minor Subject</label>
            <select required  name="MinorSubject" class="form-select" id="MinorSubject">
            </select>
          </div>

          <?php $counter = 0 ; foreach ($fields as $f) { ?>
            <div class="input-group m-2">
              <span class="input-group-text" id="basic-addon1"><?php echo $f ;?></span>
              <input placeholder="<?php echo $fields_tooltip[$counter];$counter ++ ;?>" required id="<?php echo str_replace (" ", "", $f);?>"  name="<?php echo str_replace (" ", "", $f);?>" type="text" class="form-control" >
            </div>
          <?php } ?>
          <div class="input-group mb-3">
            <label class="input-group-text bg-danger text-white" for="inputGroupSelect01">Semester 1 Multi Disciplinary</label>
            <select required onchange="check ()" name="md1" class="form-select" id="md1">
              <option></option>
              <?php /* foreach ($subjects as $stream_ => $subject) {
                if ($stream == $stream_)
                  continue ;
                foreach ($subject as $s)
                  echo "<option>$s</option>";
              } */
              ?>
            </select>
          </div>

          <div class="input-group mb-3">
            <label class="input-group-text bg-info text-white" for="inputGroupSelect01">Semester 2 Multi Disciplinary</label>
            <select required onchange="check ()"  name="md" class="form-select" id="md">
              <option></option>
              <?php /* foreach ($subjects as $stream_ => $subject) {
                if ($stream == $stream_)
                  continue ;
                foreach ($subject as $s)
                  echo "<option>$s</option>";
              } */
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

      if (data ["md"] != null) {
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
   location.href = location.href
  }
})  
}

function check () {
  md1 = document.getElementById ("md1").value
  md2 = document.getElementById ("md").value
  maj = document.getElementById ("MajorSubject").value

  majStream = "1"
  mdStream = "2"
  for (stream of [
    "Arts",
    "Science",
    "Social"
  ]) {
    if (subjects [stream] == null) console.error (`no ${stream} in subjects!`)
    if (subjects [stream].indexOf (maj) != -1) majStream = stream
    if (multi [stream].indexOf (md2) != -1) mdStream = stream
  }

  console.log (`${maj}: ${majStream}\t\t${md2}: ${mdStream}`)

  if (majStream == mdStream) {
    document.getElementById ("md").value = ""
    Swal.fire(
        'Multi Disciplinary and Major Subjects must be from different streams',
        `Multi disciplinary subject must be from a different stream than Major Subject Stream . Please choose another Multidisciplinary subject.<br><br>${md2} and ${maj} are both in ${majStream}`,
        'error'
      ) ;
    
    
  }

  if (md1 == "" && md2 == "") return 

  if (md1 == md2) {
    document.getElementById ("md").value = ""
    Swal.fire(
        'Multi Disciplinary Subject must not be same',
        `Multi disciplinary subject must not be same as taken in Semester 1.\n\nPlease choose another subject.`,
        'error'
      ) ;
    
  }
}

mj = document.getElementById ("MajorSubject")
mi = document.getElementById ("MinorSubject")

for (stream in subjects) {
  option1 = document.createElement ("option")
  option2 = document.createElement ("option")
  option1.setAttribute ("disabled", 1)
  option2.setAttribute ("disabled", 1)
  option1.innerText = stream
  option2.innerText = stream
  mj.appendChild (document.createElement ("option"))
  mi.appendChild (document.createElement ("option"))
  mj.appendChild (option1)
  mi.appendChild (option2)

  for (subject of subjects [stream]) {
    option1 = document.createElement ("option")
    option2 = document.createElement ("option")

    option1.innerText = subject
    option1.setAttribute ("value", subject)
    mj.appendChild (option1)

    option2.innerText = subject
    option2.setAttribute ("value", subject)
    mi.appendChild (option2)
  }
}

mj = document.getElementById ("md1")
mi = document.getElementById ("md")


for (stream in multi) {
  option1 = document.createElement ("option")
  option2 = document.createElement ("option")
  option1.setAttribute ("disabled", 1)
  option2.setAttribute ("disabled", 1)
  option1.innerText = stream
  option2.innerText = stream
  mj.appendChild (document.createElement ("option"))
  mi.appendChild (document.createElement ("option"))
  mj.appendChild (option1)
  mi.appendChild (option2)

  for (subject of multi [stream]) {
    option1 = document.createElement ("option")
    option2 = document.createElement ("option")

    option1.innerText = subject
    option1.setAttribute ("value", subject)
    mj.appendChild (option1)

    option2.innerText = subject
    option2.setAttribute ("value", subject)
    mi.appendChild (option2)
  }
}

</script>
