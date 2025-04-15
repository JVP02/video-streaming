<?php
// filepath: c:\xampp\htdocs\videostreaming\index.php

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

// Fetch videos
$sql = "SELECT * FROM videos";
$result = $conn->query($sql);

$videos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $videos[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JVP Video Streaming</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/comp.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <?php include 'comp/header.php'; ?>

    <main>
        <img src="" alt="" class="top-spacer">

        <div class="search-cont">
            <input type="text" placeholder="Search..." class="search-bar">
            <div class="small-btn">
                <button class="btn-tertiary" type="button"><img src="asset/i/searchicon.png" alt="" class="search-icon"></button>
            </div>
        </div>
        <div class="banner">
            <img src="" alt="" class="banner-img">
        </div>

        <section class="video-section">
            <?php foreach ($videos as $video): ?>
                <a href="media.php?video_id=<?php echo $video['id']; ?>" class="video-card-link">
                    <div class="video-card">
                        <img src="<?php echo htmlspecialchars($video['thumbnail']); ?>" alt="Video Thumbnail" class="video-thumbnail">
                        <h3 class="video-title"><?php echo htmlspecialchars($video['title']); ?></h3>
                        <p class="video-description"><?php echo htmlspecialchars($video['description']); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </section>
    </main>

    <script src="js/sidebar.js"></script>
</body>
</html>