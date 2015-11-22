var Ajax = new (function ()
{
	var self = this;

	self.requestName = 'JSON';
	self.data = {};
	self.uri = 'models/GetPost.php';


	self.call = function (callback) {
		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function () {
			if (xhttp.readyState === 4 && xhttp.status === 200) {
				callback(xhttp.responseText);
			}
		};

		xhttp.open('POST', self.uri, true);
		xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhttp.send(self.requestName + '=' + JSON.stringify(self.data));
	};
});


var Main = new (function ()
{

	(function () {
		Ajax.data = {
			title: 'Test Title'
		};

		Ajax.call(function (data) {
			console.log(data);
		});
	}());
});