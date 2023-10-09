function sendMessage() {
  const newMessage = document.querySelector("#Nachricht").value;
  if (newMessage != null) {
    fetch("/postMessage.php", {
      method: "POST",
      body: JSON.stringify({ text: newMessage }),
      headers: { "Content-type": "application/json; charset=UTF-8" },
    }).then((response) => updateUserView(newMessage, response));
  }
}

function updateUserView(newMessage, postMessageResponse) {
  if (postMessageResponse.ok) {
    const divMessages = document.querySelector("#messages");
    const newDivMessage = document.createElement("div");
    newDivMessage.classList.add("message");
    newDivMessage.innerHTML = newMessage;
    divMessages.appendChild(newDivMessage);
    document.querySelector("#Nachricht").value = "";
  } else {
    postMessageResponse.text().then((text) => alert(text));
  }
}

document.querySelector("#send").onclick = sendMessage;
