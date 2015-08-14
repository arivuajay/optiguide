<tr id="pollchoice-<?php echo $id ?>">
  <td class="labeltxt col-sm-5" style="padding-top: .5em; padding-bottom: .5em;">
    <?php echo CHtml::activeTextField($choice,"[$id]label",array('class' => 'form-control','size'=>60)); ?>
    <?php echo CHtml::error($choice,"[$id]label"); ?>
    <div class="errorMessage" style="display:none">You must enter a label.</div>
  </td>
  <td class="actions col-sm-2">
  <?php
    $deleteJs = 'jQuery("#pollchoice-'. $id .'").find("td").fadeOut(1000,function(){jQuery(this).parent().remove();});return false;';

    if (isset($choice->id)) {
      // Add AJAX delete link
      echo CHtml::ajaxLink(
        '<i class="glyphicon glyphicon-trash"></i>',
        array('/admin/pollchoice/delete', 'id' => $choice->id, 'ajax' => TRUE),
        array('type' => 'POST', 'success' => 'js:function(){'. $deleteJs .'}'),
        array('confirm' => 'Are you sure you want to delete this item?')
      );
    }
    else {
      // Model hasn't been created yet, so just remove the DOM element
      echo CHtml::link('<i class="glyphicon glyphicon-trash"></i>', '#', array('onclick' => 'js:'. $deleteJs));
    }
    // Add additional hidden fields
    echo CHtml::activeHiddenField($choice,"[$id]id");
  ?>
  </td>
</tr>
