<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>BlueSky后台管理系统</title>
    <link rel="stylesheet" type="text/css" href="/ThinkPHP_BlueSky/Public/jquery-easyui-1.4.1/themes/default/easyui.css" />
    <link rel="stylesheet" type="text/css" href="/ThinkPHP_BlueSky/Public/jquery-easyui-1.4.1/themes/icon.css" />
    <script type="text/javascript" src="/ThinkPHP_BlueSky/Public/jquery-easyui-1.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="/ThinkPHP_BlueSky/Public/jquery-easyui-1.4.1/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/ThinkPHP_BlueSky/Public/jquery-easyui-1.4.1/locale/easyui-lang-zh_CN.js"></script>
</head>
<body>
<div class="easyui-dialog" title="登录" data-options="iconCls:'icon-tip',closable: false" style="width:420px;height:200px;padding:10px">
    <div style="padding:10px 60px 20px 60px;">
        <form id="ff" class="easyui-form" method="post" data-options="novalidate:true" action="/ThinkPHP_BlueSky/index.php/Admin/Index/login">
            <table cellpadding="5">
                <tr>
                    <td>用户名：</td>
                    <td><input class="easyui-textbox" type="text" name="name" data-options="required:true,prompt:'手机/邮箱/呢称'" ></input></td>
                </tr>
                <tr>
                    <td>密码：</td>
                    <td><input class="easyui-textbox" type="password" name="password" data-options="required:true"></input></td>
                </tr>
            </table>
        </form>
        <div style="text-align:center;padding:5px">
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">登录</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()">清空</a>
        </div>
    </div>
</div>
<script>
    function submitForm(){
        $('#ff').form('submit',{
            onSubmit:function(){
                return $(this).form('enableValidation').form('validate');
            },
            success:function(data){
                //alert(data);
                var d = $.parseJSON(data);
                if(d.state==1){
                    window.location= d.url;
                }else{
                    $.messager.alert('提示:', d.msg,'error');
                }
            }
        });
    }
    function clearForm(){
        $('#ff').form('clear');
    }
    //回车提交表单
    $.parser.onComplete = function(){
        $(".textbox-text").keyup(function (e) {
            if (e.keyCode == 13) {
                submitForm();
            }
        });
    };
</script>
</body>
</html>