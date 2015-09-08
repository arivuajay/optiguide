<div class="cate-bg user-right">
    <h2> Favorite Retailers </h2>
    <div class="row">     
        <?php
        $rep_id = Yii::app()->user->id;
        $myfavourites = Yii::app()->db->createCommand() //this query contains all the data
                ->select('rr.ID_RETAILER,rr.COMPAGNIE,rt.NOM_TYPE_' . $this->lang)
                ->from(array('rep_favourites rf', 'repertoire_retailer rr', 'repertoire_retailer_type AS rt'))
                ->where("rr.ID_RETAILER=rf.ID_RETAILER AND rt.ID_RETAILER_TYPE=rr.ID_RETAILER_TYPE AND rf.rep_credential_id =" . $rep_id)
                ->order(',rf.id desc')
                ->queryAll();
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">  
            <div class="table-responsive">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                    <tr>
                        <th width="9%">S. No</th>
                        <th width="20%"> COMPAGNIE</th>
                        <th width="18%"> Type </th>
                        <th width="16%"> Actions </th>
                    </tr>
                    <?php
                    $fav_rets = '';
                    if (!empty($myfavourites)) {
                        $i=1;
                        foreach ($myfavourites as $favinfo) {
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo CHtml::link( $favinfo['COMPAGNIE'], array('/optirep/retailerDirectory/view', 'id' => $favinfo['ID_RETAILER'])); ?></td>
                                <td><?php echo $favinfo['NOM_TYPE_'.$this->lang]; ?></td>                               
                                <td>
                                    <div class="addfav-btn-listing"><input name="FAV" type="checkbox" checked=checked id="FAV" value="<?php echo $favinfo['ID_RETAILER']; ?>"></div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3"> No Records Found </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
$ajaxUpdatefav = Yii::app()->createUrl('/optirep/retailerDirectory/updatefav');
$js = <<< EOD
    $(document).ready(function () {
        
        $('input').iCheck({
                   checkboxClass: 'icheckbox_flat-pink',
                   radioClass: 'iradio_flat-pink'
               });
        
        $('input[name="FAV"]').on('ifClicked', function(event){    
            var ret_val =  $(this).attr("value");   
            if($(this).attr('checked')){
                var fav_status = 'removefav';
            }else{

                var fav_status = 'addfav';
            }

            var dataString = 'id='+ ret_val+'&favstatus='+fav_status;
               $.ajax({
                   type: "POST",
                   url: '{$ajaxUpdatefav}',
                   data: dataString,
                   cache: false,
                   success: function(html){             
                   }
                });

        });  
    });
EOD;
Yii::app()->clientScript->registerScript('_rep_favs_index', $js);
?>