<!-- Data for KPI1a: Top 5 selling products of the year-->
<?php
  $currentYear_top5LoanPlans = 2023;
  $monthlyCustomerRetention_target = 25000; //$salesPerProduct_target 

  $currentYear_monthlyLoanRevenue = 2023; //currentYear_monthlySalesRevenue
  $previousYear_monthlyLoanRevenue = $currentYear_monthlyLoanRevenue - 1; //previousYear_monthlySalesRevenue
  $monthlyLoanRevenue_target = 30000;

?>
<?php
  include 'dbconfig.php';

  // Create connection
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  $sql = "CALL `TopPerformingLoanType`($currentYear_top5LoanPlans);";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row_num = array();
    $planID = array(); //productCode
    $ProfitAmount = array(); //productLine
    $fullLoanDetails = array(); //fullProductDetails
    $sumRepaymentEach = array(); //sumPriceEach
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $row_num[$row['row_num']] = $row['row_num'];
      $planID[$row['row_num']] = $row['countTypeID'];
      $ProfitAmount[$row['row_num']] = $row['sumRepaymentAmount'];
      $fullLoanDetails[$row['row_num']] = $row['fullTypeDetails'];
      $sumRepaymentEach[$row['row_num']] = $row['sumRepaymentAmount'];
    }
  } else {
    "0 results";
  }
  
  $conn->close();

  /* Getting the product details of the top 5 products */
  // echo "TESTING: The full product details of the best performing product  is '" . $fullProductDetails['1'] . "'<br>";

  $fullLoanDetails1 = array();
  $fullLoanDetails2 = array();
  $fullLoantDetails3 = array();
  $fullLoanDetails4 = array();
  $fullLoanDetails5 = array();

  $fullLoanDetails1 = !isset($fullLoanDetails['1']) ? null : $fullLoanDetails['1'];
  $fullloanDetails2 = !isset($fullLoanDetails['2']) ? null : $fullLoanDetails['2'];
  $fullLoanDetails3 = !isset($fullLoantDetails['3']) ? null : $fullLoanDetails['3'];
  $fullLoanDetails4 = !isset($fullLoanDetails['4']) ? null : $fullLoanDetails['4'];
  $fullLoanDetails5 = !isset($fullLoanDetails['5']) ? null : $fullLoanDetails['5'];

  $currentYear_monthlyLoanRevenueTop5LoanPlansfullLoanDetails = array($fullLoanDetails1, $fullLoanDetails2, 
                                                    $fullLoanDetails3, $fullLoanDetails4, 
                                                    $fullLoanDetails5);
  $jsonCurrentYearTop5LoanPlansfullLoanDetails = json_encode($currentYear_monthlyLoanRevenueTop5LoanPlansfullLoanDetails);
  // echo "TESTING: The JSON values are " . $jsonCurrentYearTop5SellingfullProductDetails;


  /* Getting the sales revenue earned by the top 5 products in the current year */
  
  // echo "TESTING: The total amount earned by the best performing product  is '" . $sumPriceEach['1'] . "'<br>";

  $sumRepaymentEach1 = array();
  $sumRepaymentEach2 = array();
  $sumRepaymentEach3 = array();
  $sumRepaymentEach4 = array();
  $sumRepaymentEach5 = array();

  $sumRepaymentEach1 = !isset($sumRepaymentEach['1']) ? null : $sumRepaymentEach['1'];
  $sumRepaymentEach2 = !isset($sumRepaymentEach['2']) ? null : $sumRepaymentEach['2'];
  $sumRepaymentEach3 = !isset($sumRepaymentEach['3']) ? null : $sumRepaymentEach['3'];
  $sumRepaymentEach4 = !isset($sumRepaymentEach['4']) ? null : $sumRepaymentEach['4'];
  $sumRepaymentEach5 = !isset($sumRepaymentEach['5']) ? null : $sumRepaymentEach['5'];

  $currentYearTop5LoanPlansSumRepaymentEach = array($sumRepaymentEach1, $sumRepaymentEach2, 
                                                    $sumRepaymentEach3, $sumRepaymentEach4, 
                                                    $sumRepaymentEach5);
  $jsonCurrentYearTop5LoanPlansSumRepaymenteEach = json_encode($currentYearTop5LoanPlansSumRepaymentEach);
  // echo "TESTING: The JSON values are " . $jsonCurrentYearTop5SellingSumPriceEach;
?>

<!-- Data for KPI 1b: Year-on-Year Monthly Sales Revenue-->
<?php
  include 'dbconfig.php';

  // Create connection
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  $sql = "CALL `ProfitTrend`($currentYear_top5LoanPlans);";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $current_january = array();
    $current_february = array();
    $current_march = array();
    $current_april = array();
    $current_may = array();
    $current_june = array();
    $current_july = array();
    $current_august = array();
    $current_september = array();
    $current_october = array();
    $current_november = array();
    $current_december = array();
    $salesRevenue = array();
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $salesRevenue[$row['paymentYear']][$row['paymentMonth']] = $row['salesRevenue'];
    }
  } else {
    echo "0 results";
  }
  
  $conn->close();

  // echo "TESTING: The value for $currentYear_monthlySalesRevenue February is " . $salesRevenue[$currentYear_monthlySalesRevenue]['February'] . "<br>";
  
  /* Monthly sales revenue for the current year (for a year-on-year comparison) */
  /* January */
  $current_january = !isset($salesRevenue[$currentYear_monthlyLoanRevenue]['January']) ? null : $salesRevenue[$currentYear_monthlyLoanRevenue]['January'];
  /* February */
  $current_february = !isset($salesRevenue[$currentYear_monthlyLoanRevenue]['February']) ? null : $salesRevenue[$currentYear_monthlyLoanRevenue]['February'];
  /* March */
  $current_march = !isset($salesRevenue[$currentYear_monthlyLoanRevenue]['March']) ? null : $salesRevenue[$currentYear_monthlyLoanRevenue]['March'];
  /* April */
  $current_april = !isset($salesRevenue[$currentYear_monthlyLoanRevenue]['April']) ? null : $salesRevenue[$currentYear_monthlyLoanRevenue]['April'];
  /* May */
  $current_may = !isset($salesRevenue[$currentYear_monthlyLoanRevenue]['May']) ? null : $salesRevenue[$currentYear_monthlyLoanRevenue]['May'];
  /* June */
  $current_june = !isset($salesRevenue[$currentYear_monthlyLoanRevenue]['June']) ? null : $salesRevenue[$currentYear_monthlyLoanRevenue]['June'];
  /* July */
  $current_july = !isset($salesRevenue[$currentYear_monthlyLoanRevenue]['July']) ? null : $salesRevenue[$currentYear_monthlyLoanRevenue]['July'];
  /* August */
  $current_august = !isset($salesRevenue[$currentYear_monthlyLoanRevenue]['August']) ? null : $salesRevenue[$currentYear_monthlyLoanRevenue]['August'];
  /* September */
  $current_september = !isset($salesRevenue[$currentYear_monthlyLoanRevenue]['September']) ? null : $salesRevenue[$currentYear_monthlyLoanRevenue]['September'];
  /* October */
  $current_october = !isset($salesRevenue[$currentYear_monthlyLoanRevenue]['October']) ? null : $salesRevenue[$currentYear_monthlyLoanRevenue]['October'];
  /* November */
  $current_november = !isset($salesRevenue[$currentYear_monthlyLoanRevenue]['November']) ? null : $salesRevenue[$currentYear_monthlyLoanRevenue]['November'];
  /* December */
  $current_december = !isset($salesRevenue[$currentYear_monthlyLoanRevenue]['December']) ? null : $salesRevenue[$currentYear_monthlyLoanRevenue]['December'];

  $currentYear_monthlyLoanRevenueSalesRevenueChartValues = array($current_january, $current_february, $current_march,
  $current_april, $current_may, $current_june,
  $current_july, $current_august, $current_september,
  $current_october, $current_november, $current_december);
  $jsonCurrentYearSalesRevenueChartValues = json_encode($currentYear_monthlyLoanRevenueSalesRevenueChartValues);
  // echo "The JSON values are " . $jsonCurrentYearSalesRevenueChartValues;

  /* Monthly sales revenue for the previous year (for a year-on-year comparison) */
  /* January */
  $previous_january = !isset($salesRevenue[$previousYear_monthlyLoanRevenue]['January']) ? null : $salesRevenue[$previousYear_monthlyLoanRevenue]['January'];
  /* February */
  $previous_february = !isset($salesRevenue[$previousYear_monthlyLoanRevenue]['February']) ? null : $salesRevenue[$previousYear_monthlyLoanRevenue]['February'];
  /* March */
  $previous_march = !isset($salesRevenue[$previousYear_monthlyLoanRevenue]['March']) ? null : $salesRevenue[$previousYear_monthlyLoanRevenue]['March'];
  /* April */
  $previous_april = !isset($salesRevenue[$previousYear_monthlyLoanRevenue]['April']) ? null : $salesRevenue[$previousYear_monthlyLoanRevenue]['April'];
  /* May */
  $previous_may = !isset($salesRevenue[$previousYear_monthlyLoanRevenue]['May']) ? null : $salesRevenue[$previousYear_monthlyLoanRevenue]['May'];
  /* June */
  $previous_june = !isset($salesRevenue[$previousYear_monthlyLoanRevenue]['June']) ? null : $salesRevenue[$previousYear_monthlyLoanRevenue]['June'];
  /* July */
  $previous_july = !isset($salesRevenue[$previousYear_monthlyLoanRevenue]['July']) ? null : $salesRevenue[$previousYear_monthlyLoanRevenue]['July'];
  /* August */
  $previous_august = !isset($salesRevenue[$previousYear_monthlyLoanRevenue]['August']) ? null : $salesRevenue[$previousYear_monthlyLoanRevenue]['August'];
  /* September */
  $previous_september = !isset($salesRevenue[$previousYear_monthlyLoanRevenue]['September']) ? null : $salesRevenue[$previousYear_monthlyLoanRevenue]['September'];
  /* October */
  $previous_october = !isset($salesRevenue[$previousYear_monthlyLoanRevenue]['October']) ? null : $salesRevenue[$previousYear_monthlyLoanRevenue]['October'];
  /* November */
  $previous_november = !isset($salesRevenue[$previousYear_monthlyLoanRevenue]['November']) ? null : $salesRevenue[$previousYear_monthlyLoanRevenue]['November'];
  /* December */
  $previous_december = !isset($salesRevenue[$previousYear_monthlyLoanRevenue]['December']) ? null : $salesRevenue[$previousYear_monthlyLoanRevenue]['December'];

  $previousYear_monthlyLoanRevenueSalesRevenueChartValues = array($previous_january, $previous_february, $previous_march,
                        $previous_april, $previous_may, $previous_june,
                        $previous_july, $previous_august, $previous_september,
                        $previous_october, $previous_november, $previous_december);
  $jsonPreviousYearSalesRevenueChartValues = json_encode($previousYear_monthlyLoanRevenueSalesRevenueChartValues);
  // echo "The JSON values are " . $jsonPreviousYearSalesRevenueChartValues;
?>

<div class="col-md-6 my-1">
    <div class="card">
    <div class="card-body">
    <strong>
      KPI2a (leading): <u>Top performing Loan Type of the Year</u><br>
      Target for the Annual Customer retention per Loan type= <?= number_format($monthlyLoanRevenue_target,2,".",",") ?> <br>
      Current Year = <?= $currentYear_top5LoanPlans ?>
    </strong>
  </div>
    <div class="card-body"><canvas id="KPI2a"></canvas></div>
</div>
</div>
<div class="col-md-6 my-1">
    <div class="card">
    <div class="card-body">
    <strong>
      KPI2b (lagging): <u>Profit Trend</u><br>
      Target for the Annual Profit= <?= number_format($monthlyCustomerRetention_target,2,".",",") ?> <br>
      Current Year = <?= $currentYear_top5LoanPlans ?>
    </strong>
    </div>
    <div class="card-body"><canvas id="KPI2b"></canvas></div>
</div>
</div>
<script>
/* KPI1a */
      const kpi2a = document.getElementById('KPI2a');
    
      new Chart(kpi2a, {
        type: 'bar',
        data: {
          labels: <?= $jsonCurrentYearTop5LoanPlansfullLoanDetails ?>,
          datasets: [{
            label: 'Amount',
            data: <?= $jsonCurrentYearTop5LoanPlansSumRepaymenteEach ?>,
            borderWidth: 1,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            pointStyle: 'rectRounded'
          }, {
            type: 'line',
            label: 'Target',
            data: [<?= $monthlyCustomerRetention_target; ?>, <?= $monthlyCustomerRetention_target; ?>, <?= $monthlyCustomerRetention_target; ?>, <?= $monthlyCustomerRetention_target; ?>, <?= $monthlyCustomerRetention_target; ?>],
            borderWidth: 1.2,
            fill: false,
            borderColor: 'black',
            pointBackgroundColor: 'black',
            pointRadius: 0,
            pointStyle: 'line'
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Amount'
              }
            },
            x: {
              title: {
                display: true,
                text: 'Loan Details'
              },
              grid: {
                display: false
              }
            }
          },
          plugins: {
            tooltip: {
              intersect: false
            },
            legend: {
              position: 'bottom',
              labels : {
                usePointStyle: true
              }
            }
          },
          interaction: {
              mode: 'index'
          }
        }
      });

      /* KPI1b */
      const kpi2b = document.getElementById('KPI2b');

      new Chart(kpi2b, {
        type: 'line',
        data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 
          'August', 'September', 'October', 'November', 'December'],
          datasets: [
            {
            type: 'line',
            label: '<?= $currentYear_monthlyLoanRevenue ?>',
            data: <?= $jsonCurrentYearSalesRevenueChartValues ?>,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            pointStyle: 'rectRounded'
          }, {
            type: 'line',
            label: '<?= $previousYear_monthlyLoanRevenue ?>',
            data: <?= $jsonPreviousYearSalesRevenueChartValues ?>,
            fill: false,
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            pointStyle: 'rectRounded'
          }, {
            type: 'line',
            label: 'Target',
            data: [<?= $monthlyLoanRevenue_target ?>, <?= $monthlyLoanRevenue_target ?>, <?= $monthlyLoanRevenue_target ?>, <?= $monthlyLoanRevenue_target ?>, <?= $monthlyLoanRevenue_target ?>, <?= $monthlyLoanRevenue_target ?>, 
                  <?= $monthlyLoanRevenue_target ?>, <?= $monthlyLoanRevenue_target?>, <?= $monthlyLoanRevenue_target ?>, <?= $monthlyLoanRevenue_target ?>, <?= $monthlyLoanRevenue_target ?>, <?= $monthlyLoanRevenue_target ?>],
            borderWidth: 1.2,
            fill: false,
            borderColor: 'black',
            pointBackgroundColor: 'black',
            pointRadius: 0,
            pointStyle: 'line'
          }
        ]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Quantity'
              }
            },
            x: {
              title: {
                display: true,
                text: 'Month'
              },
              grid: {
                display: false
              }
            }
          },
          plugins: {
            tooltip: {
              intersect: false
            },
            legend: {
              position: 'bottom',
              labels : {
                usePointStyle: true
              }
            }
          },
          interaction: {
              mode: 'index'
          } 
        }
      });
</script>