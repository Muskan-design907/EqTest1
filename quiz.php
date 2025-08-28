<?php
session_start();
require_once 'db.php';
 
// Fetch all questions
$sql = "SELECT * FROM questions ORDER BY id ASC";
$result = $conn->query($sql);
 
if (!$result || $result->num_rows == 0) {
    die("No questions found in database.");
}
 
$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}
 
$conn->close();
 
$total_questions = count($questions);
 
$current = isset($_GET['q']) ? intval($_GET['q']) : 0;
if ($current < 0) $current = 0;
if ($current >= $total_questions) $current = $total_questions - 1;
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_option = isset($_POST['answer']) ? $_POST['answer'] : null;
    $question_id = isset($_POST['question_id']) ? intval($_POST['question_id']) : null;
 
    if ($question_id !== null && in_array($selected_option, ['a','b','c','d'])) {
        $_SESSION['answers'][$question_id] = $selected_option;
    }
 
    if (isset($_POST['next'])) {
        $next = $current + 1;
        if ($next >= $total_questions) {
            header('Location: results.php');
            exit;
        } else {
            header('Location: quiz.php?q=' . $next);
            exit;
        }
    } elseif (isset($_POST['prev'])) {
        $prev = $current - 1;
        if ($prev < 0) $prev = 0;
        header('Location: quiz.php?q=' . $prev);
        exit;
    }
}
 
$current_question = $questions[$current];
$question_id = $current_question['id'];
 
$selected = isset($_SESSION['answers'][$question_id]) ? $_SESSION['answers'][$question_id] : null;
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>EQ Test - Question <?php echo $current + 1; ?> of <?php echo $total_questions; ?></title>
<style>
  /* Same styles as before */
  body { font-family: Arial, sans-serif; background: #f9f9f9; margin:0; padding:0; display:flex; justify-content:center; align-items:center; min-height:100vh; }
  .container { background: white; max-width:700px; padding: 30px 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-radius:8px; width:90%; }
  h2 { color: #2c3e50; margin-bottom: 20px; }
  form { margin-top: 20px; }
  .option { display: block; margin: 15px 0; font-size: 1.1rem; }
  input[type="radio"] { margin-right: 10px; transform: scale(1.3); vertical-align: middle; }
  button { background: #2980b9; color: white; padding: 12px 30px; border: none; border-radius: 50px; font-size: 1rem; cursor: pointer; margin: 10px 10px 0 0; transition: background 0.3s ease; }
  button:hover { background: #1c5980; }
  button:disabled { background: #ccc; cursor: not-allowed; }
  .nav-buttons { margin-top: 30px; }
  @media (max-width: 600px) {
    .container { padding: 20px; }
    button { width: 48%; font-size: 0.9rem; padding: 10px; }
  }
</style>
</head>
<body>
  <div class="container">
    <h2>Question <?php echo ($current + 1) . " of " . $total_questions; ?></h2>
    <p><?php echo htmlspecialchars($current_question['question_text']); ?></p>
 
    <form method="post" action="quiz.php?q=<?php echo $current; ?>">
      <input type="hidden" name="question_id" value="<?php echo $question_id; ?>" />
 
      <label class="option">
        <input type="radio" name="answer" value="a" <?php if ($selected === 'a') echo 'checked'; ?> required />
        <?php echo htmlspecialchars($current_question['option_a']); ?>
      </label>
 
      <label class="option">
        <input type="radio" name="answer" value="b" <?php if ($selected === 'b') echo 'checked'; ?> />
        <?php echo htmlspecialchars($current_question['option_b']); ?>
      </label>
 
      <label class="option">
        <input type="radio" name="answer" value="c" <?php if ($selected === 'c') echo 'checked'; ?> />
        <?php echo htmlspecialchars($current_question['option_c']); ?>
      </label>
 
      <label class="option">
        <input type="radio" name="answer" value="d" <?php if ($selected === 'd') echo 'checked'; ?> />
        <?php echo htmlspecialchars($current_question['option_d']); ?>
      </label>
 
      <div class="nav-buttons">
        <?php if ($current > 0): ?>
          <button type="submit" name="prev">Previous</button>
        <?php endif; ?>
 
        <?php if ($current < $total_questions - 1): ?>
          <button type="submit" name="next">Next</button>
        <?php else: ?>
          <button type="submit" name="next">Submit</button>
        <?php endif; ?>
      </div>
    </form>
  </div>
</body>
</html>
 
