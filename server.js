var app = require('http').createServer();
var io = require('socket.io')(app);
var port = 8001;
app.listen(port);

io.on('connection', function (socket) {

    socket.on('server_receive', function (data) {
        io.emit('client_receive', data);
    });
//    setInterval(function () {
//        var now = new Date();
//        console.log(now.toTimeString());
//        socket.emit('receive_time', parseInt(now.getTime() / 1000));
//    }, 1000);

});
