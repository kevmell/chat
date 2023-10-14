<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Connection: close");
header("Content-Type: text/event-stream");

$dirPath = __DIR__ . '/chat/newMessage/';

while (true) {

  $filearray = scandir($dirPath);
  if ($filearray) {
    $filenames = array_diff($filearray);
    foreach ($filenames as $filename) {
      if (!is_dir($filename)) {
        $message = file_get_contents($dirPath . $filename);
        echo "event: newMessage\n";
        echo 'data: Server' . $message;
        echo "\n\n";
        
        ob_end_flush();
        flush();
        unlink($dirPath . $filename);
      }
    }
  }


  // Break the loop if the client aborted the connection (closed the page)
  if (connection_aborted()) break;
  sleep(1);
}
