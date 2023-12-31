<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\Menu;
use app\models\MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Menu();

        if ($model->load(Yii::$app->request->post())) {
            $model->menu_type = (in_array($model->location, ['left', 'right', 'bottom']) ? 2 : 1);
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->menu_type = (in_array($model->location, ['left', 'right', 'bottom']) ? 2 : 1);
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMenuItems() {
        $this->layout = 'empty';
        $menuId = Yii::$app->request->get('menu_id');
        $menu = Menu::findOne(['id' => $menuId]);
        $existingMenuIds = Yii::$app->db->createCommand("SELECT item_id FROM `menu_item` WHERE menu_id= '$menuId'")->queryColumn();
        $existing = [];
        foreach ($existingMenuIds as $item) {
            $existing[$item] = ['selected' => 'selected'];
        }
        //print_r($existing);


        $model = new \app\models\MenuItem();


        if ($model->load(Yii::$app->request->post())) {
            \app\models\MenuItem::deleteAll(['menu_id' => $menuId]);

            switch ($menu->menu_item_type) {
                case '1':
                    if (count($model->item_id) > 0) {
                        foreach ($model->item_id as $item) {

                            $m = new \app\models\MenuItem();
                            $m->menu_id = $menuId;
                            $m->item_id = $item;
                            if (!$m->save()) {
                                echo "<pre>";
                                print_r($m->getErrors());
                                echo "</pre>";
                                exit;
                            }
                        }
                    }
                    break;
                case '2':
                    $m = new \app\models\MenuItem();
                    $m->menu_id = $menuId;
                    $m->item_id = $model->item_id;
                    if (!$m->save()) {
                        echo "<pre>";
                        print_r($m->getErrors());
                        echo "</pre>";
                        exit;
                    }
                    break;
            }
            Yii::$app->session->setFlash('success', 'Menu items saved');
            return $this->refresh();
        }

        return $this->render('menu-items', ['model' => $model, 'menuId' => $menuId, 'menu' => $menu, 'existing' => $existing]);
    }

}
