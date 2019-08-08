<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="js/jquery-3.3.1.min.js"></script>
</head>
<body>
    <form action="<?= Yii::$app->urlManager->createUrl('hello/loginhandle');?>" method="get">
        <input name="_csrf" type="hidden" id="_csrf" value="<?=\Yii::$app->request->csrfToken ?>">
        姓名：
        <!--    <input type="text" name="username" value="--><?php //echo \yii\helpers\Html::encode($info); ?><!--">-->
        <input id="name" type="text" name="name" value="<?=$name?>" >
        <input type="submit" value="提交"> <input type="reset" value="重置"/>
    </form>
<script>
    $('#name').click(function(){
        alert('a');
    })
</script>
</body>
</html>