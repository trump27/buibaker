# BuiBaker plugin for CakePHP

BootstrapUIをするときのサンプルlayoutと、TemplateのBake用テーマ。

## Requirements

* CakePHP 3.x
* Twitter Bootstrap 3.x
* [BootstrapUI](https://github.com/FriendsOfCake/bootstrap-ui)

## インストールと設定

Composerで追加

```
composer require trump27/buibaker
```

プラグイン追加

```
Plugin::load('BootstrapUI');
Plugin::load('BuiBaker');
```

BootstrapUIのプラグイン読み込み `src\View\AppView`

```
public $layout = 'BuiBaker.default';

public function initialize()
{
    $this->loadHelper('Html', ['className' => 'BootstrapUI.Html']);
    $this->loadHelper('Form', ['className' => 'BootstrapUI.Form']);
    $this->loadHelper('Flash', ['className' => 'BootstrapUI.Flash']);
    $this->loadHelper('Paginator', ['className' => 'BootstrapUI.Paginator']);
}
```

model, controllerを作成後、templateをbake

```
$ bin/cake bake.bake [subcommand] -t BuiBaker
```
## ライセンス

Copyright (c) 2015, trump27 and licensed under The MIT License.
