<?php
require_once 'config.php';


try {
   
    $stmt = $pdo->query("SELECT COUNT(*) as total_surveys FROM surveys");
    $totalSurveys = $stmt->fetch(PDO::FETCH_ASSOC)['total_surveys'];
    
    $stats = null;
    
    if ($totalSurveys > 0) {
   
        $stmt = $pdo->query("
            SELECT 
                COUNT(*) as total_surveys,
                AVG(age) as average_age,
                MAX(age) as max_age,
                MIN(age) as min_age,
                (SUM(likes_pizza) / COUNT(*)) * 100 as pizza_percentage,
                (SUM(likes_pasta) / COUNT(*)) * 100 as pasta_percentage,
                (SUM(likes_pap_and_wors) / COUNT(*)) * 100 as pap_wors_percentage,
                AVG(rating_movies) as avg_rating_movies,
                AVG(rating_radio) as avg_rating_radio,
                AVG(rating_eat_out) as avg_rating_eat_out,
                AVG(rating_tv) as avg_rating_tv
            FROM surveys
        ");
        
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {
    $error = "Error fetching survey results: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Results</title>
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
        
        h1 {
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
        }
        
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .results-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .results-table td:first-child {
            font-weight: bold;
            width: 70%;
            text-align: left;
        }
        
        .results-table td:last-child {
            text-align: right;
            font-weight: bold;
            color: #007bff;
            width: 30%;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 18px;
        }
        
        .section-header {
            background-color: #f8f9fa;
            padding: 8px;
            font-weight: bold;
            color: #333;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <a href="index.php">Fill Out Survey</a>
            <a href="results.php" class="active">View Survey Results</a>
        </div>
        
        <h1>Survey Results</h1>
        
        <?php if (isset($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php elseif ($totalSurveys == 0): ?>
            <div class="no-data">
                No Surveys Available.
            </div>
        <?php else: ?>
            <table class="results-table">
                <tr>
                    <td class="section-header" colspan="2">Surveys</td>
                </tr>
                <tr>
                    <td>Total number of surveys:</td>
                    <td><?php echo $stats['total_surveys']; ?></td>
                </tr>
                <tr>
                    <td>Average Age:</td>
                    <td><?php echo round($stats['average_age'], 1); ?></td>
                </tr>
                <tr>
                    <td>Oldest person who participated in survey:</td>
                    <td><?php echo $stats['max_age']; ?> age</td>
                </tr>
                <tr>
                    <td>Youngest person who participated in survey:</td>
                    <td><?php echo $stats['min_age']; ?> age</td>
                </tr>
                
                <tr>
                    <td class="section-header" colspan="2">Food Preferences</td>
                </tr>
                <tr>
                    <td>Percentage of people who like Pizza:</td>
                    <td><?php echo round($stats['pizza_percentage'], 1); ?>% Pizza</td>
                </tr>
                <tr>
                    <td>Percentage of people who like Pasta:</td>
                    <td><?php echo round($stats['pasta_percentage'], 1); ?>% Pasta</td>
                </tr>
                <tr>
                    <td>Percentage of people who like Pap and Wors:</td>
                    <td><?php echo round($stats['pap_wors_percentage'], 1); ?>% Pap and Wors</td>
                </tr>
                
                <tr>
                    <td class="section-header" colspan="2">Average Ratings</td>
                </tr>
                <tr>
                    <td>People who like to watch movies:</td>
                    <td>Average of rating: <?php echo round($stats['avg_rating_movies'], 1); ?></td>
                </tr>
                <tr>
                    <td>People who like to listen to radio:</td>
                    <td>Average of rating: <?php echo round($stats['avg_rating_radio'], 1); ?></td>
                </tr>
                <tr>
                    <td>People who like to eat out:</td>
                    <td>Average of rating: <?php echo round($stats['avg_rating_eat_out'], 1); ?></td>
                </tr>
                <tr>
                    <td>People who like to watch TV:</td>
                    <td>Average of rating: <?php echo round($stats['avg_rating_tv'], 1); ?></td>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>