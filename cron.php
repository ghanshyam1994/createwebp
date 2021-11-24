
<h1>Create critical css cron is runing</h1>

<script>
function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * 
 charactersLength));
   }
   return result;
}
function setTimeoutChain() {
	setTimeout(() => {
		const win = window.open('https://www.prylstaden.se/?w3_preload_css='+makeid(100), 'Secure Payment');
		const timer = setInterval(() => {
			if (win.closed) {
			  clearInterval(timer);
				alert('"Secure Payment" window closed!');
				setTimeoutChain();
			}
		  }, 1000);
		  timer;
		setTimeoutChain();
  }, 15000);
}
setTimeoutChain();

</script>