<?php
  // Check if the form was submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate the form data
    $errors = array();

    if (empty($name)) {
      $errors[] = 'Please enter your name';
    }

    if (empty($email)) {
      $errors[] = 'Please enter your email';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'Please enter a valid email address';
    }

    if (empty($subject)) {
      $errors[] = 'Please enter a subject';
    }

    if (empty($message)) {
      $errors[] = 'Please enter a message';
    }

    // If there are no errors, send the email
    if (empty($errors)) {
      $to = 'youremail@example.com'; // Replace with your own email address
      $headers = "From: $name <$email>";
      $message = "Name: $name\nEmail: $email\nSubject: $subject\nMessage:\n$message";
      mail($to, $subject, $message, $headers);

      // Redirect the user to a thank-you page
      header('Location: thankyou.html');
      exit;
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Contact Form</title>
</head>
<body>
  <h1>Contact Form</h1>

  <?php if (!empty($errors)) { ?>
    <div class="alert alert-danger">
      <ul>
        <?php foreach ($errors as $error) { ?>
          <li><?php echo $error; ?></li>
        <?php } ?>
      </ul>
    </div>
  <?php } ?>

  <?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success">
      <p>Thank you for your message. We will get back to you as soon as possible.</p>
    </div>
  <?php } ?>

  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>">
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
    </div>

    <div class="form-group">
      <label for="subject">Subject:</label>
      <input type="text" id="subject" name="subject" class="form-control" value="<?php echo htmlspecialchars($subject); ?>">
    </div>

    <div class="form-group">
      <label for="message">Message:</label>
      <textarea id="message" name="message" class="form-control"><?php echo htmlspecialchars($message); ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</body>
</html>
