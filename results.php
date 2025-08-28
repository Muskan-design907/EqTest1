<?php
session_start();
 
// DB connection parameters
$db_host = 'localhost';
$db_user = 'ur9iyguafpilu';
$db_pass = '51gssrtsv3ei';
$db_name = 'dbnemtkdfx0ocu';
 
// If no answers found, redirect to quiz start
if (!isset($_SESSION['answers']) || empty($_SESSION['answers'])) {
    header('Location: quiz.php');
    exit;
}
 
// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
 
// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
 
// Fetch all questions
$sql = "SELECT * FROM questions ORDER BY id ASC";
$result = $conn->query($sql);
 
if (!$result || $result->num_rows == 0) {
    die("No questions found in database.");
}
 
$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[$row['id']] = $row;
}
 
$conn->close();
 
$user_answers = $_SESSION['answers'];
 
$total_questions = count($questions);
$correct_count = 0;
 
// To analyze by category
$category_totals = [];
$category_correct = [];
 
foreach ($questions as $qid => $q) {
    $category = $q['category'];
    if (!isset($category_totals[$category])) {
        $category_totals[$category] = 0;
        $category_correct[$category] = 0;
    }
    $category_totals[$category]++;
 
    if (isset($user_answers[$qid]) && $user_answers[$qid] === $q['correct_option']) {
        $correct_count++;
        $category_correct[$category]++;
    }
}
 
// Calculate percentage score
$score_percent = round(($correct_count / $total_questions) * 100);
 
// Personalized feedback messages
function feedbackMessage($percent) {
    if ($percent >= 80) {
        return "Excellent! You have a strong emotional intelligence.";
    } elseif ($percent >= 60) {
        return "Good job! There’s room for improvement.";
    } elseif ($percent >= 40) {
        return "Fair. Try working more on your emotional skills.";
    } else {
        return "Needs improvement. Consider learning more about managing emotions and empathy.";
    }
}
 
// Category feedback
$category_feedback = [
    'self-awareness' => 'Self-awareness helps you understand your emotions and reactions.',
    'empathy' => 'Empathy allows you to understand and share the feelings of others.',
    'emotional regulation' => 'Emotional regulation helps you manage your emotions effectively in different situations.'
];
 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>EQ Test Results</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f9f9f9;
    margin: 0; padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
  }
  .container {
    background: white;
    max-width: 700px;
    padding: 30px 40px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border-radius: 8px;
    width: 90%;
  }
  h1 {
    color: #2c3e50;
    margin-bottom: 15px;
  }
  h2 {
    color: #2980b9;
    margin-top: 25px;
  }
  p {
    font-size: 1.1rem;
    color: #34495e;
    line-height: 1.5;
  }
  .score {
    font-size: 2.5rem;
    font-weight: bold;
    color: #27ae60;
  }
  .category {
    margin-top: 15px;
    border-top: 1px solid #eee;
    padding-top: 15px;
  }
  button {
    background: #2980b9;
    color: white;
    padding: 12px 35px;
    border: none;
    border-radius: 50px;
    font-size: 1rem;
    cursor: pointer;
    margin: 25px 10px 0 0;
    transition: background 0.3s ease;
  }
  button:hover {
    background: #1c5980;
  }
  @media (max-width: 600px) {
    .container {
      padding: 20px;
    }
    button {
      width: 48%;
      font-size: 0.9rem;
      padding: 10px;
    }
  }
</style>
<script>
function shareResults() {
    const url = window.location.href;
    if (navigator.share) {
        navigator.share({
            title: 'My EQ Test Results',
            text: 'I scored ' + document.getElementById('score').innerText + ' on the Emotional Intelligence test!',
            url: url
        }).catch(console.error);
    } else {
        // fallback: copy to clipboard
        navigator.clipboard.writeText(url).then(() => {
            alert('Results page URL copied to clipboard. Share it with your friends!');
        });
    }
}
</script>
</head>
<body>
  <div class="container">
    <h1>Your Emotional Intelligence (EQ) Test Results</h1>
    <p>Your score:</p>
    <p class="score" id="score"><?php echo $score_percent; ?>%</p>
    <p><?php echo feedbackMessage($score_percent); ?></p>
 
    <h2>Emotional Strengths & Improvement Areas</h2>
    <?php foreach ($category_totals as $cat => $total): 
        $correct = $category_correct[$cat];
        $percent = round(($correct / $total) * 100);
    ?>
      <div class="category">
        <h3><?php echo ucfirst(str_replace('-', ' ', $cat)); ?>: <?php echo $percent; ?>%</h3>
        <p><?php echo $category_feedback[$cat]; ?></p>
        <?php if ($percent < 60): ?>
          <p style="color:#e74c3c;">Consider improving this area for better emotional intelligence.</p>
        <?php else: ?>
          <p style="color:#27ae60;">This is a strong area for you.</p>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
 
    <button onclick="window.location.href='quiz.php?q=0'">Retake Test</button>
    <button onclick="shareResults()">Share Results</button>
  </div>
</body>
</html>
 
<?php
// Clear session answers after showing results (optional)
session_destroy();
?>
 
