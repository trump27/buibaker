<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
         <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->fetch('meta') ?>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <?= $this->fetch('css') ?>
    <?= $this->Html->css('BuiBaker.main.css') ?>

</head>
<body>

    <div class="contents">
        <div class="sidebar">
            <div class="brand">Brand</div>
            <ul class="side-nav">
                <!--<li class="heading">Actions</li>-->
                <li><a href="#"><span class="glyphicon glyphicon-book"></span>Menu1</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-home"></span>Menu2</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-certificate"></span>Menu3</a></li>
            </ul>
        </div>

        <div class="main-content">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
        </div>
    </div>


    <footer class="text-right">
        &copy; <?= date('Y') ?> &nbsp; trump27
    </footer>

    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <?= $this->fetch('script') ?>

</body>
</html>
