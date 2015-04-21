@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Tracking Script&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/webinar"><small>back to Webinars</small></a></div>

				<div class="panel-body">
					<pre><code>&lt;script type=&quot;text/javascript&quot;&gt;
jQuery(document).ready(function() {
	var webinar_id = 1;
	var email = getURLParameter('email');
	if (email != null) {
		jQuery.ajax
		({
		  type: &quot;GET&quot;,
		  url: &quot;http://itag.visiontechteam.com/api/start/&quot;+webinar_id+&quot;/&quot;+email+&quot;/&quot;,
		  dataType: &quot;jsonp&quot;,
		  async: false,
		  crossDomain:true,
		  jsonp: &quot;callback&quot;,
		  success: function (data){
		    console.log(data.success); 
		  }
		});
	}
	function getURLParameter(name) {
	  return decodeURIComponent((new RegExp('[?|&amp;]' + name + '=' + '([^&amp;;]+?)(&amp;|#|;|$)').exec(location.search)||[,&quot;&quot;])[1].replace(/\+/g, '%20'))||null
	}
jQuery(window).bind('beforeunload', function(event) {
		    	event.stopPropagation();
		        jQuery.ajax
			({
			  type: &quot;GET&quot;,
			  url: &quot;http://itag.visiontechteam.com/api/end/&quot;+webinar_id+&quot;/&quot;+email+&quot;/&quot;,
			  dataType: &quot;jsonp&quot;,
			  async: false,
			  crossDomain:true,
			  jsonp: &quot;callback&quot;,
			  success: function (data){
			    console.log(data.success); 
			  }
			});
return 'Are you sure want to leave the livestream?';
		});
});
&lt;/script&gt;</code></pre>

				</div>
			</div>
		</div>
	</div>
</div>
<style>
small {
	font-size:12px;
}
</style>
@endsection