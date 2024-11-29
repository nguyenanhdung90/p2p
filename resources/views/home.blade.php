<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    {{--<script src="https://js.pusher.com/7.0/pusher.min.js"></script>--}}
    <script src="https://js.pusher.com/7.0/pusher-with-encryption.min.js"></script>
    <script>
        const pusher = new Pusher('app-key', {
            encrypted: true,
            wsHost: '127.0.0.1',
            wsPort: 6001,
            forceTLS: false,
            disableStats: true,
            enabledTransports: ['ws', 'wss'],
        });
        // const channel = pusher.subscribe('channel-notify');
        const channel = pusher.subscribe('channel-notify');
        console.log("hao hao");
        channel.bind("pusher:subscription_error", (data) => {
            console.log("subscription_error : ", data)
        });

        channel.bind('user-name', function (data) {
            console.log("PusherEvent: ", data);
        });
    </script>
</head>
<body>
<h1>This is a Heading</h1>
<p>This is a paragraph.</p>

</body>
</html>
