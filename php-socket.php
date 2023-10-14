<?php
define('HOST_NAME',"localhost"); 
define('PORT',"8090");
$null = NULL;

require_once("class.chathandler.php");
$chatHandler = new ChatHandler();

// create socket mit IPV4, sequenziell, verbindungsbasiert, full-duplex und TCP
$socketResource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); 
// set option: lokale Adressen können wiederverwendet werden
socket_set_option($socketResource, SOL_SOCKET, SO_REUSEADDR, 1);
// Setzt den Host und den Port für den Websocket. (Ist Host-adress 0 wird localhost genommen)
socket_bind($socketResource, HOST_NAME, PORT); 
// Ab jetzt wartet der Websocket auf eingehende Verbindungen.
socket_listen($socketResource);

// Hier werden die Clients aufgelistet
$clientSocketArray = array($socketResource);
while (true) {
	$newSocketArray = $clientSocketArray;
  // Das übergebene Array wird beobachtet, ob daraus gelesen werden kann oder ob da etwas geblockt wird.
  // In dem Fall soll 10 Mikrosekunden gewartet werden, bevor die Methode beendet wird.
	socket_select($newSocketArray, $null, $null, 0, 10);
	
  // Registrierung eines neuen clients.
	if (in_array($socketResource, $newSocketArray)) {
    // Akzeptiert eine neue Verbindung und gibt ein neues Socket Objekt zurück mit dem man kommunizieren kann.
		$newSocket = socket_accept($socketResource);
		$clientSocketArray[] = $newSocket;
		
    // liest 1024 Bytes ein, was genau dem Header entspricht.
		$header = socket_read($newSocket, 1024);
		$chatHandler->doHandshake($header, $newSocket, HOST_NAME, PORT);
		
    // holt die IP Adresse des clients
		socket_getpeername($newSocket, $client_ip_address);

    // erstellt Bestätigung
		$connectionACK = $chatHandler->newConnectionACK($client_ip_address);
		
    // versendet Bestätigung
		$chatHandler->send($connectionACK);
		
		$newSocketIndex = array_search($socketResource, $newSocketArray);
		// Der aktuelle Wert wird genullt. 
    unset($newSocketArray[$newSocketIndex]);
	}
	
  // Nachrichten der clients auslesen.
	foreach ($newSocketArray as $newSocketArrayResource) {	
    // Solange es Daten gibt, sollen diese eingelesen und an die clients zurückgesendet werden.
    // Maximal 1024 Bytes Daten werden eingelesen in socketData
		while(socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1){
			$socketMessage = $chatHandler->unseal($socketData);
			$messageObj = json_decode($socketMessage);
			
			$chat_box_message = $chatHandler->createChatBoxMessage($messageObj->chat_user, $messageObj->chat_message);
			$chatHandler->send($chat_box_message);
			break 2;
		}
		
    // liest maximal 1024 Bytes bis zum nächsten \r oder \n
		$socketData = @socket_read($newSocketArrayResource, 1024, PHP_NORMAL_READ);

    // Wenn der client nicht mehr erreibar ist, benachrichtige die anderen clients.
		if ($socketData === false) { 
      // holt die IP Adresse des clients
			socket_getpeername($newSocketArrayResource, $client_ip_address);
			$connectionACK = $chatHandler->connectionDisconnectACK($client_ip_address);
			$chatHandler->send($connectionACK);
			$newSocketIndex = array_search($newSocketArrayResource, $clientSocketArray);
			unset($clientSocketArray[$newSocketIndex]);			
		}
	}
}
socket_close($socketResource);