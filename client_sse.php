<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Server Side Events</title>
</head>

<body>
  <script type="text/javascript">
    var source = new EventSource("server_sse.php");
    source.onmessage = function(event) {
      const divResult = document.getElementById("result");
      // if (divResult.innerHTML === null) {
      //   divResult.innerHTML = "";
      // }
      if(event.data != null){
        divResult.innerHTML = event.data + "<br>";
      }
    };
  </script>
  <div id="result"></div>
</body>

</html>