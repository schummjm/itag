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
var QueryString = function () {
  // This function is anonymous, is executed immediately and 
  // the return value is assigned to QueryString!
  var query_string = {};
  var query =  encodeURIComponent(window.location.search.substring(1));
  console.log(query);
  var vars = query.split('%26');
console.log(vars);
  for (var i=0;i&lt;vars.length;i++) {
    var pair = vars[i].split(&quot;%3D&quot;);
        // If first entry with this name
    if (typeof query_string[pair[0]] === &quot;undefined&quot;) {
      query_string[pair[0]] = pair[1];
        // If second entry with this name
    } else if (typeof query_string[pair[0]] === &quot;string&quot;) {
      var arr = [ query_string[pair[0]], pair[1] ];
      query_string[pair[0]] = arr;
        // If third or later entry with this name
    } else {
      query_string[pair[0]].push(pair[1]);
    }
  } 
    return query_string;
} ();
console.log(QueryString);
	var webinar_id = 1;
	var email = QueryString.Email;
        email = email.replace(&quot;%2540&quot;, &quot;@&quot;);
console.log(email);
        var id = QueryString.Id;
console.log(id);
	if (id != null) {
		jQuery.ajax
		({
		  type: &quot;GET&quot;,
		  url: &quot;http://itag.dev:8000/api/start/&quot;+webinar_id+&quot;/&quot;+email+&quot;/&quot;+id+&quot;/&quot;,
		  dataType: &quot;jsonp&quot;,
		  async: false,
		  crossDomain:true,
		  jsonp: &quot;callback&quot;,
		  success: function (data){
		    console.log(data.success); 
		  }
		});
	}
jQuery(window).bind('beforeunload', function(event) {
		    	event.stopPropagation();
		        jQuery.ajax
			({
			  type: &quot;GET&quot;,
			  url: &quot;http://itag.dev:8000/api/end/&quot;+webinar_id+&quot;/&quot;+email+&quot;/&quot;+id+&quot;/&quot;,
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