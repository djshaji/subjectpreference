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

<script>data = {}</script>
<?php
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

$db = new PDO ("mysql:host=localhost;dbname=admission22;charset=utf8mb4", "ftop", "jennahaze");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = "SELECT * from students;";
$ret = $db -> query ($sql) ->fetchAll () ;

$data = array () ;
foreach ($ret as $row) {
  $data [$row ["urollno"]] = $row ;
}

echo "<script>data = " .json_encode ($data). "</script>";
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
    
    <div method="post" class="row  justify-content-center">
      <div class="border shadow p-4 col-10 m-5 row justify-content-center d-flex">
        <img class="img-fluid col-md-5" src="logo.png" width="300">
        <h4 class="p-2 alert alert-primary m-2 text-center"><i class="fa-solid fa-pen-to-square me-2"></i>Semester 2 Subject Preference</h4>
      </div>
      <div class="row col-12 justify-content-center"  id="main">

      </div>
    </div>
</body>

<script>
stats = {}
for (d in data) {
  if ((data [d]['md']) == null)
    continue ;
  if (stats [data [d]['md']] == null) {
    stats [data [d]['md']] = 0 ;
  }

  stats [data [d]['md']] ++ ;
}

for (s in stats) {
  card = document.createElement ("div")
  card.classList.add ("col-md-3")
  card.classList.add ("m-3")
  card.classList.add ("p-3")
  card.classList.add ("shadow")
  card.classList.add ("border")
  document.getElementById ("main").appendChild (card)
  _c = "bg-success"
  if (stats [s] > 70)
    _c = "bg-warning"
  if (stats [s] > 79)
    _c = "bg-danger"
  card.innerHTML =
    `<div class="card-body">
        <h6 class="card-subtitle  text-muted">${s}</h6>
        <h2 class="p-2 card-title">${stats [s]} / 80</h5>
        <div class="progress">
          <div class="progress-bar  ${_c}" role="progressbar" style="width: ${stats [s]}%;" aria-valuenow="${stats [s]}" aria-valuemin="0" aria-valuemax="80">${stats [s]}</div>
        </div>
      </div>`

}

</script>
