<?php
if (isset($_GET['game'])) {
    $game = $_GET['game'];
    $dirPath = '../Source/' . $game;

    $videos = array_diff(scandir($dirPath), array('..', '.'));
    if (count($videos) > 0) {
        $randomVideo = $videos[array_rand($videos)];
        echo json_encode(['video' => $dirPath . '/' . $randomVideo]);
    } else {
        echo json_encode(['error' => 'No videos found']);
    }
} else {
    echo json_encode(['error' => 'No game specified']);
}
?>
