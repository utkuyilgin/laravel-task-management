import Echo from 'laravel-echo';
 
window.Echo = new Echo({
   //redis
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
    
});