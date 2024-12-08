<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Test</title>
</head>
<body>
<h1>WebSocket Communication</h1>
<button id="sendMessageBtn">ส่งข้อความ</button>
<div id="receivedMessage"></div>

<script>
    const socket = new WebSocket('ws://localhost:8080');

    socket.onopen = () => {
        console.log('WebSocket connection established');
    };

    socket.onmessage = (event) => {
        document.getElementById('receivedMessage').innerText = event.data;
    };

    document.getElementById('sendMessageBtn').addEventListener('click', () => {
        const message = 'Hello Server';
        socket.send(message);
        console.log('Message sent:', message);
    });
</script>
</body>
</html>
