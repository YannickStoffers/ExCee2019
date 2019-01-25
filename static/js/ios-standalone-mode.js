
// This prevent iOS "app"-mode to open internal urls in iOS safari, but rather open them in the same
// window. External urls remain unaffected. I.e. all sites on excee.svcover.nl will be opened within
// iOS "app"-mode.
if(("standalone" in window.navigator) && window.navigator.standalone){
	var noddy, remotes = false;
	document.addEventListener('click', function(event) {
		noddy = event.target;
		while(noddy.nodeName !== "A" && noddy.nodeName !== "HTML") {
			noddy = noddy.parentNode;
		}
		if('href' in noddy && noddy.href.indexOf('http') !== -1 && (noddy.href.indexOf(document.location.host) !== -1 || remotes))
		{
			event.preventDefault();
			document.location.href = noddy.href;
		}
	},false);
}
