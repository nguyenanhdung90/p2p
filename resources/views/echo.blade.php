<!DOCTYPE html>
<html>
<head>
    <title>echo </title>
    <script src="js/app.js"></script>
    <script>
        const pusher = new Pusher('app-key', {
            encrypted: true,
            wsHost: '127.0.0.1',
            wsPort: 6001,
            forceTLS: false,
            disableStats: true,
            enabledTransports: ['ws', 'wss'],
            authEndpoint: 'http://p2p.local/api/auth',
            auth: {
                headers: {
                    "Authorization": "Bearer 7|PYJf7rE2MMohbcU9WRNAWWPDvjxRwFCeA8bZxMWj",
                    "Access-Control-Allow-Origin": "*"
                }
            }
        });
        // const channel = pusher.subscribe('channel-notify');
        const channel = pusher.subscribe('private-App.User.2');
        console.log("hao hao");
        channel.bind("pusher:subscription_error", (data) => {
            console.log("subscription_error : ", data)
        });

        channel.bind('notify', function (data) {
            console.log("PusherEvent: ", data);
        });
    </script>
</head>
<body>
<h1>This is a echo</h1>
<p>This is a echo.</p>

</body>
</html>
