<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'video_streaming';

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $thumbnail = $_FILES['thumbnail']['name'];
    $video = $_FILES['video']['name'];

    // File upload paths
    $thumbnailTarget = 'uploads/thumbnails/' . basename($thumbnail);
    $videoTarget = 'uploads/videos/' . basename($video);

    // Move uploaded files to target directories
    if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailTarget) &&
        move_uploaded_file($_FILES['video']['tmp_name'], $videoTarget)) {
        
        // Insert video details into the database
        $sql = "INSERT INTO videos (title, description, thumbnail, video_path) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $title, $description, $thumbnailTarget, $videoTarget);

        if ($stmt->execute()) {
            echo "Video uploaded successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Failed to upload files.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <h1>Upload Video</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="thumbnail">Thumbnail:</label>
        <input type="file" id="thumbnail" name="thumbnail" accept="image/*" required><br><br>

        <label for="video">Video:</label>
        <input type="file" id="video" name="video" accept="video/*" required><br><br>

        <button type="submit">Upload</button>
    </form>
</body>
</html>
