var fs = require('fs');
var https = require('https');
var Redis = require('ioredis');
var redis = new Redis();
var express = require('express');
var app = express();

var options = {
    key: fs.readFileSync('/etc/letsencrypt/live/battleplanner.io/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/battleplanner.io/fullchain.pem')
};
var serverPort = 3000;

var server = https.createServer(options, app);
var io = require('socket.io')(server);

redis.subscribe('RequestBattleplan', function(err, count) {});
redis.subscribe('ResponseBattleplan', function(err, count) {});
redis.subscribe('ReceiveDrawDelete', function(err, count) {});
redis.subscribe('ReceiveDrawCreate', function(err, count) {});
redis.subscribe('ReceiveOperatorSlotChange', function(err, count) {});
redis.subscribe('ReceiveDrawUpdate', function(err, count) {});
redis.subscribe('ReceiveConnected', function(err, count) {});
redis.subscribe('ReceiveReload', function(err, count) {});

redis.on('message', function(channel,message) {
    message = JSON.parse(message);
    io.emit(channel + '.' + message.data.lobby.connection_string + ':' + message.event, message.data);
});

io.on('connection', function(socket){
    socket.on('disconnect', function() {
        var lobbyId = parseLobbyId(socket);
        io.emit(`ReceiveLobbyLeave:${lobbyId}`, {'socketId' : socket.id})
    })
})

var args = process.argv.slice(2);

server.listen(args[0], function() {
    console.log('server up and running at %s port', args[0]);
});

/**
 * Private Helpers
 */
function parseLobbyId(socket){
    var originExploded = socket.handshake.headers.referer.split('/')
    var lobbyId = originExploded[originExploded.length - 1];
    return lobbyId;
}
