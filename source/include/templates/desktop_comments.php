<a name="comments"></a>
<section id="comments">
	<p>Для загрузки комментариев включите java-script!</p>
	<script> 
		$(document).ready(function() {
			$.get(
				'<? host_url() ?>/comments?tid=<? page_comments_topic_id() ?>',
				function(data) {
					$(comments).html(data);
//					document.getElementById('comments').innerHTML = data;
				}
			);
		});
	</script>
</section>
