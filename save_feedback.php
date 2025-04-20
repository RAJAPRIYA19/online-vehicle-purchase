<!-- filepath: d:\XAMPP\htdocs\online-vehicle-purchase\save_feedback.php -->
<?php
// Check if feedback is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback'])) {
    $feedback = htmlspecialchars($_POST['feedback']); // Sanitize input
    $timestamp = date('Y-m-d H:i:s'); // Get current timestamp

    // Path to the feedback XML file
    $filePath = 'feedback.xml';

    // Check if the XML file exists
    if (!file_exists($filePath)) {
        // Create a new XML file with a root element
        $xml = new SimpleXMLElement('<feedbacks></feedbacks>');
    } else {
        // Load the existing XML file
        $xml = simplexml_load_file($filePath);
    }

    // Add the new feedback
    $feedbackEntry = $xml->addChild('feedback');
    $feedbackEntry->addChild('message', $feedback);
    $feedbackEntry->addChild('timestamp', $timestamp);

    // Save the updated XML file
    $xml->asXML($filePath);

    // Redirect to index.html after successful submission
    header('Location: index.html');
    exit;
} else {
    // Redirect to index.html with an error message if feedback is not submitted
    header('Location: index.html?error=1');
    exit;
}
?>