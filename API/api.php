<?php

// Load the pre-trained Keras model and scaler
require 'vendor/autoload.php'; // Include PHP-ML

use Phpml\ModelManager;

// Load the pre-trained Keras model
$modelManager = new ModelManager();
$model = $modelManager->restoreFromFile('C:/Users/Cris/loan_model.phpml'); // Update with the actual path to your model
// Function to make loan prediction
function predictLoan($inputData) {
    // Perform any necessary data preprocessing (scaling, encoding, etc.)
    $scaledInput = $scaler->transform([$inputData]);  // Assuming $inputData is an array

    // Make prediction using the Keras model
    $prediction = $model->predict($scaledInput);

    // Return the prediction
    return $prediction;
}

// Function to generate a PDF report
function generatePdfReport($data) {
    // Create a new PDF document
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Define the content to include in the PDF
    $pdfContent = [
        "Dependents: {$data['Dependents']}",
        "ApplicantIncome: {$data['ApplicantIncome']}",
        "CoapplicantIncome: {$data['CoapplicantIncome']}",
        "LoanAmount: {$data['LoanAmount']}",  // Add other fields as needed
    ];

    // Add content to the PDF
    $yCoordinate = 10;
    foreach ($pdfContent as $content) {
        $pdf->Cell(0, 10, $content, 0, 1);
        $yCoordinate += 10;
    }

    // Output the PDF as a string
    ob_start();
    $pdf->Output();
    $pdfBuffer = ob_get_clean();

    // Return the PDF buffer
    return $pdfBuffer;
}
// API endpoint for loan prediction
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents('php://input'), true);

     // Validate and process input data
     $requiredFields = ['Dependents', 'ApplicantIncome', 'CoapplicantIncome'];
    
     foreach ($requiredFields as $field) {
         if (!isset($postData[$field]) || !is_numeric($postData[$field])) {
             // Handle validation error
             header('HTTP/1.1 400 Bad Request');
             echo json_encode(['error' => 'Invalid or missing input data']);
             exit;
         }
     }

    // Make loan prediction
    $prediction = predictLoan($postData);

    // Format the response
    $response = ['prediction' => $prediction];

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// HTML Form for user input
?>
<!DOCTYPE html>
<html>

<head>
    <title>Loan Appraisal Prediction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: green;
        }

        form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f5f5f5;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h2>Loan Appraisal Prediction</h2>
    <form method="post">
        <label for="gender">Gender:</label>
        <input type="text" name="Gender" id="gender" placeholder="1-Male or 0-Female" required>

        <label for="married">Marital Status:</label>
        <input type="text" name="Married" id="married" placeholder="Married (1-Yes or 0-No)" required>

        <label for="dependents">Number of Dependents:</label>
        <input type="number" name="Dependents" id="dependents" placeholder="Number of Dependents" required>

        <label for="education">Education:</label>
        <input type="text" name="Education" id="education" placeholder="1-Graduate or 0-Not Graduate" required>

        <label for="selfEmployed">Self Employed:</label>
        <input type="text" name="SelfEmployed" id="selfEmployed" placeholder="Self Employed (1-Yes or 0-No)" required>

        <label for="applicantIncome">Applicant Income:</label>
        <input type="number" name="ApplicantIncome" id="applicantIncome" placeholder="Applicant Income" required>

        <label for="coapplicantIncome">Coapplicant Income:</label>
        <input type="number" name="CoapplicantIncome" id="coapplicantIncome" placeholder="Coapplicant Income" required>

        <label for="loanAmount">Loan Amount:</label>
        <input type="number" name="LoanAmount" id="loanAmount" placeholder="Loan Amount" required>

        <label for="loanAmountTerm">Loan Amount Term (in days):</label>
        <input type="number" name="LoanAmountTerm" id="loanAmountTerm" placeholder="Loan Amount Term" required>

        <label for="creditHistory">Credit History:</label>
        <input type="number" name="CreditHistory" id="creditHistory" placeholder="Credit History(0 -(0-350) 1(350-500)" required>

        <label for="propertyArea">Property Area:</label>
        <input type="text" name="PropertyArea" id="propertyArea" placeholder="1-Urban, 2-SemiUrban, 3-Rural" required>

        <input type="submit" name="submit-btn" value="Submit">
    </form>

    <div id="predictionResult"></div>

    <script>
        function submitForm() {
            var form = document.getElementById("loanForm");
            var formData = new FormData(form);

            fetch('your_php_script.php', {
                method: 'POST',
                body: JSON.stringify(Object.fromEntries(formData)),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("predictionResult").innerText = "Loan Prediction: " + data.prediction;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>

</html>
