<!-- Redactor air is here -->
<script src="{{ asset('packages/bencavens/chief/js/vendor/redactor/redactor.min.js') }}"></script>

<script>
$(function()
{
    $('#redactor_air').redactor({
        air: true,
        airButtons: ['bold', 'italic', 'deleted']
    });
});
</script>