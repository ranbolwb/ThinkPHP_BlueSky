<?php if (!defined('THINK_PATH')) exit();?><div style="padding:10px 60px 20px 60px;">
<form id="formChangePassword" class="easyui-form" method="post" data-options="novalidate:true" action="/ThinkPHP_BlueSky/index.php/Admin/Index/doChangePassword">
    <table cellpadding="5">
        <tr>
            <td>原密码：</td>
            <td><input class="easyui-textbox" type="password" name="oldpwd" data-options="required:true," ></input></td>
        </tr>
        <tr>
            <td>新密码：</td>
            <td><input class="easyui-textbox" type="password" id="newpwd" name="newpwd" data-options="required:true,validType:'length[4,32]'"></input></td>
        </tr>
        <tr>
            <td>确认密码：</td>
            <td><input class="easyui-textbox" type="password" name="newpwd2" data-options="required:true" validType="equalTo['#newpwd']" invalidMessage="两次输入密码不匹配"></input></td>
        </tr>
    </table>
</form>
<div style="text-align:center;padding:5px">
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">保存</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()">清空</a>
</div>
    </div>
<script>
    function submitForm(){
        $('#formChangePassword').form('submit',{
            onSubmit:function(){
                return $(this).form('enableValidation').form('validate');
            },
            success:function(data){
                //alert(data);
                var d = $.parseJSON(data);
                if(d.state==1){
                    $.messager.alert('提示:', "密码修改成功，下次登录请用新密码！",'info',function(){
                        $("#divChangePassword").dialog("close");
                    });
                }else{
                    $.messager.alert('提示:', d.msg,'error');
                }
            }
        });
    }
    function clearForm(){
        $('#formChangePassword').form('clear');
    }
    $.parser.parse('#formChangePassword');
    $.parser.onComplete = function(){
        $("#formChangePassword .textbox-text").keyup(function (e) {
            if (e.keyCode == 13) {
                submitForm();
            }
        });
    }
</script>