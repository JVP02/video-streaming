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

// Fetch video details
$video_id = isset($_GET['video_id']) ? intval($_GET['video_id']) : 0;
$sql = "SELECT * FROM videos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $video_id);
$stmt->execute();
$result = $stmt->get_result();
$video = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($video['title']); ?></title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/comp.css">
</head>
<body>
    <?php include 'comp/header.php'; ?>

    <main>
        <div class="search-cont">
            <input type="text" placeholder="Search..." class="search-bar">
            <div class="small-btn">
                <button class="btn-tertiary" type="button"><img src="asset/i/searchicon.png" alt="" class="search-icon"></button>
            </div>
        </div>

        <div class="media-player">
            <video controls class="video-player" id="videoPlayer">
                <source src="<?php echo htmlspecialchars($video['video_path']); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="media-controls">
                <button class="btn-primary" id="playButton">Play</button>
                <button class="btn-secondary" id="pauseButton">Pause</button>
                <button class="btn-tertiary" id="stopButton">Stop</button>
            </div>
        </div>
    </main>
</body>
</html>