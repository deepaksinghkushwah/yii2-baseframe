<?php
/* @var $this yii\web\View */
$this->title = "Search Employee Status";
$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue@2.6.12");
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/select2/js/select2.full.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/select2/css/select2.min.css');
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/select2/css/select2-bootstrap.min.css');
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/frontend/status-check.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
echo \yii\helpers\Html::hiddenInput("searchDepartmentURL", yii\helpers\Url::to(['/site/search-department'], true), ['id' => 'searchDepartmentURL']);
echo \yii\helpers\Html::hiddenInput("searchPositionURL", yii\helpers\Url::to(['/site/search-position'], true), ['id' => 'searchPositionURL']);
echo \yii\helpers\Html::hiddenInput("searchEmployeeURL", yii\helpers\Url::to(['/site/search-employee'], true), ['id' => 'searchEmployeeURL']);
?>
<h1 class="pageHeading"><?= $this->title ?></h1>
<?= app\components\BannerWidget::widget(); ?>
<br><br>
<div id="app" class="well">
    <div class="row">
        <div class="col-md-6">
            <label>
                Select Department
            </label>
            <select name="department" id="department" class="form-control"></select>
        </div>

        <div class="col-md-6">
            <label>Position</label>
            <select name="position" @change="searchEmployee" id="position" class="form-control"></select>
        </div>

    </div>
    <h4>List of employees</h4>   
    <span v-if="employees.length <= 0">No record found</span>
    <span v-if="employees.length > 0">
        <div class="row bg-primary">
            <div class="col-xs-3 col-md-3"><strong>Employee Name</strong></div>
            <div class="col-xs-3 col-md-3"><strong>Contact Number</strong></div>
            <div class="col-xs-3 col-md-3"><strong>Status</strong></div>
            <div class="col-xs-3 col-md-3"><strong>Last Updated</strong></div>
        </div>
        <div class="row row-striped" v-for="row in employees">
            <div class="col-xs-3 col-md-3">{{ row.text }}</div>
            <div class="col-xs-3 col-md-3">{{ row.contact_number }}</div>
            <div class="col-xs-3 col-md-3">
                <img title="On seat" v-if="row.currentStatus == 1" src="<?= yii\helpers\Url::to(['/images/greenCircle.png'], true) ?>"/>
                <img title="Not on seat" v-if="row.currentStatus == 0" src="<?= yii\helpers\Url::to(['/images/redCircle.png'], true) ?>"/>
            </div>
            <div class="col-xs-3">{{ row.lastUpdated }}</div>
        </div>
    </span>
    <!--<table class="table table-striped">
        <tr>
            <td width="20%">Select Department</td>
            <td width="40%">
                <select name="department" id="department" class="form-control"></select>
            </td>
            <td width="10%">Position</td>
            <td width="30%"><select name="position" @change="searchEmployee" id="position" class="form-control"></select></td>
        </tr>
    </table>-->
    
    <!--<table class="table table-bordered table-striped" v-if="employees.length > 0">
        <thead>
            <tr>
                <th width="40%">Employee</th>
                <th width="20%">Contact Number</th>
                <th width="20%">Current Status</th>
                <th width="20%">Last Updated</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in employees">
                <td>{{ row.text }}</td>
                <td>{{ row.contact_number }}</td>
                <td>
                    <img title="On seat" v-if="row.currentStatus == 1" src="<?= yii\helpers\Url::to(['/images/greenCircle.png'], true) ?>"/>
                    <img title="Not on seat" v-if="row.currentStatus == 0" src="<?= yii\helpers\Url::to(['/images/redCircle.png'], true) ?>"/>
                </td>
                <td>{{ row.lastUpdated }}</td>
            </tr>
        </tbody>

    </table>-->

</div>