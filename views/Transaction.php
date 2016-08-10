<?php
if ($data['result'] == true) {
    echo "<script language='javascript'> alert('成功'); </script>";
}

if ($data['msg']) {
    echo "<script language='javascript'> alert('{$data['msg']}'); </script>";
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>銀行</title>

  </head>

  <body>
     <h1 style="color: red;" align="center">銀行</h1>
      <form id="form1" name="form1" method="post" action="<?= $root ?>/Bank/InTrade">
        <table width="320" border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#000000">
          <tr>
            <td colspan="2" align="center" bgcolor="#77FF00"><font color="#000000">輸入帳號及動作</font></td>
          </tr>
          <tr>
            <td width="80" align="center" valign="baseline" bgcolor="#AAAAAA">
              <a href="<?= $root ?>/Bank/Transaction"><font color="#000000">出入款</font></a>
            </td>
            <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF">
              <a href="<?= $root ?>/Bank/Record"><font color="#000000">帳目明細</font></a>
            </td>
          </tr>
          <tr>
            <td colspan="2" width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">帳戶</font></td>
          </tr>
          <tr>
            <td colspan="2" width="80" align="center" valign="baseline" bgcolor="#FFFFFF">
              <input type="text" name="userId"  style= "color:#000000 ; width:250px; text-align:center;" placeholder="請輸入帳戶" />
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="baseline" bgcolor="#FFFFFF">
              <input type=radio value="deposit" name="action" checked ><font color="red"> 存錢</font>  <!-- checked 為預設選項 -->
              <input type=radio value="withdraw" name="action" ><font color="red"> 取錢</font>
            </td>
          </tr>
          <tr>
            <td colspan="2" width="80" align="center" valign="baseline" bgcolor="#FFFFFF">
              <input type="text" name="tradeMoney" style= "color:#000000 ; width:250px; text-align:center;" placeholder="請輸入金額" />
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center" bgcolor="#77FF00">
            <input type="submit" name="btnOK" id="btnOK" value="確認送出"  style=background-color:pink;color:#000000 />
            </td>
          </tr>
        </table>
      </form>
  </body>
</html>