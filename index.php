<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Emotional Intelligence (EQ) Test</title>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0; padding: 0; background: #f9f9f9;
    display: flex; justify-content: center; align-items: center;
    min-height: 100vh;
  }
  .container {
    background: white;
    max-width: 600px;
    padding: 30px 40px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border-radius: 8px;
    text-align: center;
  }
  h1 {
    color: #2c3e50;
  }
  p {
    font-size: 1.1rem;
    color: #34495e;
    margin-bottom: 30px;
    line-height: 1.6;
  }
  a.button {
    display: inline-block;
    background: #2980b9;
    color: white;
    padding: 15px 40px;
    border-radius: 50px;
    text-decoration: none;
    font-size: 1.2rem;
    transition: background 0.3s ease;
  }
  a.button:hover {
    background: #1c5980;
  }
  @media (max-width: 600px) {
    .container {
      margin: 15px;
      padding: 20px;
    }
    a.button {
      padding: 12px 30px;
      font-size: 1rem;
    }
  }
</style>
</head>
<body>
  <div class="container">
    <h1>Emotional Intelligence (EQ) Test</h1>
    <p>Emotional Intelligence is the ability to understand, use, and manage your own emotions in positive ways to relieve stress, communicate effectively, empathize with others, overcome challenges, and defuse conflict. Taking this test will help you discover your EQ strengths and areas to improve.</p>
    <a href="quiz.php" class="button">Start Test</a>
  </div>
</body>
</html>
 
