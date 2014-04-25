/*
|--------------------------------------------------------------------------
| Custom script
|--------------------------------------------------------------------------
| 
| description goes here...
|
*/



// Addon to bootstrap button js where on load state the checked state is not mitigated
function buttonCheckable()
{
	var $buttons = $('.btn-checkable'),
        $inputs   = $buttons.find('input[type="checkbox"],input[type="radio"]');

    // Default view on load
    $($inputs).each(function(){
        
        var $input = $(this);

        // For bootstrap to push the checked state, we need to 'click' the <li> parent element.
        if($input.is(':checked')){ $input.parent().trigger('click'); }
    
    });
}

// Activate bootstrap tooltip
function bootstrapTooltip()
{
	$trigger = $('body').find('.tooltip-trigger');

	if($trigger.length > 0)
	{
		$trigger.tooltip({

			trigger: 'hover click focus',
			animation: true

		});
	}
}

/*
|--------------------------------------------------------------------------
| Initiate our scripts
|--------------------------------------------------------------------------
|
| 
*/
$(document).ready(function(){

	buttonCheckable();
	bootstrapTooltip();

});