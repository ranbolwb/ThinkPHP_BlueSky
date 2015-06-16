<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>欢迎光临</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="/ThinkPHP_BlueSky/Public/bootstrap-3.3.4-dist/css/bootstrap.min.css" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/ThinkPHP_BlueSky/Public/bootstrap-3.3.4-dist/js/html5shiv.min.js"></script>
    <script type="text/javascript" src="/ThinkPHP_BlueSky/Public/bootstrap-3.3.4-dist/js/respond.min.js"></script>
    <![endif]-->
    <style>
        label.valid {
            width: 24px;
            height: 24px;
            background: url(/ThinkPHP_BlueSky/Public/img/valid.png) center center no-repeat;
            display: inline-block;
            text-indent: -9999px;
        }
        label.error {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }
    </style>
    <!--<link rel="stylesheet" href="../../../../Public/bootstrap-3.3.4-dist/css/bootstrap.css">-->
</head>
<body>

<div class="modal" id="myModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="loginForm" class="form-horizontal" action="/ThinkPHP_BlueSky/index.php/Home/Index/doLogin" method="post">
                    <fieldset>
                        <div>
                            <legend class="text-center"><h1>登录</h1></legend>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">用户名</label>
                            <div class="controls col-sm-8">
                                <input type="text" class="form-control" id="name" name="name" placeholder="呢称/邮箱/手机">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">密码</label>
                            <div class="controls col-sm-8">
                                <input type="password" class="form-control" id="password" name="password" placeholder="密码">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="rememberme"> 记住我
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default center-block">登录</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal -->
</div>

<script type="text/javascript" src="/ThinkPHP_BlueSky/Public/bootstrap-3.3.4-dist/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/ThinkPHP_BlueSky/Public/bootstrap-3.3.4-dist/js/bootstrap.js"></script>
<script type="text/javascript" src="/ThinkPHP_BlueSky/Public/bootstrap-3.3.4-dist/js/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $("#myModal").show();
        //模态窗口垂直居中
        var $modal_dialog = $(".modal-dialog")
        var m_top = ( $(window).height() - $modal_dialog.height() ) / 2
        $modal_dialog.css({'margin': m_top + 'px auto'})

        //验证表单
        $('#loginForm').validate({
            rules: {
                name: {minlength: 2, required: true},
                password: {minlength: 2, required: true}
            }, messages: {
                name: {
                    required: "请输入用户名",
                    minlength: "请输入至少2个字符"
                },
                password: {
                    required: "请输入密码",
                    minlength: "请输入至少2个字符"
                }
            }, highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            }, success: function (element) {
                element.text('OK!').addClass('valid col-sm-1').closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        });
    });


</script>
</body>
</html>