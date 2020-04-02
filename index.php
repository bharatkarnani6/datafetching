<!DOCTYPE html>
<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Website Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
    table{border-style:solid;
          border-width:3px;
          border-color:blue;
        }
      </style>
  </head>
  <body>
      <?php
        $host="localhost";
        $user="root";
        $password="";
        $con=mysqli_connect($host,$user,$password);
        $dbname=mysqli_select_db($con,"website");
        $querytype="select Type from website_data group by Type";
        $query_run1=mysqli_query($con,$querytype);
        $data=array();
        if(mysqli_num_rows($query_run1)>0){
          while ($row=mysqli_fetch_assoc($query_run1)){
            $data[]= $row['Type'];
          }
        }
        $querycoun="select Country from website_data group by Country";
        $query_run2=mysqli_query($con,$querycoun);
        $data1=array();
        if(mysqli_num_rows($query_run2)>0){
          while ($row=mysqli_fetch_assoc($query_run2)){
            $data1[]= $row['Country'];
          }
        }
        $search="";
        $type="";
        $lang="";

        $storage=array();
        if($_SERVER["REQUEST_METHOD"]=="POST"){
          if(isset($_POST['submit'])){
            if($_POST["search"]===''){
              $search=null;
            }else{
              $search=$_POST["search"];
            }
            if($_POST["type"]===''){
              $type=null;
            }else{
              $type=$_POST["type"];
            }
            if($_POST["Country"]===''){
              $Country=null;
            }else{
              $Country=$_POST["Country"];
            }
          }
        }
        $Country3=$_GET['Country3'];
        define('bharat',"$Country3");


        $type3=$_GET['type3'];
        define('bharat1',"$type3");

        $search3=$_GET['search3'];
        define('bharat2',"$search3");


       ?>
      <div class="jumbotron container" style="width: 550px; ">
        <center><h1>Website Data Fetch</h1></center><br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group ">
            <label for="exampleFormControlInput1">Search</label>
            <input type="text" class="form-control" name="search">
          </div>
          <div class="form-group">
            <label for="exampleFormControlInput1">Type</label>
            <?php
                echo "<select class='form-control' id='exampleFormControlSelect1' name='type'>";
                echo "<option value=''></option>";
                for($i=0;$i<sizeof($data);$i++){
                  echo "<option value='$data[$i]'>$data[$i]</option>";
                }
                echo "</select>";
             ?>
          </div>
          <div class="form-group">
            <label for="exampleFormControlInput1">Country</label>
            <?php
              echo "<select class='form-control' id='exampleFormControlSelect1' name='Country'>";
              echo "<option value=''></option>";
              for($i=0;$i<sizeof($data1);$i++){
                echo "<option value='$data1[$i]'>$data1[$i]</option>";
              }
              echo "</select>";
             ?>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <button type="submitreset" class="btn btn-primary">Reset</button>
          </form>
<br><br>
  <center>
    <?php
    echo "<table border= '2'>
      <tr>
      <th>No.</th>
      <th>Url</th>
      <th>Country</th>
      <th>Type</th>
      </tr>";

      switch (True) {

        case ((!empty($Country) AND !empty($search) AND !is_NULL($type))||(!empty(bharat) AND !empty(bharat2) AND !empty(bharat1))):
            $sql="select * from website_data where (Url like '%".$search."%' AND Country='$Country' AND Type='$type')or(Url like '".bharat2."' AND Country='".bharat."'AND Type='".bharat1."')";
            $result = mysqli_query($con, $sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/3);

            $page=intval($_GET['page']);
            if($page==""|| $page=="1"){
              $page1=0;
            }else {
              $page1=($page-1)*3;
            }

            $country4= ($Country==null)?bharat:$Country;
            $search4= ($search==null)?bharat2:$search;
            $type4= ($type==null)?bharat1:$type;

            $queries="Select Url,Country,Type from website_data where (Url like '%".$search."%' AND Country='$Country' AND Type='$type')or(Url like '".bharat2."' AND Country='".bharat."'AND Type='".bharat1."')";
            $query_run9=mysqli_query($con,$queries);
            if(mysqli_num_rows($query_run9)>0)
            {
              $i=1;
              while ($row=mysqli_fetch_assoc($query_run9))
              {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['Url'] . "</td>";
                echo "<td>" . $row['Country'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "</tr>";
                $i=$i+1;
              }
              echo "</table>";
            }
            echo '<br>';
            echo '<nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center">';
            for ($b=1;$b<=$number_of_pages;$b++) {
              echo '<li class="page-item">';
              echo '<a href="index.php?page=' . $b . '& search3='.$search4.' & Country3='.$Country4.'& type3='.$type4.'" class="page-link">' . $b . '</a> ';
            }
            break;
        case ((!empty($Country) AND !empty($search))||(!empty(bharat) AND !empty(bharat2))):
            $sql="select * from website_data where (Url like '%".$search."%' AND Country='$Country')or(Url like '".bharat2."' AND Country='".bharat."')";
            $result = mysqli_query($con, $sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/3);

            $page=intval($_GET['page']);
            if($page==""|| $page=="1"){
              $page1=0;
            }else {
              $page1=($page-1)*3;
            }

            $country4= ($Country==null)?bharat:$Country;
            $search4= ($search==null)?bharat2:$search;

            $queries="Select Url,Country,Type from website_data where (Url like '%".$search."%' AND Country='$Country') or(Url like '".bharat2."' AND Country='".bharat."') limit $page1,3";
            $query_run9=mysqli_query($con,$queries);
            if(mysqli_num_rows($query_run9)>0)
            {
              $i=1;
              while ($row=mysqli_fetch_assoc($query_run9))
              {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['Url'] . "</td>";
                echo "<td>" . $row['Country'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "</tr>";
                $i=$i+1;
              }
              echo "</table>";
            }
            echo '<br>';
            echo '<nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center">';
            for ($b=1;$b<=$number_of_pages;$b++) {
              echo '<li class="page-item">';
              echo '<a href="index.php?page=' . $b . '& search3='.$search4.' & Country3='.$Country4.'" class="page-link">' . $b . '</a> ';
            }
            break;

        case ( (!empty($type) AND !empty($search)) || (!empty(bharat1) AND !empty(bharat2)) ):
            $sql="select * from website_data where (Url like '%".$search."%' AND Type='$type')or(Url like '".bharat2."' AND Type='".bharat1."')";

            $result = mysqli_query($con, $sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/3);
            $number_of_pages = ceil($number_of_results/3);


            $page=intval($_GET['page']);
            if($page==""|| $page=="1"){
              $page1=0;
            }else {
              $page1=($page-1)*3;
            }

            $type4= ($type==null)?bharat1:$type;
            $search4= ($search==null)?bharat2:$search;


            $queries="Select Url,Country,Type from website_data where (Url like '%".$search."%' AND Type='$type') or(Url like '".bharat2."' AND Type='".bharat1."') limit $page1,3 ";

            $query_run9=mysqli_query($con,$queries);
            if(mysqli_num_rows($query_run9)>0)
            {
              $i=1;
              while ($row=mysqli_fetch_assoc($query_run9))
              {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['Url'] . "</td>";
                echo "<td>" . $row['Country'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "</tr>";
                $i=$i+1;
              }
              echo "</table>";
            }
            echo '<br>';
            echo '<nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center">';
            for ($b=1;$b<=$number_of_pages;$b++) {
              echo '<li class="page-item">';
              echo '<a href="index.php?page=' . $b . '& search3='.$search4.' & type3='.$type4.'" class="page-link">' . $b . '</a> ';
            }
            break;

        case ((!empty($type) AND !empty($Country))|| (!empty(bharat) AND !empty(bharat1))):
            $sql="select * from website_data where (Country='$Country' AND Type='$type')or(Country='".bharat."' AND Type='".bharat1."')";
            $result = mysqli_query($con, $sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/3);

            $page=intval($_GET['page']);
            if($page==""|| $page=="1"){
              $page1=0;
            }else {
              $page1=($page-1)*3;
            }

            $type4= ($type==null)?bharat1:$type;
            $country4=($Country==null)?bharat:$Country;


            $queries="select Url,Country,Type from website_data where (Country='$Country' AND Type='$type') or(Country='".bharat."' AND Type='".bharat1."')   limit $page1,3";

            $query_run9=mysqli_query($con,$queries);
            if(mysqli_num_rows($query_run9)>0)
            {
              $i=1;
              while ($row=mysqli_fetch_assoc($query_run9))
              {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['Url'] . "</td>";
                echo "<td>" . $row['Country'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "</tr>";
                $i=$i+1;
              }
              echo "</table>";
            }
            echo '<br>';
            echo '<nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center">';
            for ($b=1;$b<=$number_of_pages;$b++) {
              echo '<li class="page-item">';
              echo '<a href="index.php?page=' . $b . '& Country3='.$country4.' & type3='.$type4.'" class="page-link">' . $b . '</a> ';
            }
            break;

        case (!empty($search) || !empty(bharat2)):
            $sql="select * from website_data where Url like '%".$search."%' or  Url like '".bharat2."' ";
            $result = mysqli_query($con, $sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/3);

            $page=intval($_GET['page']);
            if($page==""|| $page=="1"){
              $page1=0;
            }else {
              $page1=($page-1)*3;
            }

            $search4= ($search==null)?bharat2:$search;
            $querysea="Select Url,Country,Type from website_data where Url like '%".$search."%' or  Url like '".bharat2."' limit $page1,3";
            $query_run4=mysqli_query($con,$querysea);
            if(mysqli_num_rows($query_run4)>0)
            {
              $i=1;
              while ($row=mysqli_fetch_assoc($query_run4)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['Url'] . "</td>";
                echo "<td>" . $row['Country'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "</tr>";
                $i=$i+1;
              }
              echo "</table>";
            }else{
              echo "<em> <b> Nothing Found </b> </em>";
            }
            echo '<br>';
            echo '<nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center">';
            for ($b=1;$b<=$number_of_pages;$b++) {
              echo '<li class="page-item">';
              echo '<a href="index.php?page=' . $b . '& search3='.$search4.'" class="page-link">' . $b . '</a> ';
            }
            break;
        case (!empty($type) || !empty(bharat1)):

            $sql="select * from website_data where Type='$type' or Type='".bharat1."' ";
            $result = mysqli_query($con, $sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/3);

            $page=intval($_GET['page']);
            if($page==""|| $page=="1"){
              $page1=0;
            }else {
              $page1=($page-1)*3;
            }

            $type4= ($type==null)?bharat1:$type;

            $querytype1="select Url,Country,Type from website_data where Type='$type' or Type='".bharat1."' limit $page1,3";

            $query_run5=mysqli_query($con,$querytype1);
            if(mysqli_num_rows($query_run5)>0)
            {
              $i=1;
              while ($row=mysqli_fetch_assoc($query_run5))
              {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['Url'] . "</td>";
                echo "<td>" . $row['Country'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "</tr>";
                $i=$i+1;
              }
              echo "</table>";
            }
            echo '<br>';
            echo '<nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center">';
            for ($b=1;$b<=$number_of_pages;$b++) {
              echo '<li class="page-item">';
              echo '<a href="index.php?page=' . $b . '& type3='.$type4.'" class="page-link">' . $b . '</a> ';
            }

            break;

        case (!empty($Country) || !empty(bharat)):
            //$results_per_page = 2;
            $sql="SELECT * FROM website_data where Country='$Country' or Country='".bharat."' ";
            $result = mysqli_query($con, $sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/3);

            $page=intval($_GET['page']);
            if($page==""|| $page=="1"){
              $page1=0;
            }else {
              $page1=($page-1)*3;
            }

            $country4=($Country==null)?bharat:$Country;



            $querytype2="SELECT Url,Country,Type FROM website_data where Country='$Country' or Country='".bharat."' limit $page1,3";

            $query_run6=mysqli_query($con,$querytype2);
            if(mysqli_num_rows($query_run6)>0)
            {
              $i=1;
              while ($row=mysqli_fetch_assoc($query_run6))
              {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['Url'] . "</td>";
                echo "<td>" . $row['Country'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "</tr>";
                $i=$i+1;
              }
              echo "</table>";

            }

            echo '<br>';
            echo '<nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center">';
            for ($b=1;$b<=$number_of_pages;$b++) {
              echo '<li class="page-item">';
              echo '<a href="index.php?page=' . $b . '& Country3='.$country4.'" class="page-link">' . $b . '</a> ';
            }

              break;

         }

mysqli_close($con);

     ?>
   </center>
</div>
  </body>
</html>
