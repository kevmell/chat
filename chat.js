function addMessage(message) {
  const divMessages = document.querySelector("#messages");
  const newDivMessage = document.createElement("div");
  newDivMessage.classList.add("message");
  newDivMessage.innerHTML = message;
  divMessages.appendChild(newDivMessage);
}

var source = new EventSource("channel.php");
source.addEventListener("newMessage", (event) => {
  addMessage(event.data);
});

async function sendMessage() {
  const newMessage = document.querySelector("#Nachricht").value;
  if (newMessage != null) {
    const formData = new FormData();
    formData.append("text", newMessage);
    const response = await fetch("/saveMessage.php", {
      method: "POST",
      body: formData,
      headers: { "X-Requested-With": "XMLHttpRequest" },
    });

    if (response.ok) {
      addMessage(newMessage);
      document.querySelector("#Nachricht").value = "";
    } else {
      alert(await response.text());
    }
  }
}

document.querySelector("#send").onclick = sendMessage;
