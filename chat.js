async function sendMessage() {
  const newMessage = document.querySelector("#Nachricht").value;
  if (newMessage != null) {
    const formData = new FormData();
    formData.append("text", newMessage);
    const response = await fetch("/postMessage.php", {
      method: "POST",
      body: formData,
      headers: { "X-Requested-With": "XMLHttpRequest" },
    });

    if (response.ok) {
      const divMessages = document.querySelector("#messages");
      const newDivMessage = document.createElement("div");
      newDivMessage.classList.add("message");
      newDivMessage.innerHTML = newMessage;
      divMessages.appendChild(newDivMessage);
      document.querySelector("#Nachricht").value = "";
    } else {
      alert(await response.text());
    }
  }
}

document.querySelector("#send").onclick = sendMessage;
