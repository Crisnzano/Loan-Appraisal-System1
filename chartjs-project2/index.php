<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web based loan appraisal system Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <!-- The bootstrap 5 tutorial is available here: https://www.w3schools.com/bootstrap5/index.php 
    and here:https://getbootstrap.com/docs/5.0/getting-started/introduction/ -->
    <!-- The Chart JS manual is available here: https://www.chartjs.org/docs/latest/charts/area.html -->
    <div class="row">
      <div class="col-md-2 bg-light bg-gradient">
        <h1>Customer-Facing Analytics Dashboard</h1>
        <br />
        <strong>Kaplan and Norton’s Balanced Scorecard</strong>
          <ul>
            
            <li>Customer Perspective (KPI2a and KPI2b)</li>

            <div> &nbsp
        <a href="../Client.php">
            <button type="button" class="btn btn-primary">Go Back</button>
        </a>
            </div>
      
          </ul>
      </div>
      <div class="col-md-10 row">
  <!-- Start of Key Metrics -->
  <?php
  function humanize_number($input){
    $input = number_format($input);
    $input_count = substr_count($input, ',');
    if($input_count != '0'){
        if($input_count == '1'){
            return substr($input, 0, -4).'K';
        } else if($input_count == '2'){
            return substr($input, 0, -8).'M';
        } else if($input_count == '3'){
            return substr($input, 0,  -12).'B';
        } else {
            return;
        }
    } else {
        return $input;
    }
  }
  ?>
  <?php
  include 'dbconfig.php';

  // Create connection
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  $sql = "SELECT SUM(`loan_repayment`.`monthly_repayment_amount`) AS totalRevenue FROM `loan_repayment` WHERE YEAR(`loan_repayment`.`repayment_start_date`) = '2022';";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $totalRevenue = $row['totalRevenue'];
    }
  } else {
    echo "0 results";
  }

  $sql = "SELECT SUM(`loan_repayment`.`defaults_number`) AS totalDefaulters FROM `loan_repayment`"; //WHERE (`loan_repayment`.`defaulters_number`) > '3';
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $totalDefaulters = $row['totalDefaulters'];
    }
  } else {
    echo "0 results";
  }

  $sql = "SELECT SUM(`loans`.`loan_amount`) AS totalLoanAmount FROM `loans` WHERE (`loans`.`loan_status`) = '2';";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $totalLoanAmount = $row['totalLoanAmount'];
    }
  } else {
    echo "0 results";
  }

  $sql = "SELECT COUNT(*) AS totalClients FROM `client`";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $totalClients = $row['totalClients'];
    }
  } else {
    echo "0 results";
  }
  $conn->close();
  
  ?>
  <div class="col-md-3 my-1">
        <div class="card">
            <div class="card-body text-center">
              <strong>Total Profit Revenue (topline)</strong><hr>
              <h1>
                KES <?= humanize_number($totalRevenue) ?>
              </h1>
            </div>
        </div>
  </div>
  
  <div class="col-md-3 my-1">
        <div class="card">
            <div class="card-body text-center">
              <strong>Number of defaulters</strong><hr>
              <h1>
                <?= humanize_number($totalDefaulters) ?>
              </h1>
            </div>
        </div>
  </div>
  <div class="col-md-3 my-1">
        <div class="card">
            <div class="card-body text-center">
              <strong>Total money lent</strong><hr>
              <h1>
               KES <?= humanize_number($totalLoanAmount) ?>
              </h1>
            </div>
        </div>
  </div>
  <div class="col-md-3 my-1">
        <div class="card">
            <div class="card-body text-center">
              <strong>Total number of clients</strong><hr>
              <h1>
                <?= humanize_number($totalClients) ?>
              </h1>
            </div>
        </div>
  </div>
  <!-- End of Key Metrics -->

    <!-- Start of KPI DIVs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php include 'kpi2.php'; ?>
    <!-- End of KPI DIVs -->
  </body>
</html>