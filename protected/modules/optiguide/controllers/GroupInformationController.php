<?php

class GroupInformationController extends OGController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $lang;

    public function __construct($id, $module = null) {
        $this->lang = Yii::app()->session['language'];
        parent::__construct($id, $module);
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array_merge(
                parent::accessRules(), array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(''),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(''),
                'users' => array(''),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
                )
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $searchModel = new GroupInformation('search');
        $searchModel->unsetAttributes();

        $page = Yii::app()->request->getParam('page');
        $page = isset($page) ? $page : 1;

        $limit = 0;
        if ($page > 1) {
            $offset = $page - 1;
            $limit = GROUPSLISTPERPAGE * $offset;
        }

        $from_table_array = array();
        $from_table_array[] = 'repertoire_renseignements_groupes rg';
        $from_table_array[] = 'repertoire_renseignements_section rs';
        $from_table_array[] = 'repertoire_renseignements_categorie rc';
        $from_table_array[] = 'repertoire_ville rv';
        $from_table_array[] = 'repertoire_region rr';
        $from_table_array[] = 'repertoire_pays rp';

        $where_conditions = '';
        $where_conditions .= 'rs.ID_SECTION=rg.ID_SECTION';
        $where_conditions .= ' AND rc.ID_CATEGORIE = rs.ID_CATEGORIE';
        $where_conditions .= ' AND rv.ID_VILLE = rg.ID_VILLE';
        $where_conditions .= ' AND rv.ID_REGION = rr.ID_REGION';
        $where_conditions .= ' AND rr.ID_PAYS = rp.ID_PAYS';

        if (isset($_GET['GroupInformation'])) {
            $searchModel->attributes = $_GET['GroupInformation'];
            if ($_GET['GroupInformation']['NOM_GROUPE']) {
                $search_keyword = $_GET['GroupInformation']['NOM_GROUPE'];
                $where_conditions .= " AND rg.NOM_GROUPE like '%{$search_keyword}%'";
            }

            if ($_GET['GroupInformation']['category']) {
                $search_category = $_GET['GroupInformation']['category'];
                $where_conditions .= " AND rc.ID_CATEGORIE = " . $search_category;
            }

            if ($_GET['GroupInformation']['country']) {
                $search_country = $_GET['GroupInformation']['country'];
                $where_conditions .= " AND rp.ID_PAYS = " . $search_country;
            }

            if ($_GET['GroupInformation']['region']) {
                $search_region = $_GET['GroupInformation']['region'];
                $where_conditions .= " AND rr.ID_REGION = " . $search_region;
            }
        }

        // Get all records
        $group_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select('rg.ID_GROUPE, rg.NOM_GROUPE, rs.ID_SECTION, rs.SECTION_' . $this->lang . ', rc.ID_CATEGORIE, rc.CATEGORIE_' . $this->lang . '')
                ->from($from_table_array)
                ->where($where_conditions)
                ->order('rc.CATEGORIE_' . $this->lang . ', rs.SECTION_' . $this->lang . ', rg.NOM_GROUPE')
                ->limit(GROUPSLISTPERPAGE, $limit)
                ->queryAll();

        // Get total counts of records    
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
                ->select('count(*) as count')
                ->from($from_table_array)
                ->where($where_conditions)
                ->queryScalar(); // do not LIMIT it, this must count all items!
        // the pagination itself      
        $pages = new CPagination($item_count);
        $pages->setPageSize(GROUPSLISTPERPAGE);

        $result = array();
        foreach ($group_query as $group) {
            $category_name = $group['CATEGORIE_' . $this->lang];
            $section_name = $group['SECTION_' . $this->lang];
            $result[$category_name][$section_name][$group['ID_GROUPE']] = $group['NOM_GROUPE'];
        }

        // render
        $this->render('index', array(
            'searchModel' => $searchModel,
            'model' => $result,
            'item_count' => $item_count,
            'page_size' => GROUPSLISTPERPAGE,
            'pages' => $pages,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $searchModel = new GroupInformation('search');
        $searchModel->unsetAttributes();

        $from_table_array = array();
        $from_table_array[] = 'repertoire_renseignements_groupes rg';
        $from_table_array[] = 'repertoire_renseignements_section rs';
        $from_table_array[] = 'repertoire_renseignements_categorie rc';
        $from_table_array[] = 'repertoire_ville rv';
        $from_table_array[] = 'repertoire_region rr';
        $from_table_array[] = 'repertoire_pays rp';

        $where_conditions = '';
        $where_conditions .= 'rs.ID_SECTION=rg.ID_SECTION';
        $where_conditions .= ' AND rc.ID_CATEGORIE = rs.ID_CATEGORIE';
        $where_conditions .= ' AND rv.ID_VILLE = rg.ID_VILLE';
        $where_conditions .= ' AND rv.ID_REGION = rr.ID_REGION';
        $where_conditions .= ' AND rr.ID_PAYS = rp.ID_PAYS';
        $where_conditions .= ' AND rg.ID_GROUPE = ' . $id;

        // Get all records
        $group_query = Yii::app()->db->createCommand() //this query contains all the data
                ->select('rg.*, rv.NOM_VILLE, rr.NOM_REGION_' . $this->lang . ', rp.NOM_PAYS_' . $this->lang . '')
                ->from($from_table_array)
                ->where($where_conditions)
                ->queryRow();

        $this->render('view', array(
            'model' => $group_query,
            'searchModel' => $searchModel,
        ));
    }

}
