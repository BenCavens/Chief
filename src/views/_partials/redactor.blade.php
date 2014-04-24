<!-- Redactor is here -->
<script src="{{ asset('packages/bencavens/chief/js/vendor/redactor/redactor.min.js') }}"></script>

<script>
$(function()
{
	$('#redactor_content').redactor({
		focus: true,
		imageUpload: '{{ route('chief.posts.image.upload') }}',
		image_dir: '{{ asset('packages/bencavens/chief/assets/images') }}'
	});
});
</script>