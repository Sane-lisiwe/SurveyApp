<?php
require_once 'config.php';

$errors = [];
$success = false;


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_survey'])) {
   
    $fullName = sanitizeInput($_POST['full_name']);
    $email = sanitizeInput($_POST['email']);
    $dateOfBirth = sanitizeInput($_POST['date_of_birth']);
    $contactNumber = sanitizeInput($_POST['contact_number']);
    

    if (empty($fullName)) {
        $errors[] = "Full name is required.";
    }
    
    if (empty($email) || !validateEmail($email)) {
        $errors[] = "Valid email is required.";
    }
    
    if (empty($dateOfBirth)) {
        $errors[] = "Date of birth is required.";
    } else {
        $age = calculateAge($dateOfBirth);
        if ($age < 5 || $age > 120) {
            $errors[] = "Age must be between 5 and 120 years.";
        }
    }
    
    if (empty($contactNumber)) {
        $errors[] = "Contact number is required.";
    }
    
    
    $foodPreferences = ['pizza', 'pasta', 'pap_and_wors', 'other'];
    $selectedFood = false;
    foreach ($foodPreferences as $food) {
        if (isset($_POST[$food])) {
            $selectedFood = true;
            break;
        }
    }
    if (!$selectedFood) {
        $errors[] = "Please select at least one favorite food.";
    }
    
   
    $ratings = ['rating_movies', 'rating_radio', 'rating_eat_out', 'rating_tv'];
    foreach ($ratings as $rating) {
        if (!isset($_POST[$rating]) || empty($_POST[$rating])) {
            $errors[] = "Please provide a rating for all questions.";
            break;
        }
    }
    
    
    if (empty($errors)) {
        try {
            $sql = "INSERT INTO surveys (full_name, email, date_of_birth, contact_number, age, likes_pizza, likes_pasta, likes_pap_and_wors, likes_other, rating_movies, rating_radio, rating_eat_out, rating_tv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $fullName,
                $email,
                $dateOfBirth,
                $contactNumber,
                $age,
                isset($_POST['pizza']) ? 1 : 0,
                isset($_POST['pasta']) ? 1 : 0,
                isset($_POST['pap_and_wors']) ? 1 : 0,
                isset($_POST['other']) ? 1 : 0,
                $_POST['rating_movies'],
                $_POST['rating_radio'],
                $_POST['rating_eat_out'],
                $_POST['rating_tv']
            ]);
            
            $success = true;
        } catch(PDOException $e) {
            $errors[] = "Error saving survey: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Application</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navigation {
            background-color: #e9ecef;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .navigation a {
            color: #007bff;
            text-decoration: none;
            margin-right: 20px;
            font-weight: bold;
        }
        
        .navigation a:hover {
            text-decoration: underline;
        }
        
        .navigation .active {
            color: #333;
        }
        
       
        
        .form-section {
            margin-bottom: 25px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .form-section h3 {
            margin-top: 0;
            color: #333;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"], input[type="email"], input[type="date"], .flatpickr-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .checkbox-group, .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
        }
        
        .checkbox-item, .radio-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .rating-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .rating-table th, .rating-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        
        .rating-table th {
            background-color: #f8f9fa;
        }
        
        .rating-table td:first-child {
            text-align: left;
            padding-left: 10px;
        }
        
        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 20px auto;
        }
        
        .submit-btn:hover {
            background-color: #0056b3;
        }
        
        .error-messages {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <a href="index.php" class="active">Fill Out Survey</a>
            <a href="results.php">View Survey Results</a>
        </div>
        
       
        
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <strong>Please fix the following errors:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success-message">
                <strong>Thank you!</strong> Your survey has been submitted successfully.
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-section">
                <h3>Personal Details:</h3>
                
                <div class="form-group">
                    <label for="full_name">Full Names:</label>
                    <input type="text" id="full_name" name="full_name" value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth:</label>
                    <input type="text" id="date_of_birth" name="date_of_birth" placeholder="Select your date of birth" value="<?php echo isset($_POST['date_of_birth']) ? htmlspecialchars($_POST['date_of_birth']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" id="contact_number" name="contact_number" value="<?php echo isset($_POST['contact_number']) ? htmlspecialchars($_POST['contact_number']) : ''; ?>">
                </div>
            </div>
            
            <div class="form-section">
                <h3>What is your favorite food?</h3>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="pizza" name="pizza" <?php echo isset($_POST['pizza']) ? 'checked' : ''; ?>>
                        <label for="pizza">Pizza</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="pasta" name="pasta" <?php echo isset($_POST['pasta']) ? 'checked' : ''; ?>>
                        <label for="pasta">Pasta</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="pap_and_wors" name="pap_and_wors" <?php echo isset($_POST['pap_and_wors']) ? 'checked' : ''; ?>>
                        <label for="pap_and_wors">Pap and Wors</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="other" name="other" <?php echo isset($_POST['other']) ? 'checked' : ''; ?>>
                        <label for="other">Other</label>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Please rate your level of agreement on a scale from 1 to 5, with 1 being "strongly agree" and 5 being "strongly disagree":</h3>
                
                <table class="rating-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Strongly Agree</th>
                            <th>Agree</th>
                            <th>Neutral</th>
                            <th>Disagree</th>
                            <th>Strongly Disagree</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>I like to watch movies</td>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <td>
                                    <input type="radio" name="rating_movies" value="<?php echo $i; ?>" <?php echo (isset($_POST['rating_movies']) && $_POST['rating_movies'] == $i) ? 'checked' : ''; ?>>
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td>I like to listen to radio</td>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <td>
                                    <input type="radio" name="rating_radio" value="<?php echo $i; ?>" <?php echo (isset($_POST['rating_radio']) && $_POST['rating_radio'] == $i) ? 'checked' : ''; ?>>
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td>I like to eat out</td>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <td>
                                    <input type="radio" name="rating_eat_out" value="<?php echo $i; ?>" <?php echo (isset($_POST['rating_eat_out']) && $_POST['rating_eat_out'] == $i) ? 'checked' : ''; ?>>
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td>I like to watch TV</td>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <td>
                                    <input type="radio" name="rating_tv" value="<?php echo $i; ?>" <?php echo (isset($_POST['rating_tv']) && $_POST['rating_tv'] == $i) ? 'checked' : ''; ?>>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <button type="submit" name="submit_survey" class="submit-btn">SUBMIT</button>
        </form>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date_of_birth", {
            dateFormat: "Y-m-d",
            defaultDate: null,
            allowInput: false,
            clickOpens: true,
            theme: "light",
            yearSelector: true,
            monthSelector: true,
            enableTime: false,
            placeholder: "Select your date of birth",
            onChange: function(selectedDates, dateStr, instance) {
                
                console.log("Date selected: " + dateStr);
            }
        });
    </script>
</body>
</html>