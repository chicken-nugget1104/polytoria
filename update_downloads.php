<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $pngName = $data['pngName'];

    // Load current data
    $dataFile = 'data.txt';
    $lines = file($dataFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Find and update the relevant line
    foreach ($lines as &$line) {
        list($sectionName, $currentPngName, $itemName, $submitter, $downloads) = explode(',', $line);
        if ($currentPngName === $pngName) {
            $downloads = intval($downloads) + 1;
            $line = implode(',', [$sectionName, $currentPngName, $itemName, $submitter, $downloads]);
            break;
        }
    }

    // Save updated data
    file_put_contents($dataFile, implode(PHP_EOL, $lines) . PHP_EOL);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
