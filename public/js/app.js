var $collectionHolder;
var $addNewItem = jQuery('<a href="#" class="btn btn-info">Añadir</a>');

jQuery(document).ready(function () {
    $collectionHolder = jQuery('#pedidoproducto_list');
    $collectionHolder.append($addNewItem);
    $collectionHolder.data('index', $collectionHolder.find('.panel').length)
    
    $collectionHolder.find('.panel').each(function () {
        addRemoveButton(jQuery(this));
    });

    $addNewItem.click(function (e) {
        e.preventDefault();
        addNewForm();
    })
});

function addNewForm() {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index+1);
    var $panel = jQuery('<div class="panel panel-warning"><div class="panel-heading"></div></div>');
    var $panelBody = jQuery('<div class="panel-body"></div>').append(newForm);
    
    $panel.append($panelBody);
    addRemoveButton($panel);
    $addNewItem.before($panel);
}

function addRemoveButton ($panel) {
    var $removeButton = jQuery('<a href="#" class="btn btn-danger">Eliminar</a>');
    var $panelFooter = jQuery('<div class="panel-footer"></div>').append($removeButton);
    $removeButton.click(function (e) {
        e.preventDefault();
        jQuery(e.target).parents('.panel').remove();        
    });
    
    $panel.append($panelFooter);
}