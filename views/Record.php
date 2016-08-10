<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>明細</title>
  </head>

  <body>
     <h1 style="color: red;" align="center">交易明細</h1>
      <form id="form1" name="form1" method="post" action="<?= $root ?>/Bank/GuestsRecord">
        <table width="320" border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#000000">
          <tr>
            <td colspan="2" align="center" bgcolor="#77FF00"><font color="#000000">輸入您的帳戶查詢</font></td>
          </tr>
          <tr>
            <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><a href="<?= $root ?>/Bank/Transaction"><font color="#000000">出入款</font></a></td>
            <td width="80" align="center" valign="baseline" bgcolor="#AAAAAA"><a href="<?= $root ?>/Bank/Record"><font color="#000000">帳目明細</font></a></td>
          </tr>
          <tr>
            <td colspan="2" width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">帳戶</font></td>
          </tr>
          <tr>
            <td colspan="2" width="80" align="center" valign="baseline" bgcolor="#FFFFFF">
              <input type="text" name="userId" style= "color:#000000 ; width:250px; text-align:center;" placeholder="請輸入帳戶" />
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center" bgcolor="#77FF00">
            <input type="submit" name="btnQuery" id="btnQuery" value="查詢"   style=background-color:pink;color:#000000 />
            </td>
          </tr>
          <?php if ($data['Money']) { ?>
          <tr>
            <td  align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">目前餘額</font></td>
            <td  align="center" valign="baseline" bgcolor="#FFFFFF"><font color="red"><?= $data['Money'] ?></font></td>
          </tr>
          <?php }elseif ($data['nameId'] != null){ ?>
          <tr>
            <td  align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">目前餘額</font></td>
            <td  align="center" valign="baseline" bgcolor="#FFFFFF"><font color="red">0</font></td>
          </tr>
          <?php } ?>
        </table>
      </form>
      <br>
    <table  border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#000000">
      <tr>
        <td colspan="5" align="center" bgcolor="#77FF00"><font color="#000000">明細</font></td>
      </tr>
      <tr>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">帳戶</font></td>
        <td width="150" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">時間</font></td>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">取款</font></td>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">存款</font></td>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">餘額</font></td>
      </tr>

      <?php

      if($data['Record']){
          foreach($data['Record'] as $row) {  ?>
            <tr>
              <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000"><?= $row['NameID'] ?></font></td>
              <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000"><?= $row['Date'] ?></font></td>
              <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="red"><?= $row['MoneyOUT'] ?></font></td>
              <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="blue"><?= $row['MoneyIN'] ?></font></td>
              <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000"><?= $row['Money'] ?></font></td>
            </tr>
      <?php

          }
      }

      ?>

    </table>
  </body>
</html>