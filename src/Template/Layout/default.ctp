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
    <?php //$this->Html->css('css/bootstrap.min.css') ?>

    <?= $this->fetch('css') ?>
    <?= $this->Html->css('BuiBaker.main.css') ?>

</head>
<body>

    <div id="contents">
        <div id="sidebar">
            <div class="brand"><a href="#">Brand</a></div>
            <ul class="side-nav">
                <li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span>Menu1</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-book"></span>Menu2</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-certificate"></span>Menu3</a></li>
            </ul>
        </div>

        <div class="main-content">
            <a id="menu-toggle" href="#" class="btn btn-default">
                <span class="glyphicon glyphicon-th"></span>
            </a>

            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </div>


    <footer class="text-right">
        &copy; <?= date('Y') ?> &nbsp; trump27
    </footer>

    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <?php // $this->Html->script('jquery/jquery.min.js',['block'=>true]); ?>
    <?php // $this->Html->script('bootstrap/bootstrap.min.js',['block'=>true]); ?>

    <?= $this->fetch('script') ?>
<script>
$(document).ready(function () {
    $('#menu-toggle').click(function (e) {
        e.preventDefault();
        $('#contents').toggleClass('active');
    });
});
</script>
</body>
</html>
