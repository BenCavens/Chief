<!-- Redactor is here -->
<script src="{{ asset('packages/bencavens/chief/js/vendor/redactor/redactor.min.js') }}"></script>

<script type="text/javascript">
$(function()
{
	$('#redactor_content').redactor({
		focus: true,
		imageUpload: '{{ route('chief.posts.image.upload') }}'
	});
});
</script>