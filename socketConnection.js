$(document).ready(function () {
     // Create a new WebSocket.
     var socket  = new WebSocket('ws://localhost:8080');
     var message = document.getElementById('message');

     function transmitMessage() {
         broadcastMessage = {
           type: 'broadcast',
           message: message.value,
         }
 
         privateMessage = {
           type: 'private',
           message: message.value,
         }

         socket.send( JSON.stringify(privateMessage) );
     }

     socket.onmessage = function(response) {

      console.log("AKO TO")
      console.log(response)
         
     }
});