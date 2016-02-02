<?php
/* @var $this MasterroleController */
/* @var $model MasterRole */

$this->title = 'View Master Role: ' . $model->Description;
$this->breadcrumbs = array(
    'Master Roles' => array('index'),
    'View ' . 'MasterRole',
);
?>

<div class="user-view">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'htmlOptions' => array('class' => 'table table-striped table-bordered'),
        'attributes' => array(
//            'Master_Role_ID',
            'Role_Code',
//            'Rank',
            'Description',         
            array(
                'label' => MasterRole::model()->getAttributeLabel('Active'),
                'type' => 'raw',
                'value' => ($model->Active == 1) ? '<i class="fa fa-circle text-green" title="Active"></i>' : '<i title="In-Active" class="fa fa-circle text-red"></i>'
            ),
        ),
    ));
    ?>
</div>
<?php
$rolenum = $model->Master_Role_ID;
$results = Yii::app()->db->createCommand() //this query contains all the data
                ->select('ar.Master_Resource_ID,ar.Master_Role_ID,ar.Master_Module_ID,ar.Master_Screen_ID,mm.Description AS modulename,ms.Description AS screenname,ar.Master_Task_ADD,ar.Master_Task_SEE,ar.Master_Task_UPT,ar.Master_Task_DEL')
                ->from(array('auth_resources AS ar' , 'master_screen AS ms' , 'master_module AS mm'))
                ->where("ar.Master_Module_ID=mm.Master_Module_ID AND ar.Master_Screen_ID=ms.Master_Screen_ID AND ar.Master_Role_ID=".$rolenum)              
                ->queryAll();
if(!empty($results))
{   
?>
<div class="row">
    <div class="col-lg-12 col-md-12" id="resources-block">
        <table class="table table-striped table-bordered">
            <thead class="bg-green">
            <td align="center" width="40%"><strong>Module / Screen Name</strong></td>
            <td align="center" width="15%"><strong>Add</strong><br /></td>
            <td align="center" width="15%"><strong>View</strong><br /></td>
            <td align="center" width="15%"><strong>Update</strong><br /></td>
            <td align="center" width="15%"><strong>Delete</strong><br /></td>
            </thead>
            <tbody>
                <?php 
                foreach($results as $infos)
                {
                   $taskadd = ($infos['Master_Task_ADD'])?"<i class='fa fa-check'></i>":"";
                   $tasksee = ($infos['Master_Task_SEE'])?"<i class='fa fa-check'></i>":"";
                   $taskupt = ($infos['Master_Task_UPT'])?"<i class='fa fa-check'></i>":"";
                   $taskdel = ($infos['Master_Task_DEL'])?"<i class='fa fa-check'></i>":"";
                   if($taskadd=="" && $tasksee==""  && $taskupt==""  && $taskdel=="")
                   {
                       continue;
                   }    
                ?>   
                <tr>
                    <td style="text-align:center;"><?php echo $infos['modulename']." / ".$infos['screenname']; ?></td>
                    <td style="text-align:center;"><?php echo $taskadd;?></td>
                    <td style="text-align:center;"><?php echo $tasksee;?></td>
                    <td style="text-align:center;"><?php echo $taskupt;?></i></td>
                    <td style="text-align:center;"><?php echo $taskdel;?></i></td>
                </tr>
                <?php                    
                }?>
            </tbody>
        </table>
    </div>
</div>
<?php }
 ?>

