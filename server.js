const { Server } = require('socket.io');
const http = require('http');
require('dotenv').config();

const server = http.createServer();
const io = new Server(process.env.SOCKET_PORT,{
    cors: {
      origin: '*',
    }
});

const connectedUsers = new Map();
const queueBeingHandled = new Map();

// SOCKET LOGIC
io.on('connection', (socket) => {
  console.log('a user connected');
  alert("TEEEEEEEEEEEEEEESTTT")

  socket.on('storeUserInfo', (userInfo) => {
    const user = {
      userId: userInfo.userId,
      username: userInfo.username,
      socketId: socket.id,
      office: userInfo.office
    }
    connectedUsers.set(userInfo.userId, user);
    console.log(connectedUsers)

    const response = {
      data: Array.from(queueBeingHandled.values())
    }
    console.log(response)
    socket.emit('syncQueueCollaborationWithSameOffice', response);

  });
  
  socket.on('endorse', (payload) => {
    const recipientOffice = payload.recipientOffice;
    const senderOffice = payload.senderOffice;
    const queueNumber = payload.queueNumber;

    

    const recipients = getUsersByOffice(recipientOffice);
    console.log(recipients);

    recipients.forEach((user) => {
      const response = {
        sender: senderOffice,
        queueNumber: queueNumber,
        message: `Queue number ${queueNumber} endorsed by ${senderOffice}`
      };

      console.log(user.socketId);
      io.to(user.socketId).emit('endorse', response);
    })

    const userInfo = getUserDataBySocketId(socket.id);

    queueBeingHandled.delete(userInfo.userId);
      const response = {
        data: Array.from(queueBeingHandled.values())
      }
    
      console.log("removing:")
      console.log(response)
      
      io.emit('syncQueueCollaborationWithSameOffice', response);

  })

  socket.on('syncUponendorse', () => {
    const response = {
      data: Array.from(queueBeingHandled.values())
    }
      console.log(response)
    
    io.emit('syncQueueCollaborationWithSameOffice', response);

  })

  socket.on('newQueue', (payload) => {
    const recipientOffice = payload.office;
    const queueNumber = payload.queueNumber;
    const recipients = getUsersByOffice(recipientOffice);

    const response = {
      message: `New queue number ${queueNumber}`
    }

    recipients.forEach((user) => {
      io.to(user.socketId).emit('newQueue', response);
    })
  })

  socket.on('handleQueue', (payload) => {
    const userId = payload.userId;
    const office = payload.office;
    const queueNumber = payload.queueNumber;

    const queueDetails = {
      handling_by: userId,
      office: office,
      queueNumber: queueNumber
    }

    queueBeingHandled.set(userId, queueDetails)

    const recipients = getUsersByOffice(office);

    const response = {
      data: Array.from(queueBeingHandled.values())
    }

    recipients.forEach((user) => {
      if (user.socketId !== socket.id) {
        io.to(user.socketId).emit('handleQueue', response);
        console.log(queueBeingHandled)
      }
    })
  })

  socket.on('disconnect', () => {
    console.log(`user disconnected with id ${socket.id}`);
  
    const userInfo = getUserDataBySocketId(socket.id);

    console.log("hmmm");
    console.log(userInfo);

   if (userInfo) {
      queueBeingHandled.delete(userInfo.userId);
      const response = {
        data: Array.from(queueBeingHandled.values())
      }
    
      console.log("removing:")
      console.log(response)
      
      io.emit('syncQueueCollaborationWithSameOffice', response);
    }
  })
})

function getUserDataBySocketId(socketId) {
  for (const [userId, userData] of connectedUsers.entries()) {
    if (userData.socketId === socketId) {
      return userData; // Return the userId associated with the provided socketId
    }
  }
  return null; // Return null if the socketId is not found in connectedUsers
}

function getUsersByOffice(office_name) {
  const users = [];
  for (const [key, value] of connectedUsers.entries()) {
    if (value.office === office_name) {
      users.push(value);
    }
  }
  return users;
}


const PORT = process.env.PORT || 4000;

server.listen(PORT, () => {
  console.log(`listening on *:${PORT}`)
});